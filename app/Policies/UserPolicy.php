<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Database\Data\AdminPermissionsData;

class UserPolicy
{
    /**
     * Perform pre-authorization checks.
     *
     * @return null|bool
     */
    public function before(User $user): ?true
    {
        if ($user->isSuperAdmin()) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole(Role::ADMIN) || $user->hasPermissionTo(AdminPermissionsData::CAN_VIEW_USER);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN) || $user->hasPermissionTo(AdminPermissionsData::CAN_VIEW_USER);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(Role::ADMIN) || $user->hasPermissionTo(AdminPermissionsData::CAN_CREATE_USER);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN) || $user->hasPermissionTo(AdminPermissionsData::CAN_UPDATE_USER);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN) || $user->hasPermissionTo(AdminPermissionsData::CAN_DELETE_USER);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, User $model): bool
    {
        return $user->hasRole(Role::ADMIN) || $user->hasPermissionTo(AdminPermissionsData::CAN_RESTORE_USER);
    }
}
