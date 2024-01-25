<?php

namespace Hoomat\Base\App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class SortScope
{
    protected Request $request;
    protected Builder $builder;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        $column = $this->sortBy();
        $dir = $this->sortDir();

        if (! method_exists($this, $column)) {
            if (Schema::hasColumn($this->builder->getModel()->getTable(), $column)) {
                $this->builder->orderBy($column, $dir);
            } else {
                $this->builder->latest();
            }
        } else {
            $this->$column($dir);
        }

        return $this->builder;
    }


    public function sortBy(): ?string
    {
        return $this->request->input('sort.by');
    }


    public function sortDir(): string
    {
        return $this->request->input('sort.dir') ?? 'desc';
    }
}
