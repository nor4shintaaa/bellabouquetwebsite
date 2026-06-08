<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        View::composer(['pelanggan.*', 'layouts.pelanggan'], function ($view) {
            $siteSetting = null;

            try {
                if (Schema::hasTable('site_settings')) {
                    $siteSetting = SiteSetting::getSetting();
                }
            } catch (\Throwable $e) {
                $siteSetting = null;
            }

            $view->with('siteSetting', $siteSetting);
        });
    }
}