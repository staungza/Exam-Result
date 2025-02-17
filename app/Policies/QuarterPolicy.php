<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Quarter;
use App\Models\User;

class QuarterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(User $user): bool
    // {
    //     return $user->checkPermissionTo('view-any Quarter');
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Quarter $quarter): bool
    {
        return $user->checkPermissionTo('view Quarter');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('create Quarter');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Quarter $quarter): bool
    {
        return $user->checkPermissionTo('update Quarter');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Quarter $quarter): bool
    {
        return $user->checkPermissionTo('delete Quarter');
    }

    /**
     * Determine whether the user can delete any models.
     */
    public function deleteAny(User $user): bool
    {
        return $user->checkPermissionTo('delete-any Quarter');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Quarter $quarter): bool
    {
        return $user->checkPermissionTo('restore Quarter');
    }

    /**
     * Determine whether the user can restore any models.
     */
    public function restoreAny(User $user): bool
    {
        return $user->checkPermissionTo('restore-any Quarter');
    }

    /**
     * Determine whether the user can replicate the model.
     */
    public function replicate(User $user, Quarter $quarter): bool
    {
        return $user->checkPermissionTo('replicate Quarter');
    }

    /**
     * Determine whether the user can reorder the models.
     */
    public function reorder(User $user): bool
    {
        return $user->checkPermissionTo('reorder Quarter');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Quarter $quarter): bool
    {
        return $user->checkPermissionTo('force-delete Quarter');
    }

    /**
     * Determine whether the user can permanently delete any models.
     */
    public function forceDeleteAny(User $user): bool
    {
        return $user->checkPermissionTo('force-delete-any Quarter');
    }
}
