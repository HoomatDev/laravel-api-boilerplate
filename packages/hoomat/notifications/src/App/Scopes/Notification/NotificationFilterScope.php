<?php

namespace Hoomat\Notifications\App\Scopes\Notification;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class NotificationFilterScope extends FilterScope
{
    public function template($term): Builder
    {
        return $this->builder->where('template_id', $term);
    }


    public function between_date($term): Builder
    {
        return $this->builder
            ->where('send_at', '>=', $term['from'])
            ->where('send_at', '<=', $term['to']);
    }


    public function notif_type($term): Builder
    {
        return $this->builder->where('notifable_type', $this->getNotifType($term));
    }


    public function sent($term): Builder
    {
        $operator = $term === 1 ? '=' : '<>';
        return $this->builder->where('status', $operator, config('NotificationsConfig.status.sent'));
    }


    public function type($term): Builder
    {
        return $this->builder->where('type', $term);
    }


    // TODO: implement Notif relations and then update this method
    protected function getNotifType(string $type): ?string
    {
        return match ($type) {
            'TicketReferral' => 'x',
            default => null,
        };
    }
}
