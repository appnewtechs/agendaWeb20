<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class evento extends Model
{
    protected $table = 'events'; 
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('events')
                ->orderBy('id_evento', 'desc')->value('id'))+1;

    }


    public static $incRules = [
        'i_title'   => 'required',
        'i_empresa' => 'required',
        'i_dataSel' => 'required|array|min:2',
        'i_id_usuario'    => 'required',
        'i_tipo_trabalho' => 'required',
    ];

    public static $incTranslate = [
        'i_empresa' => 'Empresa',
        'i_dataSel' => 'Data',
        'i_title'   => 'Título/Descrição',
        'i_id_usuario'    => 'Usuário',
        'i_tipo_trabalho' => 'Tipo de Agenda',
    ];


    public static $updRules = [
        'u_title'   => 'required',
        'u_empresa' => 'required',
        'u_dataSel' => 'required|array|min:2',
        'u_id_usuario'    => 'required',
        'u_tipo_trabalho' => 'required',
    ];

    public static $updTranslate = [
        'u_empresa' => 'Empresa',
        'u_dataSel' => 'Data',
        'u_title'   => 'Título/Descrição',
        'u_id_usuario'    => 'Usuário',
        'u_tipo_trabalho' => 'Tipo de Agenda',
    ];



    public static function createEvent($idEvento, $title, $empresa, $trabalho, $dataInicial, $dataFinal, $status, $usuario, $tipoData){

        $empresas = new evento();
        $empresas->id_evento     = $idEvento;
        $empresas->title         = $title;
        $empresas->empresa       = $empresa;
        $empresas->tipo_trabalho = $trabalho;
        $empresas->status        = $status;
        $empresas->id_usuario    = $usuario;
        $empresas->tipo_data     = $tipoData;
        $empresas->id_creator    = Auth::user()->id_usuario;
        $empresas->start         = Carbon::parse($dataInicial);
        $empresas->end           = Carbon::parse($dataFinal)->endOfDay();
        $empresas->save();
    }
}
