<?php

namespace App\Providers;

use App\Models\Stock;
use App\Observers\StockObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Stock::observe(StockObserver::class);
    }
}
