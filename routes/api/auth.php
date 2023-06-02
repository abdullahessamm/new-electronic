<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', 'login')->name('login');

Route::middleware('auth:sanctum')
->group(function () {
    
    Route::get('/user', function (Request $request) {
        return $request->user()->currentAccessToken();
    });

    Route::post('/logout', 'logout');

});
