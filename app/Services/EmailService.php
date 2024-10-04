<?php

namespace App\Services;

use App\Models\CategoryEmailTemplate;
use Snowfire\Beautymail\Beautymail;
use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Support\Facades\Blade;

class EmailService
{
    protected $beautymail;

    public function __construct(Beautymail $beautymail)
    {
        $this->beautymail = $beautymail;
    }

    public function sendTemplateEmail(?User $recipient, string $templateSlug, array $additionalData = [], ?User $sender = null): array
    {
        try {
            $template = CategoryEmailTemplate::with('template')->where('slug', $templateSlug)->first()->template;

            if (!$template || !$recipient) {
                \Log::info('Template or user not found');
                return ['success' => false, 'message' => 'Template or user not found'];
            }

            $data = array_merge(['recipient' => $recipient, 'sender' => $sender], $additionalData);

            $decodedHtml = htmlspecialchars_decode($template->body);
            $body = Blade::render($decodedHtml, $data);
            $subject = Blade::render($template->subject, $data);

            // \Log::info($body);
            \Log::info(json_encode($data));

            $this->beautymail->send('email.template', ['body' => $body], function ($message) use ($recipient, $subject) {
                $message->to($recipient->email)
                    ->subject($subject);
            });

            \Log::info('Email sent to ' . $recipient->email);
            return ['success' => true, 'message' => 'Email successfully sent to ' . $recipient->email];
        } catch (\Exception $e) {
            \Log::error('Failed to send email: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return ['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()];
        }
    }

    public function sendAnnouncement($announcement, $recipient): array
    {
        try {
            $decodedHtml = htmlspecialchars_decode($announcement->description);
            $body = Blade::render($decodedHtml, ['user' => $recipient]);
            $title = Blade::render($announcement->title, ['user' => $recipient]);

            $this->beautymail->send('email.template', ['body' => $body], function ($message) use ($recipient, $title) {
                $message->to($recipient->email)
                    ->subject($title);
            });

            \Log::info('Email sent to ' . $recipient->email);
            return ['success' => true, 'message' => 'Announcement successfully sent'];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to send announcement: ' . $e->getMessage()];
        }
    }
}
