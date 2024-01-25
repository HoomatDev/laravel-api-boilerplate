<?php

namespace Hoomat\Identities\App\Scopes\Permission;

use Hoomat\Base\App\Scopes\SortScope;
use Illuminate\Database\Eloquent\Builder;

class PermissionSortScope extends SortScope
{
    public function created_at($term): Builder
    {
        return $this->builder->orderBy('created_at', $term);
    }
}
