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

}
