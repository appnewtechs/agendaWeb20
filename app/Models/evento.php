<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

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
        'i_title'      => 'required',
        'i_id_usuario' => 'required',
        'i_empresa'    => 'required',
        'i_tipo_trabalho' => 'required',
    ];

    public static $incTranslate = [
        'i_title'         => 'Título/Descrição',
        'i_id_usuario'    => 'Usuário',
        'i_empresa'       => 'Empresa',
        'i_tipo_trabalho' => 'Tipo de Agenda',
    ];


    public static $updRules = [
        'u_nome'      => ['required'],
        'u_descricao' => ['required'],
    ];

    public static $updTranslate = [
        'u_nome'      => 'Nome',
        'u_descricao' => 'Descrição',
    ];

}
