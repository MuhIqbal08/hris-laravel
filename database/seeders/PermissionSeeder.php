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
            'attendance.check-in-out',
            'attendance.create',
            'attendance.delete',
            'attendance.edit',
            'attendance.show',
            'attendance.view',

            'department.create',
            'department.delete',
            'department.edit',
            'department.view',

            'employee.create',
            'employee.delete',
            'employee.edit',
            'employee.view',
            
            'employee-schedule.create',
            'employee-schedule.delete',
            'employee-schedule.edit',
            'employee-schedule.view',
            
            'leave.approve',
            'leave.delete',
            'leave.reject',
            'leave.view',

            'location.create',
            'location.delete',
            'location.edit',
            'location.view',

            'payroll.create',
            'payroll.delete',
            'payroll.paid',
            'payroll.view',

            'permission.create',
            'permission.delete',
            'permission.edit',
            'permission.view',

            'role.create',
            'role.delete',
            'role.edit',
            'role.view',

            'salary.create',
            'salary.delete',
            'salary.edit',
            'salary.view',

            'work-schedule.create',
            'work-schedule.delete',
            'work-schedule.edit',
            'work-schedule.view',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission, 'guard_name' => 'web']
            );
        }

    }
}
