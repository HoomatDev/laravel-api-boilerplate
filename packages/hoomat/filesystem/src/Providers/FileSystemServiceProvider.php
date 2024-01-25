<?php

namespace Hoomat\Filesystem\Providers;

use Hoomat\Filesystem\App\Services\FileUploadService;
use Illuminate\Support\ServiceProvider;

class FileSystemServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/FilesystemConfig.php', 'FilesystemConfig');

        $this->loadRoutesFrom(__DIR__.'/../App/Http/routes/api.php');

        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
    }


    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);

        $this->app->instance('file-upload', $this->app->make(FileUploadService::class));
    }
}
