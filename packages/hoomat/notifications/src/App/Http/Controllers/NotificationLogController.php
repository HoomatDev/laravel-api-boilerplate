<?php

namespace Hoomat\Notifications\App\Http\Controllers;

use Hoomat\Base\App\Http\Controllers\Controller;
use Hoomat\Notifications\App\Http\Requests\NotificationChangeStatusRequest;
use Hoomat\Notifications\App\Models\NotificationLog;
use Hoomat\Notifications\App\Services\NotificationLogService;
use Illuminate\Http\JsonResponse;

/**
 * @group Notification
 */
class NotificationLogController extends Controller
{
    public function __construct(
        private readonly NotificationLogService $logService
    )
    {
    }


    /**
     * Cancel Notification Log
     *
     * @param NotificationChangeStatusRequest $request
     * @param NotificationLog                 $notificationLog
     * @return JsonResponse
     */
    public function changeStatus(NotificationChangeStatusRequest $request, NotificationLog $notificationLog): JsonResponse
    {
        if ($notificationLog->status === 3) {
            return $this->errorResponse([], 400, __('error.notification_cant_be_canceled'));
        }

        $this->logService->changeStatus($notificationLog, $request->input('status'));
        return $this->successResponse();
    }
}
