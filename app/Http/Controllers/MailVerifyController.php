<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

class MailVerifyController extends Controller
{
    public function verify(EmailVerificationRequest $request)
    {
        // Tandai email sebagai verified
        $request->fulfill();
        // Redirect setelah verifikasi
        return redirect('/');
    }
}
