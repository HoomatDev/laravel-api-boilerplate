<?php

use Hoomat\Notifications\App\Http\Controllers\NotificationController;
use Hoomat\Notifications\App\Http\Controllers\NotificationLogController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => config('NotificationsConfig.prefix'),
    'middleware' => config('NotificationsConfig.middleware'),
], function () {

     Route::post('/webpush', [NotificationController::class, 'webpushInit']);

    Route::put('/logs/{notificationLog}/status', [NotificationLogController::class, 'changeStatus']);

    Route::apiResource('', NotificationController::class)->only(['index', 'store'])->names('notifications');
    Route::put('/{notification}/status', [NotificationController::class, 'changeStatus'])->name('notifications.status');
    Route::get('/{notification}', [NotificationController::class, 'show'])->name('notifications.show');
});
