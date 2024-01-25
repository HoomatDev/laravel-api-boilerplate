<?php

namespace Hoomat\Identities\Providers;

use Illuminate\Support\ServiceProvider;

class IdentitiesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/IdentitiesConfig.php', 'IdentitiesConfig');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../App/Http/routes/api.php');
    }

    public function register(): void
    {
        $this->app->register(RepositoryServiceProvider::class);
    }
}
