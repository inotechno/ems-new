<?php

namespace App\Providers;

use App\Services\EmailService;
use Illuminate\Support\ServiceProvider;
use Snowfire\Beautymail\Beautymail;

class EmailServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('EmailService', function ($app) {
            return new EmailService($app->make(Beautymail::class));
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
