<?php

namespace Hoomat\Identities\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use Hoomat\Identities\App\Models\Role;
use Hoomat\Identities\App\Repositories\Interfaces\RoleRepositoryInterface;
use Hoomat\Identities\App\Scopes\Role\RoleFilterScope;
use Hoomat\Identities\App\Scopes\Role\RoleLoadScope;
use Hoomat\Identities\App\Scopes\Role\RoleSearchScope;
use Hoomat\Identities\App\Scopes\Role\RoleSortScope;

class RoleRepository extends BaseRepository implements RoleRepositoryInterface
{
    public function __construct(
        Role $model,
        RoleFilterScope $filterScope,
        RoleSortScope $sortScope,
        RoleSearchScope $searchScope,
        RoleLoadScope $loadScope
    )
    {
        parent::__construct($model, $filterScope, $sortScope, $searchScope, $loadScope);
    }
}
