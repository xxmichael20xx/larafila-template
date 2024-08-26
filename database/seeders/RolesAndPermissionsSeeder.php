<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Database\Data\AdminPermissionsData;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setupSuperAdmin();
        $this->setupAdmin();
    }

    /**
     * Create a Super Admin role
     *
     * @return void
     */
    protected function setupSuperAdmin(): void
    {
        Role::create(['name' => Role::SUPER_ADMIN]);
    }

    /**
     * Set up the admin role and permissions
     *
     * @return void
     */
    protected function setupAdmin(): void
    {
        // Create the admin role
        $admin = Role::create(['name' => Role::ADMIN]);

        // Get the admin permissions
        $permissions = AdminPermissionsData::adminPermissions();

        // Create and give permission to role
        foreach ($permissions as $permission) {
            $_permission = Permission::findOrCreate($permission);

            $admin->givePermissionTo($_permission);
        }
    }
}
