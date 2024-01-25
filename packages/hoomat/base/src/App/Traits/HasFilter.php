<?php

namespace Hoomat\Base\App\Traits;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter($query, FilterScope $filters): Builder
    {
        return $filters->apply($query);
    }
}
