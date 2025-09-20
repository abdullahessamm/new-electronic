<?php

use Illuminate\Support\Facades\Route;

Route::get('/{params}', function () {
    return view('dashboard');
})->where('params', '.*');
