<?php

namespace Hoomat\Notifications\App\Repositories\Interfaces;

use Hoomat\Base\App\Repositories\Interfaces\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface NotificationRepositoryInterface extends EloquentRepositoryInterface
{
    public function getAllUnreads(int $userId): Collection|array;

    public function updateStatus(int $id, int $status): bool;
}
