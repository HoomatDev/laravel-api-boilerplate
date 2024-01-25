<?php

namespace Hoomat\Identities\App\Scopes\Permission;

use Hoomat\Base\App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Builder;

class PermissionSearchScope extends SearchScope
{
    public function normalSearch($term): Builder
    {
        return $this->builder->where('name', 'LIKE', "%$term%");
    }
}
