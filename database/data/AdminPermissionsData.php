<?php

namespace Database\Data;

class AdminPermissionsData
{
    const CAN_VIEW_USER = 'Can View User';
    const CAN_CREATE_USER = 'Can Create User';
    const CAN_UPDATE_USER = 'Can Update User';
    const CAN_DELETE_USER = 'Can Delete User';
    const CAN_RESTORE_USER = 'Can Restore User';

    /**
     * Define the admin permissions.
     *
     * @return array
     */
    public static function adminPermissions(): array
    {
        return [
            self::CAN_VIEW_USER,
            self::CAN_CREATE_USER,
            self::CAN_UPDATE_USER,
            self::CAN_DELETE_USER,
            self::CAN_RESTORE_USER,
        ];
    }
}
