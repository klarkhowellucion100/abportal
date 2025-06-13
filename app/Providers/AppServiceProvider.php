<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            if (Auth::guard('partner')->check()) {
                $userId = Auth::guard('partner')->id();

                $cartActiveCount = DB::connection('mysql_secondary')
                    ->table('pre_transactions')
                    ->where('name_id', $userId)
                    ->where('status', 0)
                    ->count();

                $view->with('cartActiveCount', $cartActiveCount);
            }
        });

        ini_set('max_execution_time', 600);
        Paginator::useBootstrapFour();
    }
}
