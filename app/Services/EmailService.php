<?php

namespace App\Services;

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

    public function sendTemplateEmail(?User $user, string $templateSlug): bool
    {
        try {
            $template = EmailTemplate::where('slug', $templateSlug)->first();

            if (!$template || !$user) {
                return false;
            }

            $decodedHtml = htmlspecialchars_decode($template->body);
            $body = Blade::render($decodedHtml, ['user' => $user]);
            $subject = Blade::render($template->subject, ['user' => $user]);

            $this->beautymail->send('email.template', ['body' => $body], function ($message) use ($user, $subject) {
                $message->to($user->email)
                    ->subject($subject);
            });

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
