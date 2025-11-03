<?php

use App\Livewire\Attendance\AttendanceCreate;
use App\Livewire\Attendance\AttendanceEdit;
use App\Livewire\Attendance\AttendanceIndex;
use App\Livewire\Attendance\AttendanceShow;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Dashboard\DashboardUserIndex;
use App\Livewire\Department\DepartmentCreate;
use App\Livewire\Department\DepartmentEdit;
use App\Livewire\Department\DepartmentIndex;
use App\Livewire\Department\DepartmentShow;
use App\Livewire\Employee\EmployeeCreate;
use App\Livewire\Employee\EmployeeEdit;
use App\Livewire\Employee\EmployeeIndex;
use App\Livewire\Employee\EmployeeShow;
use App\Livewire\EmployeeSchedule\EmployeeSchedulesCreate;
use App\Livewire\EmployeeSchedule\EmployeeSchedulesEdit;
use App\Livewire\EmployeeSchedule\EmployeeSchedulesIndex;
use App\Livewire\EmployeeSchedule\EmployeeSchedulesShow;
use App\Livewire\Leave\LeaveCreate;
use App\Livewire\Leave\LeaveEdit;
use App\Livewire\Leave\LeaveIndex;
use App\Livewire\Leave\LeaveShow;
use App\Livewire\Location\LocationCreate;
use App\Livewire\Location\LocationEdit;
use App\Livewire\Location\LocationIndex;
use App\Livewire\Location\LocationShow;
use App\Livewire\Payroll\PayrollCreate;
use App\Livewire\Payroll\PayrollEdit;
use App\Livewire\Payroll\PayrollIndex;
use App\Livewire\Payroll\PayrollShow;
use App\Livewire\Permission\PermissionCreate;
use App\Livewire\Permission\PermissionEdit;
use App\Livewire\Permission\PermissionIndex;
use App\Livewire\Permission\PermissionShow;
use App\Livewire\Role\RoleCreate;
use App\Livewire\Role\RoleEdit;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Role\RoleShow;
use App\Livewire\Salary\SalaryCreate;
use App\Livewire\Salary\SalaryEdit;
use App\Livewire\Salary\SalaryIndex;
use App\Livewire\Salary\SalaryShow;
use App\Livewire\WorkSchedule\WorkSchedulesCreate;
use App\Livewire\WorkSchedule\WorkSchedulesEdit;
use App\Livewire\WorkSchedule\WorkSchedulesIndex;
use App\Livewire\WorkSchedule\WorkSchedulesShow;
use App\Models\WorkSchedule;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('dashboard/user', DashboardUserIndex::class)->name('dashboard.user');

    Route::get('employee', EmployeeIndex::class)->name('employee.index')->middleware("permission:employee.view|employee.create|employee.edit|employee.show");
    Route::get('employee/create', EmployeeCreate::class)->name('employee.create')->middleware("permission:employee.create");
    Route::get('employee/{uuid}/detail', EmployeeShow::class)->name('employee.show')->middleware("permission:employee.view");
    Route::get('employee/{uuid}/edit', EmployeeEdit::class)->name('employee.edit')->middleware("permission:employee.edit");

    Route::get('department', DepartmentIndex::class)->name('department.index')->middleware("permission:department.view|department.create|department.edit|department.show");
    Route::get('department/create', DepartmentCreate::class)->name('department.create')->middleware("permission:department.create");
    Route::get('department/{uuid}/edit', DepartmentEdit::class)->name('department.edit')->middleware("permission:department.view");
    Route::get('department/{uuid}/detail', DepartmentShow::class)->name('department.show')->middleware("permission:department.show");

    Route::get('role', RoleIndex::class)->name('role.index')->middleware("permission:role.view|role.create|role.edit|role.show");
    Route::get('role/create', RoleCreate::class)->name('role.create')->middleware("permission:role.create");
    Route::get('role/{uuid}/edit', RoleEdit::class)->name('role.edit')->middleware("permission:role.edit");
    Route::get('role/{uuid}/detail', RoleShow::class)->name('role.show')->middleware("permission:role.view");

    Route::get('work/schedule', WorkSchedulesIndex::class)->name('work.schedule.index')->middleware("permission:work-schedule.view|work-schedule.create|work-schedule.edit|work-schedule.show");
    Route::get('work/schedule/create', WorkSchedulesCreate::class)->name('work.schedule.create')->middleware("permission:work-schedule.create");
    Route::get('work/schedule/{uuid}/edit', WorkSchedulesEdit::class)->name('work.schedule.edit')->middleware("permission:work-schedule.edit");
    Route::get('work/schedule/{uuid}/detail', WorkSchedulesShow::class)->name('work.schedule.show')->middleware("permission:work-schedule.view");

    Route::get('/employee/schedules', EmployeeSchedulesIndex::class)->name('employee.schedules.index')->middleware("permission:employee-schedule.view|employee-schedule.create|employee-schedule.edit|employee-schedule.show");
    Route::get('/employee/schedules/create', EmployeeSchedulesCreate::class)->name('employee.schedules.create')->middleware("permission:employee-schedule.create");
    Route::get('/employee/schedules/{uuid}/edit', EmployeeSchedulesEdit::class)->name('employee.schedules.edit')->middleware("permission:employee-schedule.edit");
    Route::get('/employee/schedules/{uuid}/detail', EmployeeSchedulesShow::class)->name('employee.schedules.show')->middleware("permission:employee-schedule.view");

    Route::get('/location', LocationIndex::class)->name('location.index')->middleware("permission:location.view|location.create|location.edit|location.show");
    Route::get('/location/create', LocationCreate::class)->name('location.create')->middleware("permission:location.create");
    Route::get('/location/{uuid}/edit', LocationEdit::class)->name('location.edit')->middleware("permission:location.edit");
    Route::get('/location/{uuid}/detail', LocationShow::class)->name('location.show')->middleware("permission:location.view");
    
    Route::get('/attendance', AttendanceIndex::class)->name('attendance.index')->middleware("permission:attendance.view|attendance.create|attendance.check-in-out|attendance.show|attendance.edit|attendance.delete");
    Route::get('/attendance/create', AttendanceCreate::class)->name('attendance.create')->middleware("permission:attendance.create");
    Route::get('/attendance/{uuid}/edit', AttendanceEdit::class)->name('attendance.edit')->middleware("permission:attendance.edit");
    Route::get('/attendance/{uuid}/detail', AttendanceShow::class)->name('attendance.show')->middleware("permission:attendance.view");
    
    Route::get('/permission', PermissionIndex::class)->name('permission.index')->middleware("permission:permission.view|permission.create|permission.edit|permission.show");
    Route::get('/permission/create', PermissionCreate::class)->name('permission.create')->middleware("permission:permission.create");
    Route::get('/permission/{uuid}/edit', PermissionEdit::class)->name('permission.edit')->middleware("permission:permission.edit");
    Route::get('/permission/{uuid}/detail', PermissionShow::class)->name('permission.show')->middleware("permission:permission.view");

    Route::get('/leave', LeaveIndex::class)->name('leave.index')->middleware("permission:leave.view|leave.create");
    Route::get('/leave/create', LeaveCreate::class)->name('leave.create')->middleware('leave.create');
    // Route::get('/leave/{uuid}/edit', LeaveEdit::class)->name('leave.edit');
    Route::get('/leave/{uuid}/detail', LeaveShow::class)->name('leave.show')->middleware('leave.view');

    Route::get('/payroll', PayrollIndex::class)->name('payroll.index')->middleware("permission:payroll.view|payroll.create");
    Route::get('/payroll/create', PayrollCreate::class)->name('payroll.create')->middleware("permission:payroll.create");
    Route::get('/payroll/{uuid}/detail', PayrollShow::class)->name('payroll.show')->middleware("permission:payroll.view");

    Route::get('/salary', SalaryIndex::class)->name('salary.index')->middleware("permission:salary.view|salary.create|salary.edit|salary.show");
    Route::get('/salary/create', SalaryCreate::class)->name('salary.create')->middleware("permission:salary.create");
    Route::get('/salary/{uuid}/edit', SalaryEdit::class)->name('salary.edit')->middleware("permission:salary.edit");
    Route::get('/salary/{uuid}/detail', SalaryShow::class)->name('salary.show')->middleware("permission:salary.view");

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
