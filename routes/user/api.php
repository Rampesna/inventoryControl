<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(function () {
    Route::post('login', [\App\Http\Controllers\Api\User\UserController::class, 'login'])->name('user.api.login');
    Route::post('sendPasswordResetEmail', [\App\Http\Controllers\Api\User\UserController::class, 'sendPasswordResetEmail'])->name('api.user.sendPasswordResetEmail');
    Route::post('resetPassword', [\App\Http\Controllers\Api\User\UserController::class, 'resetPassword'])->name('api.user.resetPassword');
});

Route::middleware([
    'auth:user_api',
])->group(function () {

    Route::get('getProfile', [\App\Http\Controllers\Api\User\UserController::class, 'getProfile'])->name('user.api.getProfile');
    Route::post('swapTheme', [\App\Http\Controllers\Api\User\UserController::class, 'swapTheme'])->name('user.api.swapTheme');
    Route::post('updatePassword', [\App\Http\Controllers\Api\User\UserController::class, 'updatePassword'])->name('user.api.updatePassword');

    Route::prefix('user')->group(function () {
//        Route::get('getAll', [\App\Http\Controllers\Api\User\UserController::class, 'getAll'])->name('user.api.user.getAll');
//        Route::get('index', [\App\Http\Controllers\Api\User\UserController::class, 'index'])->name('user.api.user.index');
//        Route::get('getById', [\App\Http\Controllers\Api\User\UserController::class, 'getById'])->name('user.api.user.getById');
//        Route::get('getByEmail', [\App\Http\Controllers\Api\User\UserController::class, 'getByEmail'])->name('user.api.user.getByEmail');
//        Route::post('create', [\App\Http\Controllers\Api\User\UserController::class, 'create'])->name('user.api.user.create');
//        Route::put('update', [\App\Http\Controllers\Api\User\UserController::class, 'update'])->name('user.api.user.update');
//        Route::delete('delete', [\App\Http\Controllers\Api\User\UserController::class, 'delete'])->name('user.api.user.delete');
    });

    Route::prefix('employee')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\EmployeeController::class, 'getAll'])->name('user.api.employee.getAll');
        Route::get('getAllWithDevices', [\App\Http\Controllers\Api\User\EmployeeController::class, 'getAllWithDevices'])->name('user.api.employee.getAllWithDevices');
        Route::post('create', [\App\Http\Controllers\Api\User\EmployeeController::class, 'create'])->name('user.api.employee.create');
        Route::post('setDevices', [\App\Http\Controllers\Api\User\EmployeeController::class, 'setDevices'])->name('user.api.employee.setDevices');
    });

    Route::prefix('device')->group(function () {
        Route::get('index', [\App\Http\Controllers\Api\User\DeviceController::class, 'index'])->name('user.api.device.index');
        Route::get('paginateByEmployeeId', [\App\Http\Controllers\Api\User\DeviceController::class, 'paginateByEmployeeId'])->name('user.api.device.paginateByEmployeeId');
        Route::get('getById', [\App\Http\Controllers\Api\User\DeviceController::class, 'getById'])->name('user.api.device.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\DeviceController::class, 'create'])->name('user.api.device.create');
        Route::put('update', [\App\Http\Controllers\Api\User\DeviceController::class, 'update'])->name('user.api.device.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\DeviceController::class, 'delete'])->name('user.api.device.delete');
    });

    Route::prefix('deviceCategory')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\DeviceCategoryController::class, 'getAll'])->name('user.api.deviceCategory.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\DeviceCategoryController::class, 'getById'])->name('user.api.deviceCategory.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\DeviceCategoryController::class, 'create'])->name('user.api.deviceCategory.create');
        Route::put('update', [\App\Http\Controllers\Api\User\DeviceCategoryController::class, 'update'])->name('user.api.deviceCategory.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\DeviceCategoryController::class, 'delete'])->name('user.api.deviceCategory.delete');
    });

    Route::prefix('deviceStatus')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\DeviceStatusController::class, 'getAll'])->name('user.api.deviceStatus.getAll');
        Route::get('getById', [\App\Http\Controllers\Api\User\DeviceStatusController::class, 'getById'])->name('user.api.deviceStatus.getById');
        Route::post('create', [\App\Http\Controllers\Api\User\DeviceStatusController::class, 'create'])->name('user.api.deviceStatus.create');
        Route::put('update', [\App\Http\Controllers\Api\User\DeviceStatusController::class, 'update'])->name('user.api.deviceStatus.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\DeviceStatusController::class, 'delete'])->name('user.api.deviceStatus.delete');
    });

    Route::prefix('devicePackage')->group(function () {
        Route::get('getAll', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'getAll'])->name('user.api.devicePackage.getAll');
        Route::get('index', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'index'])->name('user.api.devicePackage.index');
        Route::get('getById', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'getById'])->name('user.api.devicePackage.getById');
        Route::get('getDevices', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'getDevices'])->name('user.api.devicePackage.getDevices');
        Route::post('setDevices', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'setDevices'])->name('user.api.devicePackage.setDevices');
        Route::post('updateEmployee', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'updateEmployee'])->name('user.api.devicePackage.updateEmployee');
        Route::post('create', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'create'])->name('user.api.devicePackage.create');
        Route::put('update', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'update'])->name('user.api.devicePackage.update');
        Route::delete('delete', [\App\Http\Controllers\Api\User\DevicePackageController::class, 'delete'])->name('user.api.devicePackage.delete');
    });
});
