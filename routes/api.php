<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\GuardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');


Route::post('/login', [GuardController::class, 'login'])->name('guard.login');
Route::post('/logout', [GuardController::class, 'logout'])->name('guard.logout');
Route::get('/keys', [GuardController::class, 'keys'])->name('guard.keys');
Route::get('/borrowed', [GuardController::class, 'borrowed'])->name('guard.borrowed');
Route::post('/scan', [GuardController::class, 'scan'])->name('guard.scan');
Route::get('/borrow-list', [GuardController::class, 'borrow_list'])->name('guard.borrow-list');
Route::get('/return-list', [GuardController::class, 'return_list'])->name('guard.return-list');
Route::get('/key-list', [GuardController::class, 'key_list'])->name('guard.key-list');
Route::post('/return/{id}', [GuardController::class, 'return'])->name('guard.return');
Route::post('/return', [GuardController::class, 'return'])->name('guard.return');
