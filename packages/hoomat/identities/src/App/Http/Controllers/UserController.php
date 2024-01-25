<?php

namespace Hoomat\Identities\App\Http\Controllers;

use Hoomat\Base\App\Http\Controllers\Controller;
use Hoomat\Filesystem\App\Facades\Uploader;
use Hoomat\Identities\App\Http\Requests\UserUpdateRequest;
use Hoomat\Identities\App\Http\Resources\UserResource;
use Hoomat\Identities\App\Models\DTOs\UserDTO;
use Hoomat\Identities\App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @group Identity
 * @subgroup User
 */
class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    )
    {}


    /**
     * User Update
     *
     * @param UserUpdateRequest $request
     * @return JsonResponse
     */
    public function update(UserUpdateRequest $request): JsonResponse
    {
        $user = auth()->user();
        $this->userService->update($user, UserDTO::fromModel($user, $request->all()));

        if ($request->hasFile('avatar')) {
            Uploader::model($user->files->first())
                ->fileable($user)
                ->file($request->file('avatar'))
                ->type('avatar')
                ->dir('user')
                ->name($user->full_name)
                ->upload();
        }

        return $this->dynamicResponse(
            $this->userService->show($user->id),
            UserResource::class
        );
    }
}
