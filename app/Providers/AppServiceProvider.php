<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\SMS\SmsService as SmsService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('SmsService', function ($app) {
            return new SmsService();
        });

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
