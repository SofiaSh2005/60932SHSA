<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        Paginator::defaultView('pagination::default');

        Gate::define('create-usluga', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('delete-seans', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('delete-klient', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('update-klient', function (User $user) {
            return $user->isAdmin();
        });

        Gate::define('edit-expensive-seans', function ($user, $seans) {

            $uslugi = $seans->usluga;

            if ($uslugi->isEmpty()) {
                return false;
            }

            return $uslugi->contains(function ($usluga) {
                return (float)$usluga->stoimost > 1000;
            });
        });
    }
}
