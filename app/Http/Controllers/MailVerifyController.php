<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class MailVerifyController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        $request->fulfill(); // Tandai email sebagai verified
        return redirect('/'); // Redirect setelah verifikasi
    }

    public function resend()
    {
        if (auth()->user()->hasVerifiedEmail()) {
            return redirect('/');
        }

        auth()->user()->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }

}
