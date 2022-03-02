<?php

namespace App\Http\Controllers;

use App\Mail\ContactMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    public function show() {
        return view('contact');
    }

    public function sendEmail(Request $request) {
        // Flash old values and validate $request
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required|min:10',
            'contact' => 'required'
        ]);

        $email = new ContactMail($request);
        // Return mail
        Mail::to($request)
            ->send($email);

        // Flash success message
        session()->flash('success', 'Thank you for your message.<br>We\'ll contact you as soon as possible.');

        return redirect('contact-us');
    }
}
