<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SendEmailController extends Controller
{

    public function newUser(Request $request)
    {
        $template = EmailTemplate::where('slug', 'new-account-register')->first();
        $user = User::where('email', 'ahmad.fatoni@mindotek.com')->first();

        if (!$template || !$user) {
            return 'Template or user not found';
        }

        $decodedHtml = htmlspecialchars_decode($template->body);

        $replacements = [
            '{{ $user->name }}' => $user->name,
            '{{ $user->email }}' => $user->email,
            '{{ $user->username }}' => $user->username,
            '{{ $user->password }}' => $user->password_string,
            '{{ $user->created_at }}' => $user->created_at->format('d M Y'),
        ];

        $body = strtr($decodedHtml, $replacements);

        // Mail::to($user->email)->send(new \App\Mail\SendEmail($user, $template));
        $beautymail = app()->make(\Snowfire\Beautymail\Beautymail::class);
        $beautymail->send('email.template', ['body' => $body], function ($message) use ($user, $template) {
            $message
                ->to($user->email)
                ->subject($template->subject);
        });

        return 'Email successfully sent to ' . $user->email;
    }
}
