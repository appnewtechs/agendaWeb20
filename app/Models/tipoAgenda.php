<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class tipoServico extends Model
{
    protected $table = 'trabalho'; 
    public $timestamps = false;
    public $autoincrement = false;

    public static function getId(){
        return (DB::table('trabalho')
                ->orderBy('id_trabalho', 'desc')->value('id_trabalho'))+1;

    }
}
