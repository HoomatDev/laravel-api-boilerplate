<?php

namespace Hoomat\Base\App\Helpers;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class QueryBuilder extends Builder
{
    public function decide(): Collection|LengthAwarePaginator|array
    {
        $page = request()->input('page');
        $limit = request()->input('limit');

        if ($page || $limit) {
            return $this->paginate($limit ?? 10);
        }

        return $this->get();
    }
}
