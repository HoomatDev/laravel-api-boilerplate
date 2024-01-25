<?php

namespace Hoomat\Identities\App\Scopes\Role;

use Hoomat\Base\App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Builder;

class RoleSearchScope extends SearchScope
{
    public function normalSearch($term): Builder
    {
        return $this->builder->where('name', 'LIKE', "%$term%");
    }
}
