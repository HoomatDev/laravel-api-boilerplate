<?php

namespace Hoomat\Notifications\Providers;

use Hoomat\Notifications\App\Services\SendNotificationService;
use Illuminate\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/NotificationsConfig.php', 'NotificationsConfig');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../App/Http/routes/api.php');
    }


    public function register(): void
    {
        $this->app->register(NotificationEventServiceProvider::class);
        $this->app->register(RepositoryServiceProvider::class);

        $this->app->instance('send-notification', $this->app->make(SendNotificationService::class));
    }
}
