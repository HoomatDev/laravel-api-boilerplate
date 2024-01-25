<?php

namespace Hoomat\Notifications\App\Scopes\NotificationTemplate;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class NotificationTemplateFilterScope extends FilterScope
{
    public function type($term): Builder
    {
        return $this->builder->where('type', 'LIKE', "%$term%");
    }


    public function receiver_type($term): Builder
    {
        return $this->builder->where('receiver_type', $term);
    }
}
