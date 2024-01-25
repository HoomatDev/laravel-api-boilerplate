<?php

namespace Hoomat\Identities\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use Hoomat\Identities\App\Models\Permission;
use Hoomat\Identities\App\Repositories\Interfaces\PermissionRepositoryInterface;
use Hoomat\Identities\App\Scopes\Permission\PermissionFilterScope;
use Hoomat\Identities\App\Scopes\Permission\PermissionLoadScope;
use Hoomat\Identities\App\Scopes\Permission\PermissionSearchScope;
use Hoomat\Identities\App\Scopes\Permission\PermissionSortScope;

class PermissionRepository extends BaseRepository implements PermissionRepositoryInterface
{
    public function __construct(
        Permission $model,
        PermissionFilterScope $filterScope,
        PermissionSortScope $sortScope,
        PermissionSearchScope $searchScope,
        PermissionLoadScope $loadScope
    )
    {
        parent::__construct($model, $filterScope, $sortScope, $searchScope, $loadScope);
    }
}
