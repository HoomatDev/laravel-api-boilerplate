<?php

namespace Hoomat\Filesystem\App\Scopes;

use Hoomat\Base\App\Scopes\FilterScope;
use Illuminate\Database\Eloquent\Builder;

class FileFilterScope extends FilterScope
{
    public function user($term): Builder
    {
        return $this->builder->where('user_id', $term);
    }


    public function directory($term): Builder
    {
        return $this->builder->where('directory', $term);
    }


    public function type($term): Builder
    {
        return $this->builder->where('type', $term);
    }
}
