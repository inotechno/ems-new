<?php

use App\Http\Controllers\IClockController;
use App\Livewire\Activity\ActivityIndex;
use App\Livewire\Announcement\AnnouncementDetail;
use App\Livewire\Announcement\AnnouncementForm;
use App\Livewire\Announcement\AnnouncementIndex;
use App\Livewire\Auth\Login;
use App\Livewire\Report\AbsentRequest;
use App\Livewire\Report\Attendance;
use App\Livewire\Report\DailyReport;
use App\Livewire\Report\FinancialRequest;
use App\Livewire\Report\LeaveRequest;
use App\Livewire\Report\Visit;
use App\Livewire\Role\RoleForm;
use App\Livewire\Setting\SettingForm;
use App\Livewire\Site\SiteForm;
use App\Livewire\TestComponent;
use App\Livewire\Role\RoleIndex;
use App\Livewire\Site\SiteIndex;
use App\Livewire\Site\SiteDetail;
use App\Livewire\Profile\ProfileForm;
use App\Livewire\Project\ProjectForm;
use Illuminate\Support\Facades\Route;
use App\Livewire\Machine\MachineIndex;
use App\Livewire\Profile\ProfileIndex;
use App\Livewire\Project\ProjectIndex;
use App\Livewire\Employee\EmployeeForm;
use App\Livewire\Project\ProjectDetail;
use App\Livewire\Employee\EmployeeIndex;
use App\Livewire\Position\PositionIndex;
use App\Livewire\Employee\EmployeeDetail;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Attendance\AttendanceForm;
use App\Livewire\Attendance\AttendanceIndex;
use App\Livewire\DailyReport\DailyReportAll;
use App\Livewire\Department\DepartmentIndex;
use App\Http\Controllers\SendEmailController;
use App\Livewire\Attendance\AttendanceDetail;
use App\Livewire\DailyReport\DailyReportForm;
use App\Livewire\DailyReport\DailyReportTeam;
use App\Livewire\Department\DepartmentDetail;
use App\Livewire\DailyReport\DailyReportIndex;
use App\Livewire\LeaveRequest\LeaveRequestAll;
use App\Http\Controllers\ImageUploadController;
use App\Livewire\DailyReport\DailyReportDetail;
use App\Livewire\LeaveRequest\LeaveRequestForm;
use App\Livewire\LeaveRequest\LeaveRequestTeam;
use App\Livewire\AbsentRequest\AbsentRequestAll;
use App\Livewire\LeaveRequest\LeaveRequestIndex;
use App\Livewire\AbsentRequest\AbsentRequestForm;
use App\Livewire\AbsentRequest\AbsentRequestTeam;
use App\Livewire\LeaveRequest\LeaveRequestDetail;
use App\Livewire\AbsentRequest\AbsentRequestIndex;
use App\Livewire\AbsentRequest\AbsentRequestDetail;
use App\Livewire\Attendance\AttendanceCreate;
use App\Livewire\AttendanceTemp\AttendanceTempIndex;
use App\Livewire\FinancialRequest\FinancialRequestForm;
use App\Livewire\FinancialRequest\FinancialRequestTeam;
use App\Livewire\FinancialRequest\FinancialRequestIndex;
use App\Livewire\ImportMasterData\ImportMasterDataIndex;
use App\Livewire\FinancialRequest\FinancialRequestDetail;
use App\Livewire\EmailTemplateManager\EmailTemplateManagerForm;
use App\Livewire\EmailTemplateManager\EmailTemplateManagerIndex;
use App\Livewire\FinancialRequest\FinancialRequestAll;
use App\Livewire\Visit\VisitCreate;
use App\Livewire\Visit\VisitIndex;

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

Route::get('/iclock/cdata', [IClockController::class, 'handshake']);
Route::post('/iclock/cdata', [IClockController::class, 'receiveRecords']);

Route::get('/iclock/test', [IClockController::class, 'test']);
Route::get('/iclock/getrequest', [IClockController::class, 'getrequest']);
Route::post('/test-attendance', [IClockController::class, 'testAttendance']);

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
        Route::get('create', AttendanceCreate::class)->name('attendance.create');
    });

    Route::group(['prefix' => 'attendance-temporary'], function () {
        Route::get('/', AttendanceTempIndex::class)->name('attendance-temporary.index')->middleware(['can:view:attendance-temp']);
    });

    Route::group(['prefix' => 'visit'], function () {
        Route::get('/', VisitIndex::class)->name('visit.index')->middleware(['can:view:visit']);
        Route::get('create', VisitCreate::class)->name('visit.create');
    });

    Route::group(['prefix' => 'activity'], function () {
        Route::get('/', ActivityIndex::class)->name('activity.index')->middleware('can:view:activity');
    });

    Route::get('/daily-report-all', DailyReportAll::class)->name('daily-report.all')->middleware('can:view:daily-report-all');
    Route::get('/absent-request-all', AbsentRequestAll::class)->name('absent-request.all')->middleware('can:view:absent-request-all');
    Route::get('/leave-request-all', LeaveRequestAll::class)->name('leave-request.all')->middleware('can:view:leave-request-all');
    Route::get('/financial-request-all', FinancialRequestAll::class)->name('financial-request.all')->middleware('can:view:financial-request-all');

    Route::group(['prefix' => 'daily-report'], function () {
        Route::get('/', DailyReportIndex::class)->name('daily-report.index')->middleware('can:view:daily-report');
        Route::get('team', DailyReportTeam::class)->name('team-daily-report.index')->middleware('can:view:daily-report');
        Route::get('create', DailyReportForm::class)->name('daily-report.create')->middleware('can:create:daily-report');
        Route::get('edit/{id}', DailyReportForm::class)->name('daily-report.edit')->middleware('can:update:daily-report');
        Route::get('detail/{id}', DailyReportDetail::class)->name('daily-report.detail')->middleware('can:view:daily-report');
    });

    Route::group(['prefix' => 'absent-request'], function () {
        Route::get('/', AbsentRequestIndex::class)->name('absent-request.index')->middleware('can:view:absent-request');
        Route::get('team', AbsentRequestTeam::class)->name('team-absent-request.index')->middleware('can:view:absent-request');
        Route::get('create', AbsentRequestForm::class)->name('absent-request.create')->middleware('can:create:absent-request');
        Route::get('edit/{id}', AbsentRequestForm::class)->name('absent-request.edit')->middleware('can:update:absent-request');
        Route::get('detail/{id}', AbsentRequestDetail::class)->name('absent-request.detail')->middleware('can:view:absent-request');
    });

    Route::group(['prefix' => 'leave-request'], function () {
        Route::get('/', LeaveRequestIndex::class)->name('leave-request.index')->middleware('can:view:leave-request');
        Route::get('team', LeaveRequestTeam::class)->name('team-leave-request.index')->middleware('can:view:leave-request');
        Route::get('create', LeaveRequestForm::class)->name('leave-request.create')->middleware('can:create:leave-request');
        Route::get('edit/{id}', LeaveRequestForm::class)->name('leave-request.edit')->middleware('can:update:leave-request');
        Route::get('detail/{id}', LeaveRequestDetail::class)->name('leave-request.detail')->middleware('can:view:leave-request');
    });

    Route::group(['prefix' => 'financial-request'], function () {
        Route::get('/', FinancialRequestIndex::class)->name('financial-request.index')->middleware('can:view:financial-request');
        Route::get('team', FinancialRequestTeam::class)->name('team-financial-request.index')->middleware('can:view:financial-request');
        Route::get('create', FinancialRequestForm::class)->name('financial-request.create')->middleware('can:create:financial-request');
        Route::get('edit/{id}', FinancialRequestForm::class)->name('financial-request.edit')->middleware('can:update:financial-request');
        Route::get('detail/{id}', FinancialRequestDetail::class)->name('financial-request.detail')->middleware('can:view:financial-request');
    });

    Route::group(['prefix' => 'announcement'], function () {
        Route::get('/', AnnouncementIndex::class)->name('announcement.index')->middleware('can:view:announcement');
        Route::get('create', AnnouncementForm::class)->name('announcement.create')->middleware('can:create:announcement');
        Route::get('edit/{slug}', AnnouncementForm::class)->name('announcement.edit')->middleware('can:update:announcement');
        Route::get('detail/{slug}', AnnouncementDetail::class)->name('announcement.detail')->middleware('can:view:announcement');
    });

    Route::group(['prefix' => 'email-template'], function () {
        Route::get('/', EmailTemplateManagerIndex::class)->name('email-template.index');
        Route::get('create', EmailTemplateManagerForm::class)->name('email-template.create');
        Route::get('edit/{slug}', EmailTemplateManagerForm::class)->name('email-template.edit');
    });

    Route::group(['prefix' => 'setting'], function () {
        Route::get('/', SettingForm::class)->name('setting.edit');
    });

    Route::group(['prefix' => 'report'], function () {
        Route::get('/attendance', Attendance::class)->name('report.attendance')->middleware('can:view:report-attendance');
        Route::get('/daily-report', DailyReport::class)->name('report.daily.report')->middleware('can:view:report-daily-report');
        Route::get('/financial-request', FinancialRequest::class)->name('report.financial.request')->middleware('can:view:report-financial-request');
        Route::get('/absent-request', AbsentRequest::class)->name('report.absent.request')->middleware('can:view:report-absent-request');
        Route::get('/leave-request', LeaveRequest::class)->name('report.leave.request')->middleware('can:view:report-leave-request');
        Route::get('/visit', Visit::class)->name('report.visit')->middleware('can:view:report-visit');
    });
});
