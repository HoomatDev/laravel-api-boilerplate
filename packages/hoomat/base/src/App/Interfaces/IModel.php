<?php

namespace Hoomat\Base\App\Interfaces;

use Hoomat\Base\App\Scopes\EagerLoadScope;
use Hoomat\Base\App\Scopes\FilterScope;
use Hoomat\Base\App\Scopes\SearchScope;
use Hoomat\Base\App\Scopes\SortScope;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Builder;

interface IModel extends \ArrayAccess, Arrayable, Jsonable, \JsonSerializable
{
    public function getCacheTags(): array;

    public function scopeEagerLoad($query, EagerLoadScope $load): Builder;

    public function scopeFilter($query, FilterScope $filters): Builder;

    public function scopeNormalSearch($query, SearchScope $search): Builder;

    public function scopeSort($query, SortScope $sort): Builder;
}
