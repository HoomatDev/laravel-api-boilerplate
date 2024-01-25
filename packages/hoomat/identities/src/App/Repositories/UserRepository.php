<?php

namespace Hoomat\Identities\App\Repositories;

use Hoomat\Base\App\Repositories\BaseRepository;
use Hoomat\Identities\App\Models\User;
use Hoomat\Identities\App\Repositories\Interfaces\UserRepositoryInterface;
use Hoomat\Identities\App\Scopes\User\UserFilterScope;
use Hoomat\Identities\App\Scopes\User\UserLoadScope;
use Hoomat\Identities\App\Scopes\User\UserSearchScope;
use Hoomat\Identities\App\Scopes\User\UserSortScope;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(
        User $model,
        UserFilterScope $filterScope,
        UserSortScope $sortScope,
        UserSearchScope $searchScope,
        UserLoadScope $loadScope
    )
    {
        parent::__construct($model, $filterScope, $sortScope, $searchScope, $loadScope);
    }
}
