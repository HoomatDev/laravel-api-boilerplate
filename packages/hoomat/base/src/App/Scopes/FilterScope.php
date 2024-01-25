<?php

namespace Hoomat\Base\App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class FilterScope
{
    protected Request $request;
    protected Builder $builder;
    protected Collection $functions;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->functions = new Collection();
    }


    public function apply(Builder $builder): Builder
    {
        $this->builder = $builder;
        foreach ($this->filters() as $name => $value) {
            if ( ! method_exists($this, $name)) {
                continue;
            }

            if ($value !== '') {
                $this->$name($value);
            } else {
                $this->$name();
            }
        }
        return $this->builder;
    }


    public function filters(): array
    {
        return $this->request->input('filters');
    }


    protected function defer($function): void
    {
        $this->functions->push($function);
    }


    public function transform($model)
    {
        $this->functions->each(function ($function) use ($model) {
            $model = $function($model);
        });
        return $model;
    }
}
