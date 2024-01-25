<?php

namespace Hoomat\Notifications\App\Repositories\Interfaces;

use Hoomat\Base\App\Repositories\Interfaces\EloquentRepositoryInterface;

interface NotificationLogRepositoryInterface extends EloquentRepositoryInterface
{
    public function createMany(array $items);

    public function markAsRead(int $userId): int;

    public function updateStatus(int $logId, int $status): bool;

    public function updateStatusByNotification(int $notifId, int $status): bool;
}
