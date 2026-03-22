<?php
namespace App\Observers;

use App\Models\Publication;
use Illuminate\Support\Facades\Http;

class PublicationObserver
{
    public function saved(Publication $publication): void
    {
        if ($publication->is_published) {
            $this->pingGoogle();
        }
    }

    private function pingGoogle(): void
    {
        $sitemapUrl = config('app.url') . '/sitemap.xml';
        Http::get("https://www.google.com/ping?sitemap={$sitemapUrl}");
    }
}
