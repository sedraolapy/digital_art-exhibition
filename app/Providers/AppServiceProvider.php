<?php

namespace App\Providers;

use App\Models\EventOccurrence;
use App\Observers\EventOccurrenceObserver;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Illuminate\Support\Facades\Gate;
use App\Enums\Role;
use App\Enums\RoleEnum;

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

        date_default_timezone_set('Asia/Damascus');

        Gate::before(function ($user, $ability) {
            return $user->hasRole(RoleEnum::SUPER_ADMIN->value)
                ? true
                : null;
        });
    }
}
