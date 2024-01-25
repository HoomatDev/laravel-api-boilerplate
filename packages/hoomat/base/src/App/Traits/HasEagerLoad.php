<?php

namespace Hoomat\Base\App\Traits;

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Illuminate\Database\Eloquent\Builder;

trait HasEagerLoad
{
    public function scopeEagerLoad($query, EagerLoadScope $load): Builder
    {
        return $load->apply($query);
    }
}
