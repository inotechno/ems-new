<?php

namespace App\Providers;

use App\Helpers\ApiResponse;
use Illuminate\Support\ServiceProvider;

class ApiResponseProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('apiResponse', function ($app) {
            return new ApiResponse();
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
