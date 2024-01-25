<?php

namespace Hoomat\Filesystem\App\Policies;

use Hoomat\Base\App\Helpers\Utility;
use Hoomat\Filesystem\App\Models\File;
use Hoomat\Identities\App\Models\User;
use Illuminate\Auth\Access\Response;

class FilePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, File $file)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, File $file)
    {
        return $user->id === $file->user_id
        ? Response::allow()
        : Response::deny(Utility::getAuthorizeMessage('update', 'file'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, File $file)
    {
        return $user->id === $file->user_id
        ? Response::allow()
        : Response::deny(Utility::getAuthorizeMessage('delete', 'file'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, File $file)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, File $file)
    {
        return $user->id === $file->user_id
        ? Response::allow()
        : Response::deny(Utility::getAuthorizeMessage('delete', 'file'));
    }
}
