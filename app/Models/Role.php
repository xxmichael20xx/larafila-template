<?php

namespace App\Models;

use App\Exceptions\SuperAdminDeleteException;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    const SUPER_ADMIN = 'Super Admin';

    const ADMIN = 'Admin';

    protected static function boot(): void
    {
        parent::boot();

        static::deleting(function(Role $role) {
            if ($role->name === self::SUPER_ADMIN) {
                throw new SuperAdminDeleteException();
            }
        });
    }
}
