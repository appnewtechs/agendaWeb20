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
        'dataSel' => 'required|array|min:1',
        'id_usuario'    => 'required',
        'tipo_trabalho' => 'required',
    ];

    public static $translate = [
        'empresa' => 'Empresa',
        'dataSel' => 'Data',
        'title'   => 'Título/Descrição',
        'id_usuario'    => 'Usuário',
        'tipo_trabalho' => 'Tipo de Agenda',
    ];


    public static function gerarAgendas(request $request){

        if($request->dataSelecao=='2'){ 

            if (count($request->dataSel)>1){

                $dataInicial = Carbon::parse(str_replace('/', '-', $request->dataSel[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $request->dataSel[1]))->endOfDay();

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
                        evento::createEvent( $idEvento, $request->title, $request->empresa, $request->tipo_trabalho,
                                            $dataInicial, $dataFimEvento, $request->status, $request->id_usuario, $request->dataSelecao );
                        
                        if ($dataControle==$dataFinal){
                            break;
                        }

                        $dataInicial = Carbon::parse($dataFimEvento);
                        $dataInicial->addDay(3)->startOfDay();
                        $dataControle->addDay(2);
                    }; 

                };

            } else {

                $dataInicial = Carbon::parse(str_replace('/', '-', $request->dataSel[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $request->dataSel[0]))->endOfDay();

                $idEvento = evento::getId();
                evento::createEvent( $idEvento, $request->title, $request->empresa, $request->tipo_trabalho,
                                     $dataInicial, $dataFinal, $request->status, $request->id_usuario, $request->dataSelecao );
            };

        } else {

            $idEvento = evento::getId();
            if (count($request->dataSel)>1){
                
                for ($i = 0; $i < count($request->dataSel); $i++) { 
                    $dataInicial = Carbon::parse( str_replace('/', '-', $request->dataSel[$i]) );
                    $dataFinal   = Carbon::parse( str_replace('/', '-', $request->dataSel[$i]) );
                    evento::createEvent( $idEvento, $request->title, $request->empresa, $request->tipo_trabalho,
                                         $dataInicial, $dataFinal, $request->status, $request->id_usuario, $request->dataSelecao );
                };

            } else {
                $dataInicial = Carbon::parse(str_replace('/', '-', $request->dataSel[0]));
                $dataFinal   = Carbon::parse(str_replace('/', '-', $request->dataSel[0]))->endOfDay();
                evento::createEvent( $idEvento, $request->title, $request->empresa, $request->tipo_trabalho,
                                     $dataInicial, $dataFinal, $request->status, $request->id_usuario, $request->dataSelecao );
            }
        };

    }


    public static function createEvent($idEvento, $title, $empresa, $trabalho, $dtIni, $dtFim, $status, $usuario, $tipoData){

        $empresas = new evento();
        $empresas->id_evento     = $idEvento;
        $empresas->title         = $title;
        $empresas->empresa       = $empresa;
        $empresas->tipo_trabalho = $trabalho;
        $empresas->status        = $status;
        $empresas->id_usuario    = $usuario;
        $empresas->tipo_data     = $tipoData;
        $empresas->start         = $dtIni;
        $empresas->end           = $dtFim;
        $empresas->id_creator    = Auth::user()->id_usuario;
        $empresas->save();
    }
}
