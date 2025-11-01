<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
// use Spatie\Permission\Models\Role;
// use Spatie\Permission\Models\Permission;

class AdminSeeder extends Seeder
{
    /**
     * Jalankan seeder.
     */
    public function run(): void
    {
        // 1. Buat department default
        $department = Department::firstOrCreate(
            ['name' => 'Human Resources'],
            ['uuid' => Str::uuid()]
        );

        // 2. Buat akun admin di tabel users
        $user = User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'uuid' => Str::uuid(),
                'name' => 'Administrator',
                'password' => Hash::make('password'), // Ganti sesuai kebutuhan
            ]
        );

        // 3. Buat data employee
        Employee::firstOrCreate(
            ['user_id' => $user->uuid],
            [
                'uuid' => Str::uuid(),
                'employee_id' => 'ADM001',
                'position' => 'Administrator',
                'department_id' => $department->uuid,
                'join_date' => now(),
            ]
        );

        // 4. Buat role Admin jika belum ada
        $role = Role::firstOrCreate(
            ['name' => 'Admin', 'guard_name' => 'web'],
            ['uuid' => Str::uuid()]
        );

        // 5. Ambil semua permission yang ada
        $permissions = Permission::all();

        // 6. Beri semua permission ke role Admin
        $role->syncPermissions($permissions);

        // 7. Assign role Admin ke user admin
        if (!$user->hasRole('Admin')) {
            $user->assignRole('Admin');
        }

        $this->command->info('✅ Akun admin berhasil dibuat!');
        $this->command->info('Email: admin@example.com');
        $this->command->info('Password: password');
        $this->command->info('Semua permission telah diberikan ke role Admin.');
    }
}
