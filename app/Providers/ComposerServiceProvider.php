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

        // Composers diversos
        view()->composer(['cadastros.perfil.index',
                          'cadastros.usuario.index',
                          'cadastros.empresas.index',
                          'cadastros.tipoServico.index',
                          'cadastros.tipoAgenda.index',
                          'cadastros.eventos.index',
                          'auth.update',
                          'home'],

                          'App\Http\Views\GeneralViewComposer@menu');
    }
}
