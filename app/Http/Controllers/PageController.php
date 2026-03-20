<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about')->where('status', 'published')->first();
        return view('frontend.about', compact('page'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact')->where('status', 'published')->first();
        return view('frontend.contact', compact('page'));
    }

    public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Your message has been sent successfully! We will get back to you soon.');
    }
}
