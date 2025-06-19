<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class SalesController extends Controller
{
    public function salesincomeindex()
    {
        $currentMonth = Carbon::now()->format('Y-m');

        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $userId = Auth::guard('partner')->user()->id;

        $overallIncome = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                DB::raw('IFNULL(SUM(price * quantity_delivered),0) as overall_income'),
            )
            ->groupBy('name_id')
            ->first();

        $totalIncome = $overallIncome->overall_income ?? 0;

        $incomeToday = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', $userId)
            ->where('transaction_date', $today)
            ->select(
                DB::raw('IFNULL(SUM(price * quantity_delivered),0) as income_today'),
            )
            ->groupBy('name_id')
            ->first();

        $totalIncomeToday = $incomeToday->income_today ?? 0;

        $detailsIncomeToday = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('name_id', $userId)
            ->where('transaction_date', $today)
            ->where('quantity_delivered', ">", 0)
            ->select(
                'a.transaction_date',
                'b.comm as commodity_name',
                'a.commodity_class',
                'a.price',
                'a.quantity_delivered',
                DB::raw('(price * quantity_delivered) as total_income'),
            )
            ->orderBy('b.comm', 'asc')
            ->get();

        $monthlyIncome = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                DB::raw('YEAR(transaction_date) as year'),
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(price * quantity_delivered) as income')
            )
            ->groupBy(DB::raw('YEAR(transaction_date), MONTH(transaction_date)'))
            ->orderByRaw('YEAR(transaction_date), MONTH(transaction_date)')
            ->get();

        $years = [];
        $formatted = [];

        // Collect unique years and organize income by year/month
        foreach ($monthlyIncome as $row) {
            $years[] = $row->year;
            $formatted[$row->year][$row->month] = round($row->income, 2);
        }

        $years = array_unique($years);
        sort($years);

        // Prepare 12 months
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $datasets = [];

        foreach ($years as $year) {
            $data = [];
            for ($m = 1; $m <= 12; $m++) {
                $data[] = $formatted[$year][$m] ?? 0;
            }

            $datasets[] = [
                'label' => (string) $year,
                'data' => $data,
                'fill' => false,
                'borderColor' => '#' . substr(md5($year), 0, 6),
                'tension' => 0.1
            ];
        }

        $commodityEarnings = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                DB::raw('YEAR(transaction_date) as year'),
                'b.id',
                'b.comm as commodity_name',
                DB::raw('SUM(price * quantity_delivered) as total_income')
            )
            ->groupBy(DB::raw('YEAR(transaction_date)'), 'b.comm', 'b.id')
            ->get();

        $commodityByYear = [];
        $years = [];

        foreach ($commodityEarnings as $earning) {
            $years[] = $earning->year;
            $commodityByYear[$earning->year][] = [
                'commodity_name' => $earning->commodity_name,
                'total_income' => round($earning->total_income, 2),
            ];
        }

        // Sort and keep only top 5 per year
        foreach ($commodityByYear as $year => $commodities) {
            usort($commodities, function ($a, $b) {
                return $b['total_income'] <=> $a['total_income'];
            });

            $commodityByYear[$year] = array_slice($commodities, 0, 5);
        }

        $years = array_unique($years);
        sort($years);


        $totalEarningPerCommodity = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                'b.id',
                'b.comm as commodity_name',
                DB::raw('SUM(price * quantity_delivered) as total_income')
            )
            ->groupBy('b.comm', 'b.id')
            ->orderByDesc('total_income')
            ->paginate(10, ['*'], 'earningsPerCommodity_page');

        $transactionPerReceipt = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                'a.transaction_date',
                'a.transaction_number',
                DB::raw('SUM(price * quantity_delivered) as total_income')
            )
            ->groupBy('a.transaction_date', 'a.transaction_number')
            ->orderByDesc('a.transaction_date')
            ->paginate(10, ['*'], 'transactionPerReceipt_page');

        return view(
            'sales.income.index',
            [
                'totalIncome' => $totalIncome,
                'totalIncomeToday' => $totalIncomeToday,
                'detailsIncomeToday' => $detailsIncomeToday,
                'months' => $months,
                'datasets' => $datasets,
                'commodityByYear' => $commodityByYear,
                'years' => $years,
                'totalEarningPerCommodity' => $totalEarningPerCommodity,
                'transactionPerReceipt' => $transactionPerReceipt,
            ]
        );
    }

    public function salesincomeinvoice($id)
    {
        $userId = Auth::guard('partner')->user()->id;

        $invoiceDetails = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('transaction_number', $id)
            ->where('name_id', $userId)
            ->select(
                'a.*',
                'b.comm as commodity_name',
                DB::raw('(a.price * a.quantity_delivered) as total_income')
            )
            ->orderBy('b.comm', 'asc')
            ->get();

        $invoiceTotal = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->where('transaction_number', $id)
            ->where('name_id', $userId)
            ->select(
                DB::raw('SUM(a.price * a.quantity_delivered) as total_income')
            )
            ->first();

        return view('sales.income.invoice', [
            'invoiceDetails' => $invoiceDetails,
            'transaction_number' => $id,
            'userId' => $userId,
            'invoiceTotal' => $invoiceTotal,
        ]);
    }

    public function salesvolumeindex()
    {
        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $userId = Auth::guard('partner')->user()->id;

        $overallVolumeDelivered = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->whereNotNull('transaction_date')
            ->where('transaction_date', '!=', '0000-00-00')
            ->whereBetween('transaction_date', ['2020-01-01', $today])
            ->where('name_id', $userId)
            ->select(
                DB::raw('IFNULL(SUM(quantity_delivered),0) as overall_volume_delivered'),
                DB::raw('IFNULL(SUM(quantity_adjusted),0) as overall_volume_committed'),
                DB::raw('(IFNULL(SUM(quantity_delivered), 0) / IFNULL(SUM(quantity_adjusted), 1) * 100) as fulfillment_rate')
            )
            ->first();

        $totalVolumeDelivered = $overallVolumeDelivered->overall_volume_delivered ?? 0;
        $totalVolumeCommitted = $overallVolumeDelivered->overall_volume_committed ?? 0;
        $fulfillmentRate = $overallVolumeDelivered->fulfillment_rate ?? 0;

        $noOfCommodities = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                DB::raw('COUNT(DISTINCT b.id) as no_of_commodities')
            )
            ->first();

        $monthlyAdjustedVsDelivered = DB::connection('mysql_secondary')
            ->table('pre_transactions')
            ->where('name_id', $userId)
            ->select(
                DB::raw('YEAR(transaction_date) as year'),
                DB::raw('MONTH(transaction_date) as month'),
                DB::raw('SUM(quantity_delivered) as delivered'),
                DB::raw('SUM(quantity_adjusted) as adjusted')
            )
            ->groupBy(DB::raw('YEAR(transaction_date), MONTH(transaction_date)'))
            ->orderByRaw('YEAR(transaction_date), MONTH(transaction_date)')
            ->get();

        $years = [];
        $formatted = [];

        foreach ($monthlyAdjustedVsDelivered as $row) {
            $years[] = $row->year;
            $formatted[$row->year][$row->month] = [
                'delivered' => round($row->delivered, 2),
                'adjusted' => round($row->adjusted, 2)
            ];
        }

        $years = array_unique($years);
        sort($years);

        $commodityDeliveredPerYear = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('name_id', $userId)
            ->where('quantity_delivered', ">", 0)
            ->select(
                DB::raw('YEAR(transaction_date) as year'),
                'b.id',
                'b.comm as commodity_name',
                DB::raw('SUM(quantity_delivered) as total_delivered')
            )
            ->groupBy(DB::raw('YEAR(transaction_date)'), 'b.comm', 'b.id')
            ->get();

        $commodityDeliveredByYear = [];
        $commodityYears = [];

        foreach ($commodityDeliveredPerYear as $commodityDelivered) {
            $commodityYears[] = $commodityDelivered->year;
            $commodityDeliveredByYear[$commodityDelivered->year][] = [
                'commodity_name' => $commodityDelivered->commodity_name,
                'total_delivered' => round($commodityDelivered->total_delivered, 2),
            ];
        }

        // Sort and keep top 5 per year
        foreach ($commodityDeliveredByYear as $year => $commodities) {
            usort($commodities, function ($a, $b) {
                return $b['total_delivered'] <=> $a['total_delivered'];
            });
            $commodityDeliveredByYear[$year] = array_slice($commodities, 0, 5);
        }

        $commodityYears = array_unique($commodityYears);
        sort($commodityYears);

        $commodityStatsPerYear = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->whereBetween('transaction_date', ['2020-01-01', $today])
            ->where('name_id', $userId)
            ->select(
                DB::raw('YEAR(transaction_date) as year'),
                'b.id',
                'b.comm as commodity_name',
                DB::raw('SUM(quantity_delivered) as total_delivered'),
                DB::raw('SUM(quantity_adjusted) as total_committed')
            )
            ->groupBy(DB::raw('YEAR(transaction_date)'), 'b.comm', 'b.id')
            ->get();

        $commodityStatsByYear = [];
        $statsYears = [];

        foreach ($commodityStatsPerYear as $stat) {
            $statsYears[] = $stat->year;
            $commodityStatsByYear[$stat->year][] = [
                'commodity_name' => $stat->commodity_name,
                'total_delivered' => round($stat->total_delivered, 2),
                'total_committed' => round($stat->total_committed, 2),
            ];
        }

        // Sort and keep top 5 by delivered per year
        foreach ($commodityStatsByYear as $year => $commodities) {
            usort($commodities, function ($a, $b) {
                return $b['total_delivered'] <=> $a['total_delivered'];
            });
            $commodityStatsByYear[$year] = array_slice($commodities, 0, 5);
        }

        $statsYears = array_values(array_unique($statsYears));
        sort($statsYears);

        $totalCommitmentVsDelivered = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->whereBetween('transaction_date', ['2020-01-01', $today])
            ->where('name_id', $userId)
            ->select(
                'b.id',
                'b.comm as commodity_name',
                DB::raw('SUM(quantity_delivered) as total_delivered'),
                DB::raw('SUM(quantity_adjusted) as total_adjusted'),
                DB::raw('SUM(quantity_committed) as total_committed')
            )
            ->groupBy('b.comm', 'b.id')
            ->orderByDesc('total_committed')
            ->paginate(10, ['*'], 'totalCommitmentVsDelivered_page');

        return view('sales.volume.index', [
            'totalVolumeDelivered' => $totalVolumeDelivered,
            'totalVolumeCommitted' => $totalVolumeCommitted,
            'today' => $today,
            'fulfillmentRate' => $fulfillmentRate,
            'noOfCommodities' => $noOfCommodities->no_of_commodities ?? 0,
            'data' => $formatted,
            'commodityDeliveredByYear' => $commodityDeliveredByYear,
            'commodityYears' => $commodityYears,
            'years' => $years,
            'commodityStatsByYear' => $commodityStatsByYear,
            'statsYears' => $statsYears,
            'totalCommitmentVsDelivered' => $totalCommitmentVsDelivered,
        ]);
    }
}
