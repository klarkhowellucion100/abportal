<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class DashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString(); // e.g., '2025-05-01'
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $articlesPosted = Article::limit(5)
            ->where('type', 'News')
            ->orderBy('date_posted', 'desc')
            ->get();

        $announcementsPosted = Article::limit(5)
            ->where('type', 'Announcement')
            ->orderBy('date_posted', 'desc')
            ->get();

        $guidesPosted = Article::limit(5)
            ->where('type', 'Guide')
            ->orderBy('date_posted', 'desc')
            ->get();

        $userId = Auth::guard('partner')->user()->id;

        // Get current month data
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();
        $currentMonthLabel = Carbon::now()->format('Y-m');

        // Query for current month data
        $currentData = DB::connection('mysql_secondary')->table('pre_transactions as a')
            ->where('a.name_id', $userId)
            ->where('a.selling_type', 'Farmgate')
            ->whereBetween('a.transaction_date', [$startOfMonth, $endOfMonth])
            ->select(
                DB::raw('SUM(a.quantity_adjusted) as total_adjusted'),
                DB::raw('SUM(a.quantity_delivered) as total_delivered'),
                DB::raw('(SUM(a.quantity_adjusted) - SUM(a.quantity_delivered)) as diff_quantity'),
                DB::raw('LEAST(COALESCE((SUM(a.quantity_delivered) / NULLIF(SUM(a.quantity_adjusted), 0)) * 100, 0), 100) as percentage')
            )
            ->first();

        if (!$currentData) {
            return view('loyalty_status', ['status' => null]); // No data for this month
        }

        $adjustedQty = $currentData->total_adjusted;

        // Build previous 3 months with start/end dates and labels
        $previousMonths = collect();
        for ($i = 1; $i <= 3; $i++) {
            $previousMonths->push([
                'label' => Carbon::now()->subMonths($i)->format('Y-m'),
                'start' => Carbon::now()->subMonths($i)->startOfMonth()->toDateString(),
                'end' => Carbon::now()->subMonths($i)->endOfMonth()->toDateString(),
            ]);
        }

        // Fetch percentages of previous 3 months
        $pastPercentages = collect();

        foreach ($previousMonths as $month) {
            $data = DB::connection('mysql_secondary')->table('pre_transactions as a')
                ->where('a.name_id', $userId)
                ->where('a.selling_type', 'Farmgate')
                ->whereBetween('a.transaction_date', [$month['start'], $month['end']])
                ->selectRaw('? as month_year', [$month['label']])
                ->selectRaw('LEAST(COALESCE((SUM(a.quantity_delivered) / NULLIF(SUM(a.quantity_adjusted), 0)) * 100, 0), 100) as percentage')
                ->first();

            if ($data) {
                $pastPercentages->push($data);
            }
        }

        $percentages = $pastPercentages->pluck('percentage')->toArray();
        $avgPercentage = count($percentages) ? array_sum($percentages) / count($percentages) : 0;

        // Determine Tier
        $tier = match (true) {
            $adjustedQty < 300 => 'None',
            $adjustedQty >= 300 && $adjustedQty <= 599 => 'Silver',
            $adjustedQty >= 600 && $adjustedQty <= 799 => 'Gold',
            default => 'Platinum'
        };

        // Determine Eligibility based on average of previous 3 months
        $status = match (true) {
            $tier === 'Silver' && $avgPercentage >= 60,
            $tier === 'Gold' && $avgPercentage >= 80,
            $tier === 'Platinum' && $avgPercentage >= 90 => 'Eligible',
            default => 'Ineligible'
        };

        $loyaltyPointsAccumulated = DB::connection('mysql_secondary')
            ->table('loyalty_points')
            ->where('name_id', $userId)
            ->select(
                DB::raw('IFNULL(SUM(earned_points),0) as total_points_earned'),
                DB::raw('IFNULL(SUM(redeemed_points),0) as total_points_redeemed'),
                DB::raw('IFNULL(SUM(earned_points) - SUM(redeemed_points),0) as total_redeemable_points')
            )
            ->groupBy('name_id')
            ->first();

        $totalEarned = $loyaltyPointsAccumulated->total_points_earned ?? 0;
        $totalRedeemed = $loyaltyPointsAccumulated->total_points_redeemed ?? 0;
        $totalRedeemable = $loyaltyPointsAccumulated->total_redeemable_points ?? 0;

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

        $pricesToday = DB::connection('mysql_secondary')
            ->table('prices as a')
            ->join('commodities as b', 'a.comm_id', '=', 'b.id')
            ->where('a.comm_date_f', $today)
            ->select(
                'a.*',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
            )
            ->orderBy('b.comm', 'asc')
            ->limit(3)
            ->get();

        $scheduledCommitment = DB::connection('mysql_secondary')
            ->table('pre_transactions as a')
            ->join('commodities as b', 'a.commodity_id', '=', 'b.id')
            ->where('a.transaction_date', $today)
            ->where('a.name_id', $userId)
            ->where('a.status', 2)
            ->select(
                'a.commodity_id as commodity_id',
                'b.comm as commodity_name',
                'b.comm_pic as commodity_pic',
                DB::raw('IFNULL(SUM(a.quantity_adjusted),0) as total_quantity_adjusted'),
            )
            ->groupBy('a.commodity_id', 'b.comm')
            ->orderBy('b.comm', 'asc')
            // ->limit(3)
            ->get();

        return view('dashboard.index', [
            'articlesPosted' => $articlesPosted,
            'tier' => $tier,
            'status' => $status,
            'loyaltyPointsAccumulated' => $loyaltyPointsAccumulated,
            'totalEarned' => $totalEarned,
            'totalRedeemed' => $totalRedeemed,
            'totalRedeemable' => $totalRedeemable,
            'incomeToday' => $incomeToday,
            'totalIncomeToday' => $totalIncomeToday,
            'pricesToday' => $pricesToday,
            'announcementsPosted' => $announcementsPosted,
            'guidesPosted' => $guidesPosted,
            'scheduledCommitment' => $scheduledCommitment,

        ]);
    }
}
