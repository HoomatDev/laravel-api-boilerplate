<?php

namespace Hoomat\Identities\App\Http\Controllers;

use Hoomat\Base\App\Http\Controllers\Controller;
use Hoomat\Base\App\Http\Requests\ServiceRequiredRequest;
use Hoomat\Identities\App\Http\Requests\RoleStoreRequest;
use Hoomat\Identities\App\Http\Resources\RoleResource;
use Hoomat\Identities\App\Models\DTOs\RoleDTO;
use Hoomat\Identities\App\Models\Role;
use Hoomat\Identities\App\Services\RoleService;
use Illuminate\Http\JsonResponse;

/**
 * @group Identity
 * @subgroup AccessControl
 */
class RoleController extends Controller
{
    public function __construct(
        private readonly RoleService $roleService
    )
    {}


    /**
     * Role Index
     *
     * @param ServiceRequiredRequest $request
     * @return JsonResponse
     */
    public function index(ServiceRequiredRequest $request): JsonResponse
    {
        $roles = $this->roleService->index();
        return $this->dynamicResponse($roles, RoleResource::class);
    }


    /**
     * Role Store
     *
     * @param RoleStoreRequest $request
     * @return JsonResponse
     */
    public function store(RoleStoreRequest $request): JsonResponse
    {
        $permissions = $request->input('permissions');

        $role = $this->roleService->createNewRole(RoleDTO::fromRequest($request), $permissions);
        $role = $this->roleService->show($role->id);
        return $this->dynamicResponse($role, RoleResource::class);
    }


    /**
     * Role Update
     *
     * @param RoleStoreRequest $request
     * @param Role             $role
     * @return JsonResponse
     */
    public function update(RoleStoreRequest $request, Role $role): JsonResponse
    {
        $permissions = $request->input('permissions');

        $this->roleService->updateRole($role, RoleDTO::fromModel($role, $request->all()), $permissions);
        $role = $this->roleService->show($role->id);
        return $this->dynamicResponse($role, RoleResource::class);
    }
}
