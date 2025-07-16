<?php

namespace App\Providers;

use App\Auth\ParticipanteAuthProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\Participante;
use App\Observers\ParticipanteObserver;
use Illuminate\Support\ServiceProvider;

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
        Participante::observe(ParticipanteObserver::class);

        Auth::provider('participante_custom', function ($app, array $config) {
            return new ParticipanteAuthProvider();
        });
        
    }
}
