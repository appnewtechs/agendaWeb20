<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Usuario extends Authenticatable
{
    use Notifiable;
    protected $table = 'usuario';
    protected $primaryKey = 'id_usuario';
    protected $rememberTokenName = false;

    public $timestamps = false;
    public $autoincrement = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_usuario', 'login', 'email', 'senha', 'nome',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'senha',
    ];


    public function getAuthPassword(){  
        return $this->senha;
    }
    

    public static function getId(){
        return (DB::table('usuario')
                ->orderBy('id_usuario', 'desc')->value('id_usuario'))+1;

    }



    public static $incRules = [
        'i_nome'  => 'required',
        'i_login' => 'required|unique:usuario,login',
        'i_email' => 'required|email|unique:usuario,email',
        'i_telefone'  => 'required',
        'i_id_perfil' => 'required',
        'i_id_empresa'=> 'required',
        'i_id_linha_produto' => 'required',
    ];

    public static $incTranslate = [
        'i_nome'     => 'Nome',
        'i_login'    => 'Login',
        'i_email'    => 'E-mail',
        'i_telefone' => 'Telefone',
        'i_id_perfil' => 'Perfil',
        'i_id_empresa'=>'Empresa',
        'i_id_linha_produto' => 'Linha de Atuação',
    ];


    public static $updRules = [
        'u_nome'  => 'required',
        'u_login' => 'required',
        'u_email' => 'required',
        'u_telefone'  => 'required',
        'u_id_perfil' => 'required',
        'u_id_empresa'=> 'required',
        'u_id_linha_produto' => 'required',
    ];
    public static $updTranslate = [
        'u_nome'     => 'Nome',
        'u_login'    => 'Login',
        'u_email'    => 'E-mail',
        'u_telefone' => 'Telefone',
        'u_id_perfil' => 'Perfil',
        'u_id_empresa'=>'Empresa',
        'u_id_linha_produto' => 'Linha de Atuação',
    ];


    public static $updUserRules = [
        'nome'  => 'required',
        'telefone' => 'required',
        'senha'    => 'required', 
        'senhaConfirm' => 'required|same:senha' 
    ];
    public static $updUserTranslate = [
        'nome'     => 'Nome',
        'telefone' => 'Telefone',
        'senha'    => 'Senha',
        'senhaConfirm' => 'Confirmação de Senha',
    ];

}
