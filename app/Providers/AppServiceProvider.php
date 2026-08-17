<?php

namespace App\Providers;

use App\Models\EventOccurrence;
use App\Observers\EventOccurrenceObserver;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Enums\Role;
use App\Enums\RoleEnum;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

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
        User::observe(UserObserver::class);

        Carbon::setLocale('ar');
        date_default_timezone_set('Asia/Damascus');

        Gate::before(function ($user, $ability) {
            return $user->hasRole(RoleEnum::SUPER_ADMIN->value)
                ? true
                : null;
        });

        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        RateLimiter::for('sensitive', function ($request) {
            $limit = app()->environment('local') ? 1000 : 10;
            return Limit::perMinute($limit)->by($request->user()?->id ?: $request->ip());
        });
    }
}
