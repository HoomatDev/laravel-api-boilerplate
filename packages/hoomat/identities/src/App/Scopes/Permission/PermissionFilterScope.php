<?php

namespace Hoomat\Identities\App\Scopes\Permission;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class PermissionFilterScope extends FilterScope
{
    public function is_customer($term): Builder
    {
        return $this->builder->where('is_customer', $term);
    }
}
