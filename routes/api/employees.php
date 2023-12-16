<?php

use Illuminate\Support\Facades\Route;

Route::get('', 'index');
Route::get('{id}', 'show')->where('id', '^[0-9]+$');
Route::patch('{id}', 'update')->where('id', '^[0-9]+$');
Route::put('', 'create');
Route::patch('{id}/fees', 'updateFees')->where('id', '^[0-9]+$');
Route::delete('{id}', 'delete')->where('id', '^[0-9]+$');
