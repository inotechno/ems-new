<?php

namespace App\Jobs;

use App\Models\User;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // Tentukan jumlah retry jika job gagal
    public $tries = 5;

    public $recipient;
    public $templateSlug;
    public $additionalData;
    public $sender;

    public function __construct(User $recipient, string $templateSlug, array $additionalData = [], ?User $sender = null)
    {
        $this->recipient = $recipient;
        $this->templateSlug = $templateSlug;
        $this->additionalData = $additionalData;
        $this->sender = $sender;
    }

    /**
     * Execute the job.
     */
    public function handle(EmailService $emailService)
    {
        $emailService->sendTemplateEmail($this->recipient, $this->templateSlug, $this->additionalData, $this->sender);
    }
}
