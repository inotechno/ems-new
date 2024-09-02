<?php

use App\Http\Controllers\ImageUploadController;
use App\Http\Controllers\SendEmailController;
use App\Livewire\Auth\Login;
use App\Livewire\DailyReport\DailyReportForm;
use App\Livewire\DailyReport\DailyReportTeam;
use App\Livewire\EmailTemplateManager\EmailTemplateManagerIndex;
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
use App\Livewire\DailyReport\DailyReportAll;
use App\Livewire\DailyReport\DailyReportDetail;
use App\Livewire\DailyReport\DailyReportIndex;
use App\Livewire\Project\ProjectForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Machine\MachineIndex;
use App\Livewire\Project\ProjectIndex;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Position\PositionIndex;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Department\DepartmentIndex;
use App\Livewire\Department\DepartmentDetail;
use App\Livewire\EmailTemplateManager\EmailTemplateManagerForm;
use App\Livewire\ImportMasterData\ImportMasterDataIndex;
use App\Livewire\Site\SiteDetail;
use App\Livewire\Profile\ProfileIndex;
use App\Livewire\Profile\ProfileForm;

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
    Route::post('upload-image', [ImageUploadController::class, 'upload']);
    Route::get('send-mail', [SendEmailController::class, 'newUser'])->name('send-mail');

    Route::get('/', DashboardIndex::class)->name('dashboard.index')->middleware('can:view:dashboard');
    Route::get('dashboard', DashboardIndex::class)->name('dashboard.index')->middleware('can:view:dashboard');
    Route::get('import-master-data', ImportMasterDataIndex::class)->name('import.index')->middleware('can:view:import_master_data');

    Route::get('machine', MachineIndex::class)->name('machine.index')->middleware('can:view:machine');

    Route::group(['prefix' => 'site'], function () {
        Route::get('/', SiteIndex::class)->name('site.index')->middleware('can:view:site');
        Route::get('create', SiteForm::class)->name('site.create')->middleware('can:create:site');
        Route::get('edit/{uid}', SiteForm::class)->name('site.edit')->middleware('can:update:site');
        Route::get('detail/{uid}', SiteDetail::class)->name('site.detail')->middleware('can:view:site');
    });

    Route::group(['prefix' => 'department'], function () {
        Route::get('/', DepartmentIndex::class)->name('department.index')->middleware('can:view:department');
        Route::get('detail/{id}', DepartmentDetail::class)->name('department.detail')->middleware('can:view:department');
    });

    Route::group(['prefix' => 'position'], function () {
        Route::get('/', PositionIndex::class)->name('position.index')->middleware('can:view:position');
        Route::get('detail/{id}', DepartmentDetail::class)->name('position.detail')->middleware('can:view:position');
    });

    Route::group(['prefix' => 'project'], function () {
        Route::get('/', ProjectIndex::class)->name('project.index')->middleware('can:view:project');
        Route::get('detail/{id}', ProjectDetail::class)->name('project.detail')->middleware('can:view:project');
        Route::get('create', ProjectForm::class)->name('project.create')->middleware('can:create:project');
        Route::get('edit/{id}', ProjectForm::class)->name('project.edit')->middleware('can:update:project');
    });

    Route::group(['prefix' => 'role'], function () {
        Route::get('/', RoleIndex::class)->name('role.index')->middleware('can:view:role');
        Route::get('create', RoleForm::class)->name('role.create')->middleware('can:create:role');
        Route::get('edit/{id}', RoleForm::class)->name('role.edit')->middleware('can:update:role');
    });

    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', EmployeeIndex::class)->name('employee.index')->middleware('can:view:employee');
        Route::get('detail/{id}', EmployeeDetail::class)->name('employee.detail')->middleware('can:view:employee');
        Route::get('create', EmployeeForm::class)->name('employee.create')->middleware('can:create:employee');
        Route::get('edit/{id}', EmployeeForm::class)->name('employee.edit')->middleware('can:update:employee');
    });

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', ProfileIndex::class)->name('profile.index')->middleware('can:view:profile');
        Route::get('edit/{id}', ProfileForm::class)->name('profile.edit')->middleware('can:update:profile');
    });

    Route::group(['prefix' => 'attendance'], function () {
        Route::get('/', AttendanceIndex::class)->name('attendance.index')->middleware(['can:view:attendance']);
        // Route::get('detail/{id}', AttendanceDetail::class)->name('attendance.detail');
        // Route::get('create', AttendanceForm::class)->name('attendance.create');
        // Route::get('edit/{id}', AttendanceForm::class)->name('attendance.edit');
    });

    Route::get('/daily-report-all', DailyReportAll::class)->name('daily-report.all')->middleware('can:view:daily-report-all');

    // Route::get('site', 'path.to.view')->name('site.index');
    // Route::get('department', 'path.to.view')->name('department.index');
    // Route::get('role', 'path.to.view')->name('role.index');
    // Route::get('user', 'path.to.view')->name('user.index');
    // Route::get('employee', 'path.to.view')->name('employee.index');
    // Route::get('attendance', 'path.to.view')->name('attendance.index');
    // Route::get('attendance-temporary', 'path.to.view')->name('attendance-temporary.index');

    Route::group(['prefix' => 'daily-report'], function () {
        Route::get('/', DailyReportIndex::class)->name('daily-report.index')->middleware('can:view:daily-report');
        Route::get('team', DailyReportTeam::class)->name('team-daily-report.index')->middleware('can:view:daily-report');
        Route::get('create', DailyReportForm::class)->name('daily-report.create')->middleware('can:create:daily-report');
        Route::get('edit/{id}', DailyReportForm::class)->name('daily-report.edit')->middleware('can:update:daily-report');
        Route::get('detail/{id}', DailyReportDetail::class)->name('daily-report.detail')->middleware('can:view:daily-report');
        // Route::get('/', 'path.to.view')->name('daily-report.index');
        // Route::get('team', 'path.to.view')->name('team-daily-report.index');
    });

    Route::group(['prefix' => 'absence-request'], function () {
        // Route::get('/', 'path.to.view')->name('absence-request.index');
        // Route::get('team', 'path.to.view')->name('team-absence-request.index');
    });

    Route::group(['prefix' => 'email-template'], function () {
        Route::get('/', EmailTemplateManagerIndex::class)->name('email-template.index');
        Route::get('create', EmailTemplateManagerForm::class)->name('email-template.create');
        Route::get('edit/{slug}', EmailTemplateManagerForm::class)->name('email-template.edit');
    });
});
