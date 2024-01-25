<?php

namespace Hoomat\Notifications\App\Scopes\Notification;

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Illuminate\Database\Eloquent\Builder;

class NotificationLoadScope extends EagerLoadScope
{
    public function sent_by(): Builder
    {
        return $this->builder->with([
            'sentBy' => ['files']
        ]);
    }


    public function template(): Builder
    {
        return $this->builder->with(['template']);
    }


    public function logs(): Builder
    {
        return $this->builder->with(['logs']);
    }


    public function logs_with_receiver(): Builder
    {
        return $this->builder->with([
            'logs' => [
                'receiver' => ['files']
            ]
        ]);
    }
}
