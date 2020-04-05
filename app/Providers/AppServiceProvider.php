<?php

namespace App\Providers;

use App\Observers\PurchaseObserver;
use App\Purchase;
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
        Purchase::observe(PurchaseObserver::class);
    }
}
