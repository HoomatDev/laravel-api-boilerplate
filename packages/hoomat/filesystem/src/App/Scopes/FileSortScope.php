<?php

namespace Hoomat\Filesystem\App\Scopes;

use Hoomat\Base\App\Scopes\SortScope;
use Illuminate\Database\Eloquent\Builder;

class FileSortScope extends SortScope
{
    public function created_at($term): Builder
    {
        return $this->builder->orderBy('created_at', $term);
    }


    public function updated_at($term): Builder
    {
        return $this->builder->orderBy('updated_at', $term);
    }
}
