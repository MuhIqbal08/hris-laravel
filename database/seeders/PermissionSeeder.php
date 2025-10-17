<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'role.view',
            'role.create',
            'role.edit',
            'role.delete',
            'employee.view',
            'employee.create',
            'employee.edit',
            'employee.delete',
            'department.view',
            'department.create',
            'department.edit',
            'department.delete',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

    }
}
