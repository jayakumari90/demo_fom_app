<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('users', [UserController::class, 'index'])->name('user.index');
Route::post('users/store', [UserController::class, 'store'])->name('user.store');
Route::post('users/data', [UserController::class, 'getData'])->name('user.data');
