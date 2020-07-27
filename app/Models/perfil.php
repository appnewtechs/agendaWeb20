<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class perfil extends Model
{
    protected $table = 'perfil'; 
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('perfil')
                ->orderBy('id_perfil', 'desc')->value('id_perfil'))+1;

    }


    public static $incRules = [
        'i_nome'  => ['required'],
        'i_login' => ['required'],
        'i_email' => ['required'],
        'i_telefone'  => ['required'],
        'i_id_perfil' => ['required'],
        'i_id_empresa'=> ['required'],
        'i_id_linha_produto' => ['required'],
    ];

    public static $incTranslate = [
        'i_nome'     => 'Nome',
        'i_login'    => 'Login',
        'i_email'    => 'E-mail',
        'i_telefone' => 'Telefone',
        'i_id_perfil' => 'Perfil',
        'i_id_empresa'=>'Empresa',
        'i_id_linha_produto' => 'Tipo de Serviço',
    ];

}
