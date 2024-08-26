<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create the super admin user
        $user = User::query()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'superadmin@domain.com',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now()
        ]);

        // Assign super admin role
        $user->assignRole(Role::SUPER_ADMIN);
    }
}
