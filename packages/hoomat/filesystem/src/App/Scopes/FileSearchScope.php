<?php

namespace Hoomat\Filesystem\App\Scopes;

use Hoomat\Base\App\Scopes\SearchScope;
use Illuminate\Database\Eloquent\Builder;

class FileSearchScope extends SearchScope
{
    public function normalSearch($term): Builder
    {
        return $this->builder;
    }
}
