<?php

namespace Hoomat\Notifications\App\Scopes\NotificationLog;

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Illuminate\Database\Eloquent\Builder;

class NotificationLogLoadScope extends EagerLoadScope
{
    public function notification(): Builder
    {
        return $this->builder->with([
            'notification' => ['template']
        ]);
    }


    public function notification_with_sent_by(): Builder
    {
        return $this->builder->with([
            'notification' => [
                'template',
                'sentBy' => ['files']
            ]
        ]);
    }


    public function receiver(): Builder
    {
        return $this->builder->with([
            'receiver' => ['files']
        ]);
    }
}
