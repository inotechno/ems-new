<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class SettingServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('settings')) {
            $settings = Cache::rememberForever('settings', function () {
                return \App\Models\Setting::all();
            });

            foreach ($settings as $setting) {
                Config::set('setting.' . $setting->key, $setting->value);
            }
        }
    }
}
