<?php

namespace App\Http\Views;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GeneralViewComposer
{

    private $request;
    public function __construct(Request $request)
    {
       $this->request = $request;
    }

    
    public function menu($view) 
    {
        $rotinas = DB::table('usuario')
                    ->select('perfil_rotina.id_rotina', 'rotina.nome')
                    ->join('usuario_perfil','usuario_perfil.id_usuario', '=', 'usuario.id_usuario')
                    ->join('perfil_rotina' ,'perfil_rotina.id_perfil'  , '=', 'usuario_perfil.id_perfil')
                    ->join('rotina'       ,'rotina.id_rotina'          , '=', 'perfil_rotina.id_rotina')
                    ->where('usuario.id_usuario', '=', Auth::user()->id_usuario)
                    ->groupby('perfil_rotina.id_rotina', 'rotina.nome')
                    ->get();

        return $view->with('rotinas', $rotinas);
    }
}
