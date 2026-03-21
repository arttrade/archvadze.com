<?php
namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate(['email' => 'required|email|max:255']);

        NewsletterSubscriber::updateOrCreate(
            ['email' => $request->email],
            ['status' => 'active']
        );

        return back()->with('newsletter_success', 'Thank you for subscribing!');
    }
}
