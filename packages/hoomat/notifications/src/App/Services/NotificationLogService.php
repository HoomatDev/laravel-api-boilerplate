<?php

namespace Hoomat\Notifications\App\Services;

use Hoomat\Base\App\Services\BaseService;
use Hoomat\Notifications\App\Models\DTOs\NotificationLogDTO;
use Hoomat\Notifications\App\Models\Notification;
use Hoomat\Notifications\App\Models\NotificationLog;
use Hoomat\Notifications\App\Repositories\Interfaces\NotificationLogRepositoryInterface;

class NotificationLogService extends BaseService
{
    public function __construct(
        NotificationLogRepositoryInterface $repository
    )
    {
        parent::__construct($repository);
    }


    public function createMany(int $notification_id, array $receiver_ids)
    {
        $logs = [];
        foreach ($receiver_ids as $rec) {
            $logs[] = (new NotificationLogDTO(
                notification_id: $notification_id,
                receiver_id: $rec,
                status: 1
            ))->toArray();
        }
        return $this->repository->createMany($logs);
    }


    public function markAsRead(int $userId): int
    {
        return $this->repository->markAsRead($userId);
    }


    public function changeStatus(NotificationLog $log, int $status)
    {
        return $this->repository->updateStatus($log->id, $status);
    }


    public function changeStatusByNotification(Notification $notif, int $status)
    {
        return $this->repository->updateStatusByNotification($notif->id, $status);
    }
}
