<?php

namespace Hoomat\Filesystem\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use Hoomat\Filesystem\App\Models\File;
use Hoomat\Filesystem\App\Repositories\Interfaces\FileRepositoryInterface;
use Hoomat\Filesystem\App\Scopes\FileFilterScope;
use Hoomat\Filesystem\App\Scopes\FileLoadScope;
use Hoomat\Filesystem\App\Scopes\FileSearchScope;
use Hoomat\Filesystem\App\Scopes\FileSortScope;
use Illuminate\Database\Eloquent\Collection;

class FileRepository extends BaseRepository implements FileRepositoryInterface
{
    public function __construct(
        File            $model,
        FileFilterScope $filterScope,
        FileSortScope   $sortScope,
        FileSearchScope $searchScope,
        FileLoadScope   $loadScope
    )
    {
        parent::__construct($model, $filterScope, $sortScope, $searchScope, $loadScope);
    }


    public function groupByOn($field, $where): Collection|array
    {
        $fields = is_array($field) ? $field : [$field];
        return $this->model->query()
            ->select($fields)
            ->groupBy($fields)
            ->where($where)
            ->get();
    }
}
