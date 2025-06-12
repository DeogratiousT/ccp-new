<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\ProbeController;
use App\Http\Controllers\Dashboard\SectionController;
use App\Http\Controllers\Dashboard\ConditionController;

Route::get('/', function () {
    return to_route('dashboard.home');
});

Route::middleware(['auth'])->prefix('dashboard')->name('dashboard.')->group(function () {
    Route::middleware(['without.old.password'])->group(function () {
        Route::get('/users/password/reset', [HomeController::class, 'passwordResetIndex'])->name('users.password.reset.index');
        Route::post('/users/password/reset', [HomeController::class, 'passwordReset'])->name('users.password.reset');
    });

    Route::middleware([
        'has.old.password', 
        'user-has-role:Super Admin,Technical Admin,Operational Admin'
    ])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('home');

        Route::resource('users', UserController::class);
        
        Route::resource('sections', SectionController::class);
        Route::resource('probes', ProbeController::class);
        Route::resource('conditions', ConditionController::class);
        Route::resource('readings', ConditionController::class);
    });
});
