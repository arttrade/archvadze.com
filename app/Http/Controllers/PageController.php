<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::where('slug', 'about')->first();
        return view('about', compact('page'));
    }

    public function contact()
    {
        $page = Page::where('slug', 'contact')->first();
        return view('contact', compact('page'));
    }
}