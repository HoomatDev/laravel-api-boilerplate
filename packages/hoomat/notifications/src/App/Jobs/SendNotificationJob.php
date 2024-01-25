<?php

namespace Hoomat\Notifications\App\Jobs;

use Hoomat\Notifications\App\Models\NotificationLog;
use Hoomat\Notifications\App\Notifications\PublicNotification;
use Hoomat\Notifications\App\Services\NotificationLogService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;
use Throwable;

class SendNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * Create a new job instance.
     */
    public function __construct(private readonly NotificationLog $notifLog)
    {
    }


    /**
     * Execute the job.
     *
     * @throws Throwable
     */
    public function handle(
        NotificationLogService $logService
    ): void
    {
        try {
            $log = $this->notifLog->refresh();
            if ($log->status !== 2) {
                Notification::sendNow($log->receiver, new PublicNotification($log->notification));

                $logService->changeStatus($log, 3);
            }
        } catch (Throwable $th) {
            $logService->changeStatus($this->notifLog, 4);
            throw $th;
        }
    }
}
