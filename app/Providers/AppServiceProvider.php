<?php

namespace App\Providers;

use App\Models\CommissionLevel;
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
        $this->app->singleton('commissionLevels',function() {
            return CommissionLevel::all();
        });
    }
}
