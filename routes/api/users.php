<?php

use Illuminate\Support\Facades\Route;

Route::get('', 'index')
->name('users.index');

Route::get('{id}', 'show')
->where('id', '^[0-9]+$')
->name('users.show');

Route::put('', 'store')
->name('users.store');

Route::patch('{id}', 'update')
->where('id', '^[0-9]+$')
->name('users.update');

Route::delete('{id}', 'destroy')
->where('id', '^[0-9]+$')
->name('users.delete');
