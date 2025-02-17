<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Township;
use App\Models\User;

class TownshipPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('view-any Township');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Township $township): bool
    {
        return $user->checkPermissionTo('view Township');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Township');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Township $township): bool
    {
        return $user->checkPermissionTo('update Township');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Township $township): bool
    {
        return $user->checkPermissionTo('delete Township');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Township');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Township $township): bool
    {
        return $user->checkPermissionTo('restore Township');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Township');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Township $township): bool
    {
        return $user->checkPermissionTo('replicate Township');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Township');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Township $township): bool
    {
        return $user->checkPermissionTo('force-delete Township');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Township');
    }
}
