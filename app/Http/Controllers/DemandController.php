<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DemandController extends Controller
{
    public function demandindex()
    {
        $commodities = DB::connection('mysql_secondary')
            ->table('commodities as a')
            ->select(
                'a.*',
            )
            ->orderBy('a.comm', 'asc')
            ->paginate(10, ['*'], 'commodities_page');

        $commoditiesSelect = DB::connection('mysql_secondary')
            ->table('commodities as a')
            ->select(
                'a.*',
            )
            ->orderBy('a.comm', 'asc')
            ->get();
        return view('demand.index', [
            'commodities' => $commodities,
            'commoditiesSelect' => $commoditiesSelect
        ]);
    }

    public function demandsearch(Request $request)
    {
        $commodityId = $request->input('commodity_id');

        $commodities = DB::connection('mysql_secondary')
            ->table('commodities as a')
            ->where('a.id', $commodityId)
            ->select(
                'a.*',
            )
            ->orderBy('a.comm', 'asc')
            ->paginate(10, ['*'], 'commodities_page');

        $commoditiesSelect = DB::connection('mysql_secondary')
            ->table('commodities as a')
            ->select(
                'a.*',
            )
            ->orderBy('a.comm', 'asc')
            ->get();
        return view('demand.index', [
            'commodities' => $commodities,
            'commoditiesSelect' => $commoditiesSelect
        ]);
    }

    public function demandshow($id)
    {

        $commodity = DB::connection('mysql_secondary')
            ->table('commodities as a')
            ->where('a.id', $id)
            ->select(
                'a.*',
            )
            ->first();

        $orders = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->select(
                'transaction_date',
                DB::raw('SUM(quantity_adjusted) as total_adjusted')
            )
            ->where('commodity_id', $id)
            ->where('quantity_adjusted', '>', 0)
            ->where('selling_type', 'Wholesale')
            ->groupBy('transaction_date')
            ->get();

        $suppliesForApproval = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->select(
                'transaction_date',
                DB::raw('SUM(quantity_adjusted) as total_adjusted')
            )
            ->where('commodity_id', $id)
            ->where('quantity_adjusted', '>', 0)
            ->where('status', '1')
            ->where('selling_type', 'Farmgate')
            ->groupBy('transaction_date')
            ->get();

        $suppliesApproved = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->select(
                'transaction_date',
                DB::raw('SUM(quantity_adjusted) as total_adjusted')
            )
            ->where('commodity_id', $id)
            ->where('quantity_adjusted', '>', 0)
            ->where('status', '2')
            ->where('selling_type', 'Farmgate')
            ->groupBy('transaction_date')
            ->get();

        return view('demand.show', [
            'commodity' => $commodity,
            'orders' => $orders,
            'suppliesForApproval' => $suppliesForApproval,
            'suppliesApproved' => $suppliesApproved,
        ]);
    }

    public function demandstore(Request $request)
    {
        $request->validate([
            'commodity_id' => 'required',
            'quantity' => 'required|numeric',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
            'frequency' => 'required|array',
            'frequency.*' => 'integer|min:1|max:7',
        ]);

        $commodity_id = $request->commodity_id;
        $quantity = $request->quantity;
        $from_date = Carbon::parse($request->from_date);
        $to_date = Carbon::parse($request->to_date);
        $selectedDays = $request->frequency;
        $name_id = Auth::guard('partner')->user()->id;

        $price = DB::connection('mysql_secondary')
            ->table('commodities')
            ->where('id', $commodity_id)
            ->value('comm_fgp');

        $records = [];
        $conflictDates = [];

        // Fetch existing commitments for this user & commodity in date range
        $existingDates = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', $name_id)
            ->where('commodity_id', $commodity_id)
            ->whereBetween('transaction_date', [$from_date->toDateString(), $to_date->toDateString()])
            ->pluck('transaction_date')
            ->toArray();

        // Build new records & check conflicts
        for ($date = $from_date->copy(); $date->lte($to_date); $date->addDay()) {
            if (in_array($date->dayOfWeekIso, $selectedDays)) {
                $dateString = $date->toDateString();

                if (in_array($dateString, $existingDates)) {
                    $conflictDates[] = $dateString;
                    continue;
                }

                $currentDate = $date->format('Ymd');
                $microtime = str_replace('.', '', microtime(true));
                $transaction_number = 'TRC-' . $currentDate . '-' . $microtime . '-' . rand(1000, 9999) . $name_id;

                $records[] = [
                    'code' => Str::uuid() . $name_id,
                    'transaction_number' => $transaction_number,
                    'transaction_date' => $dateString,
                    'name_id' => $name_id,
                    'farmer_id' => $name_id,
                    'commodity_id' => $commodity_id,
                    'commodity_class' => 'A',
                    'selling_type' => 'Farmgate',
                    'price' => $price,
                    'quantity_committed' => $quantity,
                    'quantity_adjusted' => $quantity,
                    'quantity_delivered' => 0,
                    'status' => 0,
                    'user_id' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        if (!empty($records)) {
            DB::connection('mysql_secondary')
                ->table('pre_transactions')
                ->insert($records);
        }

        if (!empty($conflictDates)) {
            $message = 'Some dates were skipped because you already have commitments for this commodity on these dates: ' . implode(', ', $conflictDates) . '. Please update your commitments accordingly.';
            $conflictIds = DB::connection('mysql_secondary')
                ->table('pre_transactions')
                ->where('name_id', $name_id)
                ->where('commodity_id', $commodity_id)
                ->whereIn('transaction_date', $conflictDates)
                ->pluck('id')
                ->toArray();

            return redirect()->route('demand.checkout')->with([
                'warning' => $message,
                'conflict_ids' => $conflictIds,
            ]);
        }

        return redirect()->route('demand.checkout')->with('success', 'Commitments saved successfully.');
    }


    public function demandcheckout()
    {
        $userId = Auth::guard('partner')->user()->id;

        $orderList = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('a.name_id', $userId)
            ->where('a.status', 0)
            ->where('a.quantity_adjusted', '>', 0)
            ->select(
                'a.*',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
                DB::raw('DATE_ADD(a.transaction_date, INTERVAL 14 DAY) as transaction_date_plus')
            )
            ->orderBy('a.transaction_date', 'desc')
            ->orderBy('a.quantity_adjusted', 'desc')
            ->paginate(10, ['*'], 'orderList_page');

        $commodityName = DB::connection('mysql_secondary')
            ->table('commodities')
            ->value('comm');

        return view('demand.checkout', [
            'orderList' => $orderList,
            'commodityName' => $commodityName,
        ]);
    }

    public function demanddelete(Request $request)
    {
        $ids = $request->input('selected_orders');
        if ($ids) {
            DB::connection('mysql_secondary')
                ->table('pre_transactions')->whereIn('id', $ids)->delete();
        }
        return redirect()->back()->with('success', 'Commitments deleted.');
    }

    public function demandadjust(Request $request)
    {
        $ids = $request->input('selected_orders');
        $adjustedQty = $request->input('adjusted_quantity');
        $reason = $request->input('reason');

        if ($ids && $adjustedQty !== null) {
            DB::connection('mysql_secondary')
                ->table('pre_transactions')->whereIn('id', $ids)->update(['quantity_adjusted' => $adjustedQty]);
            // Optionally log reason somewhere
        }
        return redirect()->back()->with('success', 'Commitments adjusted.');
    }

    public function demandsendcheckout(Request $request)
    {
        $ids = $request->input('selected_orders');

        if ($ids) {
            DB::connection('mysql_secondary')
                ->table('pre_transactions')
                ->whereIn('id', $ids)
                ->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Commitments checked out successfully.');
    }

    public function demandconflictupdate($ids)
    {
        $idsArray = explode(',', $ids);

        $conflictingTransactions = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->whereIn('id', $idsArray)
            ->orderBy('transaction_date')
            ->get();

        return view('demand.conflict', [
            'conflictingTransactions' => $conflictingTransactions,
        ]);
    }

    public function demandconflictupdatesave(Request $request)
    {
        $data = $request->input('transactions', []);

        foreach ($data as $transactionData) {
            DB::connection('mysql_secondary')
                ->table('pre_transactions')
                ->where('id', $transactionData['id'])
                ->update([
                    'quantity_adjusted' => $transactionData['quantity_adjusted'],
                    'updated_at' => now(),
                ]);
        }

        return redirect()->route('demand.checkout')->with('success', 'Commitments updated successfully.');
    }
}
