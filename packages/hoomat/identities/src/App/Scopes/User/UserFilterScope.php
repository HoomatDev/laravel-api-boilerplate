<?php

namespace Hoomat\Identities\App\Scopes\User;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class UserFilterScope extends FilterScope
{
    public function gender($term): Builder
    {
        return $this->builder->where('gender', $term);
    }
}
