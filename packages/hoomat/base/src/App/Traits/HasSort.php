<?php

namespace Hoomat\Base\App\Traits;

use Hoomat\Base\App\Scopes\SortScope;
use Illuminate\Database\Eloquent\Builder;

trait HasSort
{
    public function scopeSort($query, SortScope $sort): Builder
    {
        return $sort->apply($query);
    }
}
