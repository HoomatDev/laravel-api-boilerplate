<?php

namespace Hoomat\Identities\App\Services;

use Hoomat\Base\App\Services\BaseService;
use Hoomat\Identities\App\Models\DTOs\RoleDTO;
use Hoomat\Identities\App\Models\Role;
use Hoomat\Identities\App\Repositories\Interfaces\RoleRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RoleService extends BaseService
{
    public function __construct(RoleRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }


    public function createNewRole(RoleDTO $data, array $permissions)
    {
        try {
            DB::beginTransaction();

            $role = $this->create($data);
            $role->permissions()->sync($permissions);

            DB::commit();

            return $role;
        } catch(\Throwable $th) {
            DB::rollBack();
            return null;
        }
    }


    public function updateRole(Role $role, RoleDTO $data, array $permissions): Model|Builder|null
    {
        try {
            DB::beginTransaction();

            $role = $this->update($role, $data);
            $role->permissions()->sync($permissions);

            DB::commit();

            return $role;
        } catch(\Throwable $th) {
            DB::rollBack();
            return null;
        }
    }
}
