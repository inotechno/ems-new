<?php

namespace App\Jobs;

use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendAnnouncement implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 5;
    public $announcement;
    /**
     * Create a new job instance.
     */
    public function __construct($announcement)
    {
        $this->announcement = $announcement;
    }

    /**
     * Execute the job.
     */
    public function handle(EmailService $emailService): void
    {
        try {
            foreach ($this->announcement->recipients as $recipient) {
                $send = $emailService->sendAnnouncement($this->announcement, $recipient);
                if (!$send['success']) {
                    \Log::error('Failed to send announcement to ' . $recipient->email . ': ' . $send['message']);
                }
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send announcement: ' . $e->getMessage());
        }
    }
}
