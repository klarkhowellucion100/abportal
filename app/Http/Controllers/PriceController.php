<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PriceController extends Controller
{
    public function pricesindex()
    {
        $today = Carbon::now('Asia/Manila')->format('Y-m-d');

        $prices = DB::connection('mysql_secondary')
            ->table('prices as a')
            ->join('commodities as b', 'a.comm_id', '=', 'b.id')
            ->where('comm_date_f',  $today)
            ->select(
                'b.comm as commodity_name',
                'comm_fgp_f'
            )
            ->orderBy('b.comm', 'asc')
            ->get();

        return view(
            'prices.index',
            [
                'prices' => $prices,
                'today' => $today
            ]
        );
    }

    public function pricessearch(Request $request)
    {
        $today = $request->input('price_date');

        $prices = DB::connection('mysql_secondary')
            ->table('prices as a')
            ->join('commodities as b', 'a.comm_id', '=', 'b.id')
            ->where('comm_date_f',  $today)
            ->select(
                'b.comm as commodity_name',
                'comm_fgp_f'
            )
            ->orderBy('b.comm', 'asc')
            ->get();

        return view(
            'prices.index',
            [
                'prices' => $prices,
                'today' => $today
            ]
        );
    }
}
