<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class empresa extends Model
{
    protected $table = 'empresa'; 
    protected $primaryKey = 'id_empresa';
    public $timestamps = false;
    public $autoincrement = false;


    public static function getId()
    {
        return (DB::table('empresa')
                ->orderBy('id_empresa', 'desc')
                ->value('id_empresa'))+1;
    }
}
