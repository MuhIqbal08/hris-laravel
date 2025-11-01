<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Buat role Admin
        $admin = Role::create([
            'name' => 'Admin',
            'guard_name' => 'web'
        ]);

        // Ambil semua permission
        $permissions = Permission::pluck('name')->all();

        // Beri semua permission ke Admin
        $admin->syncPermissions($permissions);
    }
}
