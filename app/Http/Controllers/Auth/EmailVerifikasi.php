<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class EmailVerifikasi extends Controller
{
    function index()
    {

        return view('auth.verify');
    }

    function handler_verification(EmailVerificationRequest $emailVerificationRequest)
    {
        $emailVerificationRequest->fulfill();
        Alert::toast('Email berhasil diverifikasi', 'success');
        return redirect('/login')->with('success', 'Email berhasil diverifikasi');
    }

    public function resend_email(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        Alert::toast('Verifikasi berhasil dikirim', 'success');
        return redirect()->back();
    }
}
