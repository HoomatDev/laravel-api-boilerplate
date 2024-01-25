<?php

namespace Hoomat\Filesystem\Providers;

use Hoomat\Filesystem\App\Repositories\FileRepository;
use Hoomat\Filesystem\App\Repositories\Interfaces\FileRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(FileRepositoryInterface::class, FileRepository::class);
    }
}
