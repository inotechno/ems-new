<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
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
        // dd($request->all());
        $user = User::where('email', $request->email)->first();

        if($user == null) {
            return response()->json(['error' => 'User not found'], 404);
        }

        try {
            SendEmailJob::dispatch($user, 'new-account');
            return response()->json(['success' => 'Email successfully sent to ' . $user->email], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
