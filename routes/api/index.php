<?php

use App\Http\Controllers\Api\EmployeesController;
use App\Http\Controllers\Api\ExportsController;
use App\Http\Controllers\Api\ImportsController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\MonthlyReportingIncentiveController;
use App\Http\Controllers\Api\ProfileSettingsController;
use App\Http\Controllers\Api\SparePartsPermitsController;
use App\Http\Controllers\Api\UsersController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('auth')
->controller(LoginController::class)
->group(__DIR__ . DIRECTORY_SEPARATOR . 'auth.php');

Route::middleware('auth:sanctum')
->group(function () {
    // users
    Route::prefix('users')
    ->controller(UsersController::class)
    ->group(__DIR__ . DIRECTORY_SEPARATOR . 'users.php');

    // imports
    Route::apiResource('imports', ImportsController::class);
    // exports
    Route::apiResource('exports', ExportsController::class);

    // Spare parts permits
    Route::prefix('sparePartsPermits')
    ->controller(SparePartsPermitsController::class)
    ->group(__DIR__ . DIRECTORY_SEPARATOR . 'sparePartsPermits.php');

    // employees
    Route::prefix('employees')
    ->controller(EmployeesController::class)
    ->group(__DIR__ . DIRECTORY_SEPARATOR . 'employees.php');

    // Monthly Reporting Incentives
    Route::apiResource('monthly-reporting-incentives', MonthlyReportingIncentiveController::class);

    Route::patch('profile/settings', [ProfileSettingsController::class, 'update']);
});