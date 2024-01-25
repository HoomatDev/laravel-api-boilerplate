<?php

namespace Hoomat\Base\App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class EagerLoadScope
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
        foreach ($this->with() as $relation) {
            if ( ! method_exists($this, $relation)) {
                continue;
            }

            $this->$relation();
        }
        return $this->builder;
    }


    public function with(): array
    {
        return $this->request->input('with');
    }
}
