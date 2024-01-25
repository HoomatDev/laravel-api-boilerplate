<?php

namespace Hoomat\Notifications\App\Scopes\NotificationLog;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class NotificationLogFilterScope extends FilterScope
{
    public function read($term): Builder
    {
        if ($term) {
            return $this->builder->whereNotNull('read_At');
        }
        return $this->builder->whereNull('read_at');
    }


    public function status($term): Builder
    {
        return $this->builder->where('status', $term);
    }


    public function notification($term): Builder
    {
        return $this->builder->where('notification_id', $term);
    }
}
