<?php

namespace Hoomat\Identities\App\Http\Controllers;

use Hoomat\Base\App\Http\Controllers\Controller;
use Hoomat\Base\App\Http\Requests\ServiceRequiredRequest;
use Hoomat\Identities\App\Http\Resources\PermissionResource;
use Hoomat\Identities\App\Services\PermissionService;
use Illuminate\Http\JsonResponse;

/**
 * @group Identity
 * @subgroup AccessControl
 */
class PermissionController extends Controller
{
    public function __construct(
        private readonly PermissionService $permissionService
    )
    {}


    /**
     * Permission Index
     *
     * @param ServiceRequiredRequest $request
     * @return JsonResponse
     */
    public function index(ServiceRequiredRequest $request): JsonResponse
    {
        $permissions = $this->permissionService->index();
        return $this->dynamicResponse($permissions, PermissionResource::class);
    }
}
