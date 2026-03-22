<?php
namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Order;
use App\Observers\OrderObserver;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Password default rules — მინიმუმ 8 სიმბოლო, ერთი დიდი, ერთი პატარა, ერთი ციფრი
        Order::observe(OrderObserver::class);

        Password::defaults(function () {
            return Password::min(8)
                ->mixedCase()
                ->numbers();
        });

        View::composer('*', function ($view) {
            $view->with('siteSettings', SiteSetting::pluck('value', 'key')->toArray());
            $view->with('headerMenuItems', \App\Models\MenuItem::getByLocation('header'));
            $view->with('footerMenuItems', \App\Models\MenuItem::getByLocation('footer'));
            $view->with('bottomMenuItems', \App\Models\MenuItem::getByLocation('bottom'));
        });
    }
}
