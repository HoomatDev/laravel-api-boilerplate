<?php

namespace Hoomat\Notifications\Providers;

use Hoomat\Notifications\App\Repositories\Interfaces\NotificationLogRepositoryInterface;
use Hoomat\Notifications\App\Repositories\Interfaces\NotificationRepositoryInterface;
use Hoomat\Notifications\App\Repositories\Interfaces\NotificationTemplateRepositoryInterface;
use Hoomat\Notifications\App\Repositories\NotificationLogRepository;
use Hoomat\Notifications\App\Repositories\NotificationRepository;
use Hoomat\Notifications\App\Repositories\NotificationTemplateRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(NotificationRepositoryInterface::class, NotificationRepository::class);
        $this->app->bind(NotificationTemplateRepositoryInterface::class, NotificationTemplateRepository::class);
        $this->app->bind(NotificationLogRepositoryInterface::class, NotificationLogRepository::class);
    }
}
