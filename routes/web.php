<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuardController;
use App\Http\Controllers\Admin\BarrowCrudController;
use App\Http\Controllers\Admin\RetrunCrudController;
use App\Http\Controllers\Admin\ArchiveBorrowCrudController;
use App\Http\Controllers\Admin\ArchiveReturnCrudController;


//Route::permanentRedirect('/{any?}','/admin'); //prevent access to non admin routes

Route::group(['prefix' => 'guard'], function () {
    Route::get('/login', [GuardController::class, 'index'])->name('guard');
    Route::post('/scan', [GuardController::class, 'scan'])->name('guard.scan');
    Route::post('/borrow', [GuardController::class, 'borrow'])->name('guard.borrow');
    Route::post('/return/{id}', [GuardController::class, 'return'])->name('guard.return');
    Route::get('/borrow-list', [GuardController::class, 'borrow_list'])->name('guard.borrow-list');
    Route::get('/return-list', [GuardController::class, 'return_list'])->name('guard.return-list');
    Route::get('/key-list', [GuardController::class, 'key_list'])->name('guard.key-list');
    Route::post('/logout', [GuardController::class, 'logout'])->name('guard.logout');
    route::post('/back', [GuardController::class, 'back'])->name('guard.back');
});

Route::get('barrow/delete/{id}', [BarrowCrudController::class, 'key_return'])->name('barrow.delete');

Route::get('barrow/soft_delete/{id}', [BarrowCrudController::class, 'soft_delete'])->name('barrow.soft_delete');

Route::get('barrow/restore_delete/{id}', [ArchiveBorrowCrudController::class, 'restore'])->name('barrow.restore');

Route::get('return/soft_delete/{id}', [RetrunCrudController::class, 'soft_delete'])->name('return.soft_delete');

Route::get('return/restore_delete/{id}', [ArchiveReturnCrudController::class, 'restore'])->name('return.restore');



