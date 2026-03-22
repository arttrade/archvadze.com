<?php
namespace App\Http\Controllers;

use App\Models\Publication;
use App\Models\Guide;
use App\Models\PortfolioProject;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $publications = Publication::where('is_published', true)
            ->orderBy('updated_at', 'desc')->get();

        $guides = Guide::whereNotNull('published_at')
            ->orderBy('updated_at', 'desc')->get();

        $portfolios = PortfolioProject::where('is_published', true)->get();

        return response()->view('sitemap', compact('publications', 'guides', 'portfolios'))
            ->header('Content-Type', 'text/xml');
    }
}
