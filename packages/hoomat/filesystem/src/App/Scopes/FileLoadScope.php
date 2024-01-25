<?php

namespace Hoomat\Filesystem\App\Scopes;

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Illuminate\Database\Eloquent\Builder;

class FileLoadScope extends EagerLoadScope
{
    public function user(): Builder
    {
        return $this->builder->with(['user' => ['files']]);
    }
}
