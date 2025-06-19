<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function ordersapprovedindex()
    {
        $maxDateCommitted = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', Auth::guard('partner')->user()->id)
            ->where('status', 2)
            ->max('transaction_date');

        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $nextDateCommitted = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', Auth::guard('partner')->user()->id)
            ->where('status', 2)
            ->whereDate('transaction_date', '>', $today)
            ->orderBy('transaction_date', 'asc')
            ->value('transaction_date');

        $dateFrom = Carbon::now('Asia/Manila')->addDay()->format('Y-m-d');
        $dateTo = $maxDateCommitted;
        $userId = Auth::guard('partner')->user()->id;

        $scheduledCommitment = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('a.transaction_date', $today)
            ->where('a.name_id', $userId)
            ->where('a.status', 2)
            ->where('a.quantity_adjusted', '>', 0)
            ->select(
                'a.commodity_id as commodity_id',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
                DB::raw('IFNULL(SUM(a.quantity_adjusted),0) as total_quantity_adjusted'),
                DB::raw('IFNULL(SUM(a.quantity_delivered),0) as total_quantity_delivered')
            )
            ->groupBy('a.commodity_id', 'b.comm')
            ->orderBy('b.comm', 'asc')
            // ->limit(3)
            ->paginate(10, ['*'], 'scheduledCommitment_page');

        $scheduledOfNextCommitment = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('a.transaction_date', $nextDateCommitted)
            ->where('a.name_id', $userId)
            ->where('a.status', 2)
            ->where('a.quantity_adjusted', '>', 0)
            ->select(
                'a.commodity_id as commodity_id',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
                DB::raw('IFNULL(SUM(a.quantity_adjusted),0) as total_quantity_adjusted'),
                DB::raw('IFNULL(SUM(a.quantity_delivered),0) as total_quantity_delivered')
            )
            ->groupBy('a.commodity_id', 'b.comm')
            ->orderBy('b.comm', 'asc')
            // ->limit(3)
            ->paginate(10, ['*'], 'scheduledOfNextCommitment_page');

        $scheduledFutureCommitment = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->where('a.name_id', $userId)
            ->where('a.status', 2)
            ->where('a.quantity_adjusted', '>', 0)
            ->select(
                'a.commodity_id as commodity_id',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
                DB::raw('IFNULL(SUM(a.quantity_adjusted),0) as total_quantity_adjusted'),
                DB::raw('IFNULL(SUM(a.quantity_delivered),0) as total_quantity_delivered')
            )
            ->groupBy('a.commodity_id', 'b.comm', 'b.id')
            ->orderBy('b.comm', 'asc')
            // ->limit(3)
            ->paginate(10, ['*'], 'scheduledFutureCommitment_page');

        return view('orders.approved.index', [
            'scheduledCommitment' => $scheduledCommitment,
            'scheduledFutureCommitment' => $scheduledFutureCommitment,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'today' => $today,
            'nextDateCommitted' => $nextDateCommitted,
            'scheduledOfNextCommitment' => $scheduledOfNextCommitment,
        ]);
    }

    public function ordersapprovedshow($id)
    {
        $maxDateCommitted = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', Auth::guard('partner')->user()->id)
            ->where('status', 2)
            ->max('transaction_date');

        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $dateFrom = request('date_from') ?? Carbon::now('Asia/Manila')->addDay()->format('Y-m-d');
        $dateTo = request('date_to') ?? $maxDateCommitted;
        $userId = Auth::guard('partner')->user()->id;

        $orderList = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->whereBetween('a.transaction_date', [$dateFrom, $dateTo])
            ->where('a.name_id', $userId)
            ->where('a.commodity_id', $id)
            ->where('a.status', 2)
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
            ->where('id', $id)
            ->value('comm');

        return view('orders.approved.show', [
            'orderList' => $orderList,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'today' => $today,
            'commodityName' => $commodityName,
        ]);
    }

    public function ordersapprovedcancel(Request $request)
    {
        $ids = $request->input('selected_orders', []);
        $actionType = $request->input('action_type'); // 'cancel' or 'adjust'
        $reason = $request->input('cancel_reason');
        $adjustedQty = $request->input('adjusted_quantity');

        if (!empty($ids) && $reason !== null) {
            $newQty = ($actionType === 'cancel') ? 0 : $adjustedQty;

            DB::connection('mysql_secondary')
                ->table('pre_transactions')
                ->whereIn('id', $ids)
                ->update([
                    'quantity_adjusted' => $newQty,
                    'reason' => $reason,
                ]);
        }

        return redirect()->back()->with('success', 'Selected commitments updated.');
    }

    public function ordersforapprovalindex()
    {
        $maxDateCommitted = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', Auth::guard('partner')->user()->id)
            ->where('status', 1)
            ->max('transaction_date');

        $dateFrom = Carbon::now('Asia/Manila')->addDay()->format('Y-m-d');
        $dateTo = $maxDateCommitted;
        $userId = Auth::guard('partner')->user()->id;

        $scheduledFutureForApprovalCommitment = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->whereBetween('transaction_date', [$dateFrom, $dateTo])
            ->where('a.name_id', $userId)
            ->where('a.status', 1)
            ->where('a.quantity_adjusted', '>', 0)
            ->select(
                'a.commodity_id as commodity_id',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
                DB::raw('IFNULL(SUM(a.quantity_adjusted),0) as total_quantity_adjusted'),
                DB::raw('IFNULL(SUM(a.quantity_delivered),0) as total_quantity_delivered')
            )
            ->groupBy('a.commodity_id', 'b.comm', 'b.id')
            ->orderBy('b.comm', 'asc')
            // ->limit(3)
            ->paginate(10, ['*'], 'scheduledFutureForApprovalCommitment_page');

        return view('orders.forapproval.index', [
            'scheduledFutureForApprovalCommitment' => $scheduledFutureForApprovalCommitment,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo
        ]);
    }

    public function ordersforapprovalshow($id)
    {
        $maxDateCommitted = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', Auth::guard('partner')->user()->id)
            ->where('status',  1)
            ->max('transaction_date');

        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $dateFrom = request('date_from') ?? Carbon::now('Asia/Manila')->addDay()->format('Y-m-d');
        $dateTo = request('date_to') ?? $maxDateCommitted;
        $userId = Auth::guard('partner')->user()->id;

        $orderList = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->whereBetween('a.transaction_date', [$dateFrom, $dateTo])
            ->where('a.name_id', $userId)
            ->where('a.commodity_id', $id)
            ->where('a.status', 1)
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
            ->where('id', $id)
            ->value('comm');

        return view('orders.forapproval.show', [
            'orderList' => $orderList,
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'today' => $today,
            'commodityName' => $commodityName,
        ]);
    }

    public function ordersforapprovalcancel(Request $request)
    {
        $ids = $request->input('selected_orders', []);
        $actionType = $request->input('action_type'); // 'cancel' or 'adjust'
        $reason = $request->input('cancel_reason');
        $adjustedQty = $request->input('adjusted_quantity');

        if (!empty($ids) && $reason !== null) {
            $newQty = ($actionType === 'cancel') ? 0 : $adjustedQty;

            DB::connection('mysql_secondary')
                ->table('pre_transactions')
                ->whereIn('id', $ids)
                ->update([
                    'quantity_adjusted' => $newQty,
                    'reason' => $reason,
                ]);
        }

        return redirect()->back()->with('success', 'Selected commitments updated.');
    }
}
