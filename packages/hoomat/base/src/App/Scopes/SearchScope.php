<?php

namespace Hoomat\Base\App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchScope
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
        $keyword = $this->keyword();

        if ((! is_null($keyword)) && method_exists($this, 'normalSearch')) {
            $this->normalSearch($keyword);
        }

        return $this->builder;
    }


    public function keyword(): ?string
    {
        return $this->request->input('search');
    }
}
