<?php

namespace Hoomat\Notifications\App\Scopes\NotificationTemplate;

use Hoomat\Base\App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Builder;

class NotificationTemplateSearchScope extends SearchScope
{
    public function normalSearch($keyword): Builder
    {
        return $this->builder
            ->Where('name', 'LIKE', "%$keyword%");
    }
}
