<?php

namespace Hoomat\Base\App\Models;

use Hoomat\Base\App\Helpers\QueryBuilder;
use Hoomat\Base\App\Interfaces\IModel;
use Hoomat\Base\App\Traits\HasDate;
use Hoomat\Base\App\Traits\HasEagerLoad;
use Hoomat\Base\App\Traits\HasFilter;
use Hoomat\Base\App\Traits\HasSearch;
use Hoomat\Base\App\Traits\HasSort;
use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model implements IModel
{
    use HasDate, HasFilter, HasSort, HasEagerLoad, HasSearch;


    public function newEloquentBuilder($query)
    {
        return new QueryBuilder($query);
    }


    public function getCacheTags(): array
    {
        return $this->cache_tags ?? [];
    }
}
