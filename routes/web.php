<?php

use App\Livewire\Department\DepartmentCreate;
use App\Livewire\Department\DepartmentEdit;
use App\Livewire\Department\DepartmentIndex;
use App\Livewire\Department\DepartmentShow;
use App\Livewire\Employee\EmployeeCreate;
use App\Livewire\Employee\EmployeeEdit;
use App\Livewire\Employee\EmployeeIndex;
use App\Livewire\Employee\EmployeeShow;
use App\Livewire\Role\RoleCreate;
use App\Livewire\Role\RoleEdit;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Role\RoleShow;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('employee', EmployeeIndex::class)->name('employee.index')->middleware("permission:employee.index|employee.create|employee.edit|employee.show");
    Route::get('employee/create', EmployeeCreate::class)->name('employee.create')->middleware("permission:employee.create");
    Route::get('employee/{uuid}/detail', EmployeeShow::class)->name('employee.show')->middleware("permission:employee.show");
    Route::get('employee/{uuid}/edit', EmployeeEdit::class)->name('employee.edit')->middleware("permission:employee.edit");

    Route::get('department', DepartmentIndex::class)->name('department.index')->middleware("permission:department.index|department.create|department.edit|department.show");
    Route::get('department/create', DepartmentCreate::class)->name('department.create')->middleware("permission:department.create");
    Route::get('department/{uuid}/edit', DepartmentEdit::class)->name('department.edit')->middleware("permission:department.edit");
    Route::get('department/{uuid}/detail', DepartmentShow::class)->name('department.show')->middleware("permission:department.show");

    Route::get('route', RoleIndex::class)->name('role.index')->middleware("permission:role.index|role.create|role.edit|role.show");
    Route::get('route/create', RoleCreate::class)->name('role.create')->middleware("permission:role.create");
    Route::get('route/{uuid}/edit', RoleEdit::class)->name('role.edit')->middleware("permission:role.edit");
    Route::get('route/{uuid}/detail', RoleShow::class)->name('role.show')->middleware("permission:role.show");

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

require __DIR__.'/auth.php';
