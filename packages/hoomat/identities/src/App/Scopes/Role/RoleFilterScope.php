<?php

namespace Hoomat\Identities\App\Scopes\Role;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class RoleFilterScope extends FilterScope
{
    public function is_customer($term): Builder
    {
        return $this->builder->where('is_customer', $term);
    }


    public function service($term): Builder
    {
        return $this->builder->where('service_id', $term);
    }
}
