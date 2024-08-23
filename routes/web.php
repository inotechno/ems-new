<?php

use App\Livewire\Auth\Login;
use App\Livewire\Role\RoleForm;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Site\SiteForm;
use App\Livewire\Site\SiteIndex;
use App\Livewire\TestComponent;
use App\Livewire\Employee\EmployeeIndex;
use App\Livewire\Employee\EmployeeForm;
use App\Livewire\Employee\EmployeeDetail;
use App\Livewire\Attendance\AttendanceIndex;
use App\Livewire\Attendance\AttendanceDetail;
use App\Livewire\Attendance\AttendanceForm;
use App\Livewire\Project\ProjectForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Machine\MachineIndex;
use App\Livewire\Project\ProjectIndex;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Position\PositionIndex;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Department\DepartmentIndex;
use App\Livewire\Department\DepartmentDetail;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/test-component', TestComponent::class)->name('test-component');

Route::get('/login', Login::class)->name('login')->middleware('guest');

Route::group(['prefix' => '/', 'middleware' => ['auth']], function () {
    Route::get('/', DashboardIndex::class)->name('dashboard.index');
    Route::get('dashboard', DashboardIndex::class)->name('dashboard.index');

    Route::get('machine', MachineIndex::class)->name('machine.index');
    Route::group(['prefix' => 'site'], function () {
        Route::get('/', SiteIndex::class)->name('site.index');
        Route::get('create', SiteForm::class)->name('site.create');
        Route::get('edit/{uid}', SiteForm::class)->name('site.edit');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::get('/', DepartmentIndex::class)->name('department.index');
        Route::get('detail/{id}', DepartmentDetail::class)->name('department.detail');
    });

    Route::group(['prefix' => 'position'], function () {
        Route::get('/', PositionIndex::class)->name('position.index');
        Route::get('detail/{id}', DepartmentDetail::class)->name('position.detail');
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('/', ProjectIndex::class)->name('project.index');
        Route::get('detail/{id}', ProjectDetail::class)->name('project.detail');
        Route::get('create', ProjectForm::class)->name('project.create');
        Route::get('edit/{id}', ProjectForm::class)->name('project.edit');
    });
    Route::group(['prefix' => 'role'], function () {
        Route::get('/', RoleIndex::class)->name('role.index');
    });
    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', EmployeeIndex::class)->name('employee.index');
        Route::get('detail/{id}', EmployeeDetail::class)->name('employee.detail');
        Route::get('create', EmployeeForm::class)->name('employee.create');
        Route::get('edit/{id}', EmployeeForm::class)->name('employee.edit');
    });
    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/', AttendanceIndex::class)->name('attendance.index');
        // Route::get('detail/{id}', AttendanceDetail::class)->name('attendance.detail');
        // Route::get('create', AttendanceForm::class)->name('attendance.create');
        // Route::get('edit/{id}', AttendanceForm::class)->name('attendance.edit');
    });

    // Route::get('site', 'path.to.view')->name('site.index');
    // Route::get('department', 'path.to.view')->name('department.index');
    // Route::get('role', 'path.to.view')->name('role.index');
    // Route::get('user', 'path.to.view')->name('user.index');
    // Route::get('employee', 'path.to.view')->name('employee.index');
    // Route::get('attendance', 'path.to.view')->name('attendance.index');
    // Route::get('attendance-temporary', 'path.to.view')->name('attendance-temporary.index');

    Route::group(['prefix' => 'daily-report'], function () {
        // Route::get('/', 'path.to.view')->name('daily-report.index');
        // Route::get('team', 'path.to.view')->name('team-daily-report.index');
    });

    Route::group(['prefix' => 'absence-request'], function () {
        // Route::get('/', 'path.to.view')->name('absence-request.index');
        // Route::get('team', 'path.to.view')->name('team-absence-request.index');
    });
});
