<?php

use Hoomat\Filesystem\App\Http\Controllers\FileController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('FilesystemConfig.prefix'),
    'middleware' => config('FilesystemConfig.middleware'),
], function () {

    // Route::apiResource('', FileController::class)->except(['store']);
    Route::get('', [FileController::class, 'index']);
    Route::put('/{file}', [FileController::class, 'update']);
    Route::delete('/{file}', [FileController::class, 'destroy']);
});
