<?php

namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Service;
use App\Models\PortfolioProject;
use App\Models\Testimonial;
use App\Models\Page;
use App\Models\Feature;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featuredServices = Service::where('status', true)->take(6)->get();
        $featuredProjects = PortfolioProject::with('images')->where('is_featured', true)->take(6)->get();
        $latestPublications = Publication::with('author')->where('is_published', true)->orderBy('published_at', 'desc')->take(3)->get();
        $testimonials = Testimonial::where('is_featured', true)->take(3)->get();
        $homePage = Page::where('slug', 'home')->first();
        $features = Feature::all();

        return view('home', compact('featuredServices', 'featuredProjects', 'latestPublications', 'testimonials', 'homePage', 'features'));
    }
}