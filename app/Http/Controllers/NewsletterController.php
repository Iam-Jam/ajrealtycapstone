<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ]);

        // Add logic to save the email to your newsletter subscribers list
        // This could be a database insertion or an API call to your email service

        return back()->with('success', 'Thank you for subscribing to our newsletter!');
    }
}
