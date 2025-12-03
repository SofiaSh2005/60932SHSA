<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;

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
        Paginator::defaultView('pagination::default');

        // удалять может только админ
        Gate::define('delete-seans', function ($user, $seans) {
            return $user->is_admin == 1;
        });



        // редактировать можно только если цена > 1000
        Gate::define('edit-expensive-seans', function ($user,$seans) {

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
