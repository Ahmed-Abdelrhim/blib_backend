<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Dashboard\AdminAuthController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Dashboard\EmployeeController as DashboardEmployeeController;
use App\Http\Controllers\Dashboard\CompanyController as DashboardCompanyController;
use App\Http\Controllers\Dashboard\IndustryController;
use App\Http\Controllers\Dashboard\PlanController;

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

//App Auth Routes 
Route::post('/employee/auth/login', [AuthController::class, 'login']);
Route::post('/employee/auth/forgot-password', [AuthController::class, 'forgetPassword']);
Route::middleware(['auth:sanctum', 'abilities:otp'])->post('/employee/auth/verify', [AuthController::class, 'verify']);
Route::middleware(['auth:sanctum', 'abilities:otp'])->get('/employee/auth/resend-otp', [AuthController::class, 'resendOTP']);
Route::middleware(['auth:sanctum', 'abilities:employee'])->post('/employee/auth/update-password', [AuthController::class, 'updatePassword']);
Route::middleware(['auth:sanctum', 'abilities:employee'])->get('/employee/auth/logout', [AuthController::class, 'logout']);
Route::get('/employee/auth/get-domains', [DashboardCompanyController::class, 'getDomains']);

//App Employee Profile Routes
Route::middleware(['auth:sanctum', 'abilities:employee'])->post('/employee/profile/update-profile-data', [EmployeeController::class, 'updateEmployeeData']);


//Sanctum Route Group
// Route::group(['middleware' => ['auth:sanctum','abilities:admin']], function() {
// Route::group(['middleware' => ['auth:sanctum', 'abilities:admin'], 'prefix' => 'dashboard'], function () {
// });
