<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

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
        /*
            nouveau 
        */
        $cabinet = DB::table('cabinets')->first();

        View::share('nomCabinet', $cabinet->nomCabinet ?? '');
        View::share('dateOuverturePlateforme', $cabinet->created_at ?? '');
        View::share('planAbonnement', $cabinet->plan ?? '');
        View::share('logoCabinet', $cabinet->logo ?? '');

        /*
            end nouveau 
        */
    }
}
