<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\RuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::prefix('samples')->name('samples.')->group(function () {
    Route::get('/', [SampleController::class, 'index'])->name('index');
    Route::get('/create/{material}', [SampleController::class, 'create'])->name('create');
    Route::post('/', [SampleController::class, 'store'])->name('store');
    Route::get('/{sample}', [SampleController::class, 'show'])->name('show');
});

Route::prefix('settings')->name('settings.')->group(function () {
    Route::get('/', [RuleController::class, 'index'])->name('index');
    Route::post('/rules', [RuleController::class, 'store'])->name('rules.store');
    Route::put('/rules/{rule}', [RuleController::class, 'update'])->name('rules.update');
    Route::delete('/rules/{rule}', [RuleController::class, 'destroy'])->name('rules.destroy');
});
