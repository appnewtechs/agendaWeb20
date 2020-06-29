<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        // Composers para view de alimentação de Combos 

        // Composers diversos
        view()->composer(['cadastros.perfil.index',
                          'cadastros.usuario.index',
                          'home'],
                          'App\Http\Views\GeneralViewComposer@menu');
    }
}
