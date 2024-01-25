<?php

use Hoomat\Identities\App\Http\Controllers\PermissionController;
use Hoomat\Identities\App\Http\Controllers\RoleController;
use Hoomat\Identities\App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('IdentitiesConfig.prefix'),
    'middleware' => config('IdentitiesConfig.middleware')
], function() {

    Route::put('/profile', [UserController::class, 'update'])->name('profile.update');

    Route::apiResource('roles', RoleController::class)->except(['show', 'destroy']);

    Route::get('/permissions', [PermissionController::class, 'index'])->name('permissions.index');
});
