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

    public function sendTemplateEmail(?User $user, string $templateSlug): array
    {
        try {
            $template = CategoryEmailTemplate::with('template')->where('slug', $templateSlug)->first()->template;

            if (!$template || !$user) {
                return ['success' => false, 'message' => 'Template or user not found'];
            }

            $decodedHtml = htmlspecialchars_decode($template->body);
            $body = Blade::render($decodedHtml, ['user' => $user]);
            $subject = Blade::render($template->subject, ['user' => $user]);

            $this->beautymail->send('email.template', ['body' => $body], function ($message) use ($user, $subject) {
                $message->to($user->email)
                    ->subject($subject);
            });

            return ['success' => true, 'message' => 'Email successfully sent to ' . $user->email];
        } catch (\Exception $e) {
            return ['success' => false, 'message' => 'Failed to send email: ' . $e->getMessage()];
        }
    }
}
