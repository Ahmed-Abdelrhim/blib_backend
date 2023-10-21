<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\AdminAuthController;
use App\Http\Controllers\Dashboard\CMSController;
use App\Http\Controllers\Dashboard\EmployeeExcelController;
use App\Http\Controllers\Dashboard\EmployeeInvitationsController;
use App\Http\Controllers\Dashboard\EmployeeController;
use App\Http\Controllers\Dashboard\CompanyController;
use App\Http\Controllers\Dashboard\DepartmentController;
use App\Http\Controllers\Dashboard\IndustryController;
use App\Http\Controllers\Dashboard\PlanController;
use App\Http\Controllers\Dashboard\DropdownController;
use App\Http\Controllers\Dashboard\EquipmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('departments/export/test', [DepartmentController::class, 'exportTest']);
Route::get('employees/export/test', [EmployeeController::class, 'exportTest']);


Route::group(['prefix' => 'dashboard'], function () {

    Route::post('auth/login', [AdminAuthController::class, 'login']);
    Route::post('auth/forgot-password', [AdminAuthController::class, 'forgetPassword']);
    Route::get('plans/get-all', [PlanController::class, 'index']);
    Route::get('industry/get-all', [IndustryController::class, 'index']);
    Route::post('companies/register', [CompanyController::class, 'register']);

    // ABILITY OTP
    Route::group(['middleware' => ['auth:sanctum', 'abilities:otp']], function () {
        Route::post('auth/resend-otp', [AdminAuthController::class, 'resendOTP']);
        Route::post('auth/verify', [AdminAuthController::class, 'verify']);
    });

    // ABILITY ADMIN
    Route::group(['middleware' => ['auth:sanctum', 'abilities:admin']], function () {
        Route::post('auth/update-password', [AdminAuthController::class, 'updatePassword']);
        Route::get('auth/logout', [AdminAuthController::class, 'logout']);

        Route::post('companies/subscribe-to-plan', [CompanyController::class, 'subscribeToPlan']);

        // EMPLOYEE EXCEL AND SEND EMAIL INVITATIONS
        Route::get('employees/template-excel', [EmployeeExcelController::class, 'getTemplateExcel']);
        Route::post('employees/import-review', [EmployeeExcelController::class, 'importExcelReview']);
        Route::post('employees/import-save', [EmployeeExcelController::class, 'jsonExcelSave']);
        Route::post('employees/send-invitations', [EmployeeInvitationsController::class, 'sendInvitations']);
        Route::get('employees/template-invitations', [EmployeeInvitationsController::class, 'templateInvitations']);
        Route::get('employees/template-invitations/skip', [EmployeeInvitationsController::class, 'skipInvitations']);

        Route::post('company/update-logo', [CompanyController::class, 'updateLogo']);


        // DROPDOWNS CONTENT
        Route::get('dropdowns', DropdownController::class);


        // CMS
        Route::get('cms/list/{type}', [CMSController::class, 'type']);
        Route::post('cms/update/{id}', [CMSController::class, 'update']);
        Route::apiResource('cms', CMSController::class);


        // DEPARTMENTS
        Route::get('departments/select', [DepartmentController::class, 'select']);
        Route::get('departments/paginate', [DepartmentController::class, 'paginate']);
        Route::get('departments/minimum/{id}', [DepartmentController::class, 'showMinimum']);
        Route::post('departments/search', [DepartmentController::class, 'search']);
        Route::post('departments/export', [DepartmentController::class, 'export']);
        Route::post('departments/multi_delete', [DepartmentController::class, 'multiDelete']);
        Route::post('departments/update/{id}', [DepartmentController::class, 'update']);
        Route::apiResource('departments', DepartmentController::class);


        // EMPLOYEES
        Route::get('employees/tree', [EmployeeController::class, 'tree']);
        Route::get('employees/select', [EmployeeController::class, 'select']);
        Route::get('employees/archive', [EmployeeController::class, 'archive']);
        Route::get('employees/archive/paginate', [EmployeeController::class, 'archivePaginate']);
        Route::get('employees/archive/{id}', [EmployeeController::class, 'archiveShow']);
        Route::get('employees/paginate', [EmployeeController::class, 'paginate']);
        Route::get('employees/minimum/{id}', [EmployeeController::class, 'showMinimum']);
        Route::post('employees/export', [EmployeeController::class, 'export']);
        Route::post('employees/restore/{id}', [EmployeeController::class, 'restore']);
        Route::post('employees/search', [EmployeeController::class, 'search']);
        Route::post('employees/search/archive', [EmployeeController::class, 'searchArchive']);
        Route::post('employees/archive/search', [EmployeeController::class, 'searchArchive']);
        Route::post('employees/multi_delete', [EmployeeController::class, 'multiDelete']);
        Route::post('employees/archive/multi_delete', [EmployeeController::class, 'archiveMultiDelete']);
        Route::delete('employees/delete/force/{id}', [EmployeeController::class, 'forceDelete']);
        Route::apiResource('employees', EmployeeController::class);

        // EQUIPMENTS
        Route::apiResource('equipments', EquipmentController::class);
        Route::post('equipments/assign', [EquipmentController::class, 'assign']);
        Route::post('equipments/takeoff', [EquipmentController::class, 'takeOff']);



    });
});


Route::group(['prefix' => 'blip/dashboard', 'middleware' => ['auth:sanctum', 'abilities:admin']], function () {
    //Blip Dashboard Routes
    Route::post('industry/create-industry', [IndustryController::class, 'store']);
    Route::post('plans/create-plan', [PlanController::class, 'store']);
});
