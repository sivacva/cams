<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', function () {
    return view('site/login');
});

// Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');

// Dashboard route (Protected by check.session middleware)
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'no.cache', 'check.session'])->name('dashboard');

//master
Route::get('/department', function () {
    return view('pages/department');
});
Route::get('/region', function () {
    return view('pages/region');
});
Route::get('/state', function () {
    return view('pages/state');
});
Route::get('/index', function () {
    return view('index2');
});
Route::get('/header', function () {
    return view('layouts.dash_navbar');
});
Route::get('/sidenav', function () {
    return view('layouts.dash_sidebar');
});
Route::get('/create_user', function () {
    return view('usermanagement.createuser');
});

Route::get('/assign_charge', function () {
    return view('usermanagement/assigncharge');
});
Route::get('/privileges', function () {
    return view('privileges/privileges');
});

Route::get('/audit_diary', function () {
    return view('audit/auditdiary');
});


// Route::get('/audit_plan', function () {
//     return view('audit/auditplan');
// });
// Route::get('/audit_team', function () {
//     return view('audit/auditteam');
// });
Route::get('/audit_datefixing', function () {
    return view('audit/auditdatefixing');
});
Route::get('/calendar', function () {
    return view('audit/calendar');
});
Route::get('/list_objections', function () {
    return view('audit/listofobjections');
});


Route::get('/view_intimation', function () {
    return view('audit/viewintimationdetails');
});
Route::get('/auditee', function () {
    return view('audit/auditee');
});
Route::get('/init_auditschedule', function () {
    return view('audit/initauditschedule');
});

Route::get('/district', [App\Http\Controllers\MasterController::class, 'viewDistrict']);

Route::post('/departmentSave', [App\Http\Controllers\MasterController::class, 'saveDepartment'])->name('department.save');
Route::post('/regionSave', [App\Http\Controllers\MasterController::class, 'saveRegion'])->name('region.save');
Route::post('/districtSave', [App\Http\Controllers\MasterController::class, 'saveDistrict'])->name('district.save');
Route::post('/stateSave', [App\Http\Controllers\MasterController::class, 'saveState'])->name('state.save');

Route::get('/', function () {
    return view('site/homepage');
});
Route::get('/state/data', [App\Http\Controllers\MasterController::class, 'getStatesList'])->name('state.list');
Route::get('/dist/data', [App\Http\Controllers\MasterController::class, 'getdistsList'])->name('dist.list');
Route::get('/dist/edit/{id}', [App\Http\Controllers\MasterController::class, 'getdistsedit'])->name('dist.edit');
Route::post('/audit/storeOrUpdate', [App\Http\Controllers\AuditSchedule::class, 'storeOrUpdate'])->name('audit.audit_datefixing');
Route::get('audit_datefixing', [App\Http\Controllers\AuditSchedule::class, 'creatauditschedule_dropdownvalues'])->name('audit_datefixing')->defaults('viewName', 'audit.auditdatefixing');
// Route::get('/audit/audit_members', [App\Http\Controllers\AuditSchedule::class, 'audit_members'])->name('audit.audit_datefixing');
Route::post('/audit/fetchAllScheduleData', [App\Http\Controllers\AuditSchedule::class, 'fetchAllScheduleData'])->name('audit.audit_datefixing');
Route::post('/audit/fetchschedule_data', [App\Http\Controllers\AuditSchedule::class, 'fetchschedule_data'])->name('audit.audit_datefixing');

// Route::post('/users', [UserManagementController::class, 'insert'])->name('users.insertuser');


// Login route (POST)
Route::post('/login', [App\Http\Controllers\LoginController::class, 'login'])->name('login');


// Route::get('/dashboard', function () {
//     return view('dashboard/dashboard');
// });


// Route::post('/user/insert', [App\Http\Controllers\UserManagementController::class, 'storeOrUpdate'])->name('user.insert');
// Route::post('/user/fetchAllData', [App\Http\Controllers\UserManagementController::class, 'fetchAllData'])->name('user.fetchAllData');
// Route::post('/user/fetchUserData', [App\Http\Controllers\UserManagementController::class, 'fetchUserData'])->name('user.fetchUserData');
// Route::get('/create_user', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_user')->defaults('viewName', 'usermanagement.createuser');


// // Route for the createuser page
// Route::get('/create_charge', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_charge')->defaults('viewName', 'usermanagement.createcharge');
Route::get('/dashboard_detail', [App\Http\Controllers\DashboardController::class, 'dashboard_detail'])->name('dashboard.dashboard_detail');


// Protected User Management Routes
Route::middleware('check.session')->group(function () {

    //     Route::post('/user/insert', [App\Http\Controllers\UserManagementController::class, 'storeOrUpdate'])->name('user.insert');
    //     Route::post('/user/fetchAllData', [App\Http\Controllers\UserManagementController::class, 'fetchAllData'])->name('user.fetchAllData');
    //     Route::post('/user/fetchUserData', [App\Http\Controllers\UserManagementController::class, 'fetchUserData'])->name('user.fetchUserData');
    //     Route::get('/create_user', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_user')->defaults('viewName', 'usermanagement.createuser');
    //     Route::get('/create_charge', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_charge')->defaults('viewName', 'usermanagement.createcharge');
    //     Route::get('/field_audit', action: [App\Http\Controllers\FieldAuditController::class, 'auditfield_dropdown'])->name('create_charge')->defaults('viewName', 'usermanagement.createcharge');
    //     Route::post('/getauditslip', [App\Http\Controllers\FieldAuditController::class, 'getauditslip'])->name('FiedAudit.getauditslip');
    //     Route::post('/audislip_insert', [App\Http\Controllers\FieldAuditController::class, 'audislip_insert'])->name('FiedAudit.audislip_insert');

    // Route::post('/get-auditors', [App\Http\Controllers\AuditTeam::class, 'getAuditors']);
    // Route::get('/audit_team', [App\Http\Controllers\AuditTeam::class, 'creatuser_dropdownvalues'])->name('audit_team')->defaults('viewName', 'audit.auditteam');
    // Route::post('/audit/createAuditTeam', [App\Http\Controllers\AuditTeam::class, 'createAuditTeam'])->name('audit.audit_team');
    // Route::post('/audit/fetchAllData', [App\Http\Controllers\AuditTeam::class, 'fetchAllData'])->name('audit.audit_team');
    // Route::post('/audit/fetchTeamData', [App\Http\Controllers\AuditTeam::class, 'fetchTeamData'])->name('audit.audit_team');
    /********************************************************************* Create User - URL ******************************************************************* */

    Route::post('/user/insert', [App\Http\Controllers\UserManagementController::class, 'storeOrUpdate'])->name('user.insert');
    Route::post('/user/fetchAllData', [App\Http\Controllers\UserManagementController::class, 'fetchAllData'])->name('user.fetchAllData');
    Route::post('/user/fetchUserData', [App\Http\Controllers\UserManagementController::class, 'fetchUserData'])->name('user.fetchUserData');
    Route::get('/create_user', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_user')->defaults('viewName', 'usermanagement.createuser');

    /********************************************************************* Create User - URL ******************************************************************* */


    /********************************************************************* Create charge - URL ******************************************************************* */

    Route::get('/create_charge', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_charge')->defaults('viewName', 'usermanagement.createcharge');

    /********************************************************************* Create charge - URL ******************************************************************* */


    /********************************************************************* Audit Team - URL ******************************************************************* */

    Route::post('/get-auditors', [App\Http\Controllers\AuditTeam::class, 'getAuditors']);
    Route::get('/audit_team', [App\Http\Controllers\AuditTeam::class, 'creatuser_dropdownvalues'])->name('audit_team')->defaults('viewName', 'audit.auditteam');
    Route::post('/audit/createAuditTeam', [App\Http\Controllers\AuditTeam::class, 'createAuditTeam'])->name('audit.audit_team');
    Route::post('/audit/fetchAllData', [App\Http\Controllers\AuditTeam::class, 'fetchAllData'])->name('audit.audit_team');
    Route::post('/audit/fetchTeamData', [App\Http\Controllers\AuditTeam::class, 'fetchTeamData'])->name('audit.audit_team');

    /********************************************************************* Audit Team - URL ******************************************************************* */


    /********************************************************************* Field Audit - URL ******************************************************************* */
    //  Route::get('/field_audit',  [App\Http\Controllers\FieldAuditController::class, 'auditfield_dropdown'])->name('fieldaudit');
    Route::post('/getsubobjection', [App\Http\Controllers\FieldAuditController::class, 'getsubobjection'])->name('FiedAudit.getsubobjection');
    Route::post('/getauditslip', [App\Http\Controllers\FieldAuditController::class, 'getauditslip'])->name('FiedAudit.getauditslip');
    Route::post('/audislip_insert', [App\Http\Controllers\FieldAuditController::class, 'audislip_insert'])->name('FiedAudit.audislip_insert');
    Route::post('/auditeereply', [App\Http\Controllers\FieldAuditController::class, 'auditeereply'])->name('FiedAudit.auditeereply');

    Route::post('/getviewauditslip', [App\Http\Controllers\FieldAuditController::class, 'getviewauditslip'])->name('FiedAudit.getviewauditslip');

    // Route::get('/auditee_fieldaudit', [App\Http\Controllers\FieldAuditController::class, 'auditfield_dropdown'])
    // ->name('auditee_fieldaudit')
    // ->defaults('viewvalue', 'fieldaudit.auditeeslip');

    // Route::get('/field_audit', [App\Http\Controllers\FieldAuditController::class, 'auditfield_dropdown'])
    // ->name('field_audit')
    // ->defaults('viewvalue', 'fieldaudit.fieldaudit');
    Route::get('/auditee_fieldaudit', [App\Http\Controllers\FieldAuditController::class, 'slipdetails_dropdown'])
        ->name('slipdetails_dropdown')
        ->defaults('viewvalue', 'fieldaudit.auditeeslip');

    Route::get('/audit_slip/{id}', [App\Http\Controllers\FieldAuditController::class, 'auditslip_dropdown'])
        ->name('audit_slip')
        ->defaults('viewvalue', 'fieldaudit.auditslip');


    // Route::get('/field_audit', [App\Http\Controllers\FieldAuditController::class, 'auditfield_dropdown'])
    // ->name('field_audit')
    // ->defaults('viewvalue', 'fieldaudit.fieldaudit');
    Route::get('/field_audit/{id}', [App\Http\Controllers\FieldAuditController::class, 'auditfield_dropdown'])
        ->name('field_audit')
        ->defaults('viewvalue', 'fieldaudit.fieldaudit');


    Route::get('/init_fieldaudit', [App\Http\Controllers\FieldAuditController::class, 'init_fieldaudit'])->name('FiedAudit.init_fieldaudit');




    Route::post('/update_slip', [App\Http\Controllers\FieldAuditController::class, 'update_slip'])->name('FiedAudit.update_slip');
    //////workall/////
    Route::post('/fetchminorworkdel', [App\Http\Controllers\FieldAuditController::class, 'fetchminorworkdel'])->name('FiedAudit.fetchminorworkdel');
    Route::post('/insert_workAllocation', [App\Http\Controllers\FieldAuditController::class, 'insert_workAllocation'])->name('FiedAudit.insert_workAllocation');
    Route::post('/fetchAllWorkData', [App\Http\Controllers\FieldAuditController::class, 'fetchAllWorkData'])->name('FiedAudit.fetchAllWorkData');
    Route::post('/fetch_singleworkdet', [App\Http\Controllers\FieldAuditController::class, 'fetch_singleworkdet'])->name('FiedAudit.fetch_singleworkdet');

    //////workall/////
    /********************************************************************* Audit Team - URL ******************************************************************* */
});

Route::get('/audit_diary', function () {
    return view('audit/auditdiary');
});

Route::get('audit_diary', [App\Http\Controllers\AuditDiaryController::class, 'FetchworkallocationDetailsdropdown'])->name('audit_diary_data')->defaults('viewName', 'audit.audit_diary_data');
Route::post('/audit_diary/insert', [App\Http\Controllers\AuditDiaryController::class, 'storeOrUpdateAuditDiary'])->name('auditdiary.insert');


Route::post('/audit_plan/insert', [App\Http\Controllers\AuditManagementController::class, 'storeOrUpdateAudit'])->name('auditplan.insert');
Route::post('/audit_plan/fetchAllData', [App\Http\Controllers\AuditManagementController::class, 'auditfetchAllData'])->name('auditplan.fetchAllData');
Route::get('/audit_plan/{id}', [AuditManagementController::class, 'show'])->name('auditplan.show');
Route::post('/audit_plan/update', [App\Http\Controllers\AuditManagementController::class, 'storeOrUpdateAudit'])->name('auditplan.update');
Route::post('/audit_plan/fetchUserData', [App\Http\Controllers\AuditManagementController::class, 'fetchUserDataAudit'])->name('auditplan.fetchUserData');
Route::post('/audit_plan/FilterByDept', [App\Http\Controllers\AuditManagementController::class, 'FilterByDept'])->name('auditplan.FilterByDept');
Route::get('/audit_plan', [App\Http\Controllers\AuditManagementController::class, 'creatuser_dropdownvalues'])->name('audit_plan')->defaults('viewName', 'audit/auditplan');
/********************************************************************* Audit Schedule - URL ******************************************************************* */

Route::get('audit_datefixing/', [App\Http\Controllers\AuditSchedule::class, 'creatauditschedule_dropdownvalues'])->name('audit_datefixing')->defaults('viewName', 'audit.auditdatefixing');
Route::post('/audit/audit_members', [App\Http\Controllers\AuditSchedule::class, 'audit_members'])->name('audit.audit_datefixing');
Route::post('/audit/fetchAllScheduleData', [App\Http\Controllers\AuditSchedule::class, 'fetchAllScheduleData'])->name('audit.audit_datefixing');
Route::post('/audit/fetchschedule_data', [App\Http\Controllers\AuditSchedule::class, 'fetchschedule_data'])->name('audit.audit_datefixing');
// Route::post('/audit/audit_scheduledetails', [App\Http\Controllers\AuditSchedule::class, 'audit_scheduledetails'])->name('audit.auditee');

Route::post('/audit/auditee_intimation', [App\Http\Controllers\AuditSchedule::class, 'auditee_intimation'])->name('audit.view_intimation');

Route::post('/audit/audit_plandetails', [App\Http\Controllers\AuditManagementController::class, 'audit_plandetails'])->name('audit.initauditschedule');
/********************************************************************* Audit Schedule - URL ******************************************************************* */
/********************************************************************* Auditee ******************************************************************* */
Route::post('/audit/audit_scheduledetails', [App\Http\Controllers\AuditeeController::class, 'audit_scheduledetails'])->name('audit.auditee');
Route::post('/audit/auditee_acceptdetails', [App\Http\Controllers\AuditeeController::class, 'auditee_acceptdetails'])->name('audit.auditee');

Route::post('/audit/auditee_partialchange', [App\Http\Controllers\AuditeeController::class, 'auditee_partialchange'])->name('audit.audit_datefixing');
Route::get('/audit/audit_particulars', [App\Http\Controllers\AuditeeController::class, 'audit_particulars'])->name('audit.auditee');
Route::post('/audit/auditee_accept', [App\Http\Controllers\AuditeeController::class, 'auditee_accept'])->name('audit.auditee');

Route::get('/download-auditor-diary', [App\Http\Controllers\AuditDiaryController::class, 'downloadDiary']);


// Route::get('/field_audit', function () {
//     return view('fieldaudit');
// });

// Protected Charge Route
// Route::middleware('check.session')->get('/create_charge', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_charge')->defaults('viewName', 'usermanagement.createcharge');

// Route::middleware('check.session')->get('/create_charge', [App\Http\Controllers\UserManagementController::class, 'creatuser_dropdownvalues'])->name('create_charge')->defaults('viewName', 'usermanagement.createcharge');
// Route::middleware('check.session')->get('/dashboard', function () {
//     return view('dashboard.dashboard');
// })->name('dashboard');


// Route::get('/dashboard', function () {
//     dd(session()->all());  // Dump the session data to check if 'username' exists

//     return view('dashboard');
// })->middleware(['auth', 'no.cache', 'check.session'])->name('dashboard');



Route::post('/logout', [App\Http\Controllers\LoginController::class, 'logout'])->name('logout');



Route::middleware('check.session')->get('/dashboard', function () {
    return view('dashboard.dashboard');
})->name('dashboard');



Route::middleware('check.session')->get('/auditeedashboard', function () {
    return view('dashboard.auditeedashboard');
})->name('auditeedashboard');


Route::post('/auditee_validatelogin', [App\Http\Controllers\LoginController::class, 'auditee_validatelogin'])->name('auditee_validatelogin');


Route::post('/getpendingparadetails', [App\Http\Controllers\FieldAuditController::class, 'getpendingparadetails'])->name('FiedAudit.getpendingparadetails');

Route::get('/pendingparra', [App\Http\Controllers\FieldAuditController::class, 'pendingparra'])->name('FiedAudit.pendingparra');


Route::post('/auditdiary/fetchAllData', [App\Http\Controllers\AuditDiaryController::class, 'FetchDiarydetails'])->name('auditdiary.fetch');

Route::get('/auditeelogin', function () {
    return view('site/auditeelogin');
});
