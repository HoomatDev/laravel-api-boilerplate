<?php

namespace Hoomat\Identities\App\Scopes\User;

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Illuminate\Database\Eloquent\Builder;

class UserLoadScope extends EagerLoadScope
{
    public function files(): Builder
    {
        return $this->builder->with(['files']);
    }
}
