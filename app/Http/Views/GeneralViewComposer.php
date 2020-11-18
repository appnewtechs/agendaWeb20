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
                    ->join('perfil_rotina' ,'perfil_rotina.id_perfil'  , '=', 'usuario.id_perfil')
                    ->join('rotina'       ,'rotina.id_rotina'          , '=', 'perfil_rotina.id_rotina')
                    ->where('usuario.id_usuario', '=', Auth::user()->id_usuario)
                    ->groupby('perfil_rotina.id_rotina', 'rotina.nome')
                    ->get();

        return $view->with('rotinas', $rotinas);
    }

    public function empresas($view) 
    {
        $empresasCombo = DB::table('empresa')->orderBy('razao_social','asc')->pluck('razao_social','id_empresa');
        return $view->with('empresasCombo', $empresasCombo);
    }


    public function usuarios($view) 
    {
        $usuariosCombo = DB::table('usuario')
                        ->where([['status'    , '=' , '0'],
                                 ['id_usuario', '<>', '1']])
                        ->orderBy('nome','asc')->pluck('nome','id_usuario');
        return $view->with('usuariosCombo', $usuariosCombo);
    }


    public function tiposServico($view) 
    {
        $tipoServicoCombo = DB::table('linha_produto')->orderBy('descricao','asc')->pluck('descricao','id_linha_produto');
        return $view->with('tipoServicoCombo', $tipoServicoCombo);
    }


    public function tiposAgenda($view) 
    {
        $tipoAgendaCombo = DB::table('trabalho')->orderBy('descricao','asc')->pluck('descricao','id_trabalho');
        return $view->with('tipoAgendaCombo', $tipoAgendaCombo);
    }


    public function feriados($view) 
    {
        $feriados = DB::table('feriados')->get();
        return $view->with('feriados', $feriados);
    }

}
