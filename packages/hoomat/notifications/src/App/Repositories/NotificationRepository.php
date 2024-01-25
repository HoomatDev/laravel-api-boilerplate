<?php

namespace Hoomat\Notifications\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use Hoomat\Notifications\App\Models\Notification;
use Hoomat\Notifications\App\Repositories\Interfaces\NotificationRepositoryInterface;
use Hoomat\Notifications\App\Scopes\Notification\NotificationFilterScope;
use Hoomat\Notifications\App\Scopes\Notification\NotificationLoadScope;
use Hoomat\Notifications\App\Scopes\Notification\NotificationSearchScope;
use Hoomat\Notifications\App\Scopes\Notification\NotificationSortScope;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    public function __construct(
        Notification $model,
        NotificationFilterScope $filterScope,
        NotificationSortScope $sortScope,
        NotificationSearchScope $searchScope,
        NotificationLoadScope $loadScope
    )
    {
        parent::__construct($model, $filterScope, $sortScope, $searchScope, $loadScope);
    }


    public function getAllUnreads(int $userId): Collection|array
    {
        return $this->model->query()
            ->where('status', config('NotificationsConfig.status.sent'))
            ->where('type', 'LIKE', "%in-app%")
            ->whereHas('logs', function($query) use ($userId) {
                $query->where('receiver_id', $userId)
                    ->whereNull('read_at');
            })
            ->get();
    }


    public function updateStatus(int $id, int $status): bool
    {
        return $this->model->query()
            ->where('id', $id)
            ->update(['status' => $status]);
    }
}
