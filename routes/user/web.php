<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::get('login', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'login'])->name('user.web.authentication.login.index');
    Route::get('oAuth', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'oAuth'])->name('user.web.authentication.oAuth');
    Route::get('forgotPassword', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'forgotPassword'])->name('user.web.authentication.forgotPassword');
    Route::get('resetPassword/{token?}', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'resetPassword'])->name('user.web.authentication.resetPassword');
});

Route::middleware([
    'auth:user_web'
])->group(function () {

    Route::get('logout', [\App\Http\Controllers\Web\User\AuthenticationController::class, 'logout'])->name('user.web.authentication.logout');

    Route::prefix('dashboard')->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\DashboardController::class, 'index'])->name('user.web.dashboard.index');
    });

    Route::prefix('inventory')->middleware([])->group(function () {
        Route::get('index', [\App\Http\Controllers\Web\User\InventoryController::class, 'index'])->name('user.web.inventory.index');
        Route::get('employee', [\App\Http\Controllers\Web\User\InventoryController::class, 'employee'])->name('user.web.inventory.employee');
        Route::get('device', [\App\Http\Controllers\Web\User\InventoryController::class, 'device'])->name('user.web.inventory.device');
        Route::get('package', [\App\Http\Controllers\Web\User\InventoryController::class, 'package'])->name('user.web.inventory.package');
    });
});
