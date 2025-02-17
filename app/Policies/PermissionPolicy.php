<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Permission1;
use App\Models\User;

class PermissionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Permission');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Permission1 $permission1): bool
    {
        return $user->checkPermissionTo('view Permission');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Permission1');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Permission1 $permission1): bool
    {
        return $user->checkPermissionTo('update Permission1');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Permission1 $permission1): bool
    {
        return $user->checkPermissionTo('delete Permission1');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Permission1');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Permission1 $permission1): bool
    {
        return $user->checkPermissionTo('restore Permission1');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Permission1');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Permission1 $permission1): bool
    {
        return $user->checkPermissionTo('replicate Permission1');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Permission1');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Permission1 $permission1): bool
    {
        return $user->checkPermissionTo('force-delete Permission1');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Permission1');
    }
}
