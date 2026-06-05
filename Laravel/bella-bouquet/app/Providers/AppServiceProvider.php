<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        View::composer(['pelanggan.*', 'layouts.pelanggan'], function ($view) {
            $siteSetting = null;

            if (Schema::hasTable('site_settings')) {
                $siteSetting = SiteSetting::getSetting();
            }

            $view->with('siteSetting', $siteSetting);
        });
    }
}