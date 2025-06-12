<?php

use App\Http\Controllers\Dashboard\ConditionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProbeController;
use App\Http\Controllers\Dashboard\SectionController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('dashboard')->name('dashboard.')->group( function () {
    Route::resource('sections', SectionController::class);
    Route::resource('probes', ProbeController::class);
    Route::resource('conditions', ConditionController::class);
    Route::resource('readings', ConditionController::class);
});
