<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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


    public static $rules = [
        'title'   => 'required',
        'empresa' => 'required',
        'datas'   => 'required',
        'id_usuario'    => 'required',
        'tipo_trabalho' => 'required',
    ];

    public static $translate = [
        'empresa' => 'Empresa',
        'datas'   => 'Datas',
        'title'   => 'Título/Descrição',
        'id_usuario'    => 'Usuário',
        'tipo_trabalho' => 'Tipo de Agenda',
    ];


    public static function gerarAgendas(request $request)
    {

        $arrDatas = explode(',', trim($request->datas));
        
        if($request->dataSelecao=='2'){ 

            if (count($arrDatas)>1){

                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[1]))->endOfDay();

                if ($dataInicial->isSaturday()) {
                    $dataInicial->addDay(2);
                } elseif ($dataInicial->isSunday()){
                    $dataInicial->addDay();
                };

                if ($dataFinal->isSaturday()) {
                    $dataFinal->subDay();
                } elseif ($dataFinal->isSunday()){
                    $dataFinal->subDay(2);
                };


                $dataControle = Carbon::parse($dataInicial);
                $totalDias    = ($dataInicial->diffInDays($dataFinal));

                for($i=1; $i<=$totalDias; $i++) {

                    $dataControle->addDay()->endOfDay();
                    if ($dataControle->isSaturday() || $dataControle==$dataFinal) {

                        $dataFimEvento = $dataControle->isSaturday() ? $dataControle->subDay() : $dataFinal; 
                        
                        $idEvento = evento::getId();
                        evento::createEvent( $idEvento, $dataInicial, $dataFimEvento, $request);
                        
                        if ($dataControle==$dataFinal){
                            break;
                        }

                        $dataInicial = Carbon::parse($dataFimEvento);
                        $dataInicial->addDay(3)->startOfDay();
                        $dataControle->addDay(2);
                    }; 

                };

            } else {

                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[0]))->endOfDay();

                $idEvento = evento::getId();
                evento::createEvent( $idEvento, $dataInicial, $dataFinal, $request );
            };

        } else {

            $idEvento = evento::getId();
            if (count($arrDatas)>1){
                
                for ($i = 0; $i < count($arrDatas); $i++) { 
                    $dataInicial = Carbon::parse( str_replace('/', '-', $arrDatas[$i]) );
                    $dataFinal   = Carbon::parse( str_replace('/', '-', $arrDatas[$i]) );
                    evento::createEvent( $idEvento, $dataInicial, $dataFinal, $request );
                };

            } else {
                $dataInicial = Carbon::parse(str_replace('/', '-', $arrDatas[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $arrDatas[0]))->endOfDay();
                evento::createEvent( $idEvento, $dataInicial, $dataFinal, $request );
            }
        };
        
    }


    public static function createEvent($idEvento, $dtIni, $dtFim, $request){

        $empresas = new evento();
        $empresas->id_evento     = $idEvento;
        $empresas->title         = $request->title;
        $empresas->empresa       = $request->empresa;
        $empresas->tipo_trabalho = $request->tipo_trabalho;
        $empresas->status        = $request->status;
        $empresas->id_usuario    = $request->id_usuario;
        $empresas->tipo_data     = $request->dataSelecao;
        $empresas->id_creator    = Auth::user()->id_usuario;
        $empresas->start         = $dtIni;
        $empresas->end           = $dtFim;
        $empresas->save();
    }
}
