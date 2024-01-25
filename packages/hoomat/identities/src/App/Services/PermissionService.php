<?php

namespace Hoomat\Identities\App\Services;

use Hoomat\Base\App\Services\BaseService;
use Hoomat\Identities\App\Repositories\Interfaces\PermissionRepositoryInterface;

class PermissionService extends BaseService
{
    public function __construct(PermissionRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
}
