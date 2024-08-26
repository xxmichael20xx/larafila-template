<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->setupSuperAdmin();
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
}
