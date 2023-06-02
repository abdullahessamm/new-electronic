<?php

use App\Http\Controllers\Api\Users\LoginController;
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
