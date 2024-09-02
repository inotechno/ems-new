<?php

namespace App\Http\Controllers;

use App\Models\EmailTemplate;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

class SendEmailController extends Controller
{
    protected $EmailService;

    public function __construct(EmailService $EmailService)
    {
        $this->EmailService = $EmailService;
    }

    public function newUser(Request $request)
    {
        $user = User::where('email', 'ahmad.fatoni@mindotek.com')->first();

        if($user == null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        try {
            $emailSent = $this->EmailService->sendTemplateEmail($user, 'new-account-register');

            if (!$emailSent) {
                return response()->json(['error' => 'Failed to send email'], 500);
            }

            return response()->json(['success' => 'Email successfully sent to ' . $user->email], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
