<?php

namespace Hoomat\Identities\Providers;

use Hoomat\Identities\App\Repositories\Interfaces\PermissionRepositoryInterface;
use Hoomat\Identities\App\Repositories\Interfaces\RoleRepositoryInterface;
use Hoomat\Identities\App\Repositories\Interfaces\UserRepositoryInterface;
use Hoomat\Identities\App\Repositories\PermissionRepository;
use Hoomat\Identities\App\Repositories\RoleRepository;
use Hoomat\Identities\App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }
}
