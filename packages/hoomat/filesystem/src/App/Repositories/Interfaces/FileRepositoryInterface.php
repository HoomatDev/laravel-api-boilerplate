<?php

namespace Hoomat\Filesystem\App\Repositories\Interfaces;

use Hoomat\Base\App\Repositories\Interfaces\EloquentRepositoryInterface;
use Hoomat\Filesystem\App\Models\File;

interface FileRepositoryInterface extends EloquentRepositoryInterface
{
    public function groupByOn($field, $where);
}
