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
    Route::post('/login-credential', [GuardController::class, 'login'])->name('guard.login');

});

Route::get('barrow/delete/{id}', [BarrowCrudController::class, 'key_return'])->name('barrow.delete');

Route::get('barrow/soft_delete/{id}', [BarrowCrudController::class, 'soft_delete'])->name('barrow.soft_delete');

Route::get('barrow/restore_delete/{id}', [ArchiveBorrowCrudController::class, 'restore'])->name('barrow.restore');

Route::get('return/soft_delete/{id}', [RetrunCrudController::class, 'soft_delete'])->name('return.soft_delete');

Route::get('return/restore_delete/{id}', [ArchiveReturnCrudController::class, 'restore'])->name('return.restore');



