<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CloudStorage\GcsService;

class CloudServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('gcs', function ($app) {
            return $app->make(GcsService::class);
        });
    }
}
