<?php

namespace Hoomat\Base\App\Traits;

use Hoomat\Base\App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Builder;

trait HasSearch
{
    public function scopeNormalSearch($query, SearchScope $search): Builder
    {
        return $search->apply($query);
    }
}
