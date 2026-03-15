<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate; 
use Illuminate\Support\Facades\URL; // <-- Importante añadir esta línea
use App\Models\User;

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
        // 1. Definimos quién es el administrador (Tu código anterior)
        Gate::define('admin-only', function ($user) {
            return $user->role === 'admin';
        });

        // 2. Forzar HTTPS si estamos usando Ngrok
        // Esto quita los errores de "Mixed Content" en la consola
        if (str_contains(config('app.url'), 'ngrok-free.dev')) {
            URL::forceScheme('https');
        }
    }
}