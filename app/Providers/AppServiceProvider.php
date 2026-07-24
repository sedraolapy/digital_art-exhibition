<?php

namespace App\Providers;

use App\Models\EventOccurrence;
use App\Observers\EventOccurrenceObserver;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        EventOccurrence::observe(EventOccurrenceObserver::class);
        Carbon::setLocale('ar');
        date_default_timezone_set('Asia/Damascus');
    }
}
