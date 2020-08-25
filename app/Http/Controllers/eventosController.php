<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Session;
use Validator;

use App\Models\evento;    
class eventosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }



    public function index(Request $request)
    {
       return view("cadastros.eventos.index");
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make( $request->all(), evento::$incRules, [], evento::$incTranslate);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                $idEvento = evento::getId();
                if($request->i_dataSelecao==2){ 
                    $dataInicial = str_replace('/', '-', $request->i_dataSel[0]);
                    $dataFinal   = str_replace('/', '-', $request->i_dataSel[1]);
                    evento::createEvent( $idEvento, $request->i_title, $request->i_empresa, $request->i_tipo_trabalho,
                                         $dataInicial, $dataFinal, $request->i_status, $request->i_id_usuario, $request->i_dataSelecao );
                } else {

                    for ($i = 0; $i < count($request->i_dataSel); $i++) { 
                        $dataInicial = str_replace('/', '-', $request->i_dataSel[$i]);
                        $dataFinal   = str_replace('/', '-', $request->i_dataSel[$i]);
                        evento::createEvent( $idEvento, $request->i_title, $request->i_empresa, $request->i_tipo_trabalho,
                                             $dataInicial, $dataFinal, $request->i_status, $request->i_id_usuario, $request->i_dataSelecao );
                    };
                };

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }
  

    public function update(Request $request) 
    {

        log::Debug($request);
        session::put('id_modal','update');
        $validator = Validator::make($request->all(), empresa::$updRules, [], empresa::$updTranslate);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                DB::table('events')->where('id_evento', '=', $request->u_id_evento)->delete();
                $idEvento = evento::getId();


                if($request->u_dataSelecao==2){ 
                    $dataInicial = str_replace('/', '-', $request->u_dataSel[0]);
                    $dataFinal   = str_replace('/', '-', $request->u_dataSel[1]);
                    evento::createEvent( $idEvento, $request->u_title, $request->u_empresa, $request->u_tipo_trabalho,
                                         $dataInicial, $dataFinal, $request->u_status, $request->u_id_usuario, $request->u_dataSelecao );
                } else {

                    for ($i = 0; $i < count($request->u_dataSel); $i++) { 
                        $dataInicial = str_replace('/', '-', $request->u_dataSel[$i]);
                        $dataFinal   = str_replace('/', '-', $request->u_dataSel[$i]);
                        evento::createEvent( $idEvento, $request->u_title, $request->u_empresa, $request->u_tipo_trabalho,
                                             $dataInicial, $dataFinal, $request->u_status, $request->u_id_usuario, $request->u_dataSelecao );
                    };
                };

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }



    public function delete(Request $request)
    {
        try {
            DB::table('events')->where('id_evento', '=', $request->id_evento)->delete();
        } catch (\Exception $e) {
            session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
        }
        return redirect($request->header('referer'));
    }    
 
    

    public function consulta(Request $request)
    {

        if(Auth::user()->id_perfil=='1') {
            
            $search = $request->filterTitle;
            $status = $request->filterStatus;
            $usuario  = $request->filterUsuario;
            $empresa  = $request->filterEmpresa;
            $trabalho = $request->filterTrabalho;


            $events = DB::table('events')
                        ->select(
                            DB::raw("CONCAT(usuario.nome,' - ',events.title) AS title"),
                            DB::raw("CONCAT('#',trabalho.cor) AS backgroundColor"),
                            DB::raw("CONCAT('#',trabalho.cor) AS borderColor"),
                            'id_evento AS id','empresa','events.status AS status','tipo_trabalho',
                            'start', 'tipo_data', 'start AS datainicial', 'end', 'usuario.id_usuario AS usuario'
                        )
                        ->join('usuario' , 'usuario.id_usuario',   '=', 'events.id_usuario')
                        ->join('trabalho', 'trabalho.id_trabalho', '=', 'events.tipo_trabalho')
                        ->whereBetween('start', [ $request->start, $request->end ])
                        ->where(function ($query) use ($search) {
                           $query->where([
                                ['nome', 'like' , '%' . $search . '%'],
                            ])->orWhere([
                                ['title', 'like', '%' . $search . '%'],
                            ]);
                        })
                        ->where(function ($query) use ($status) {
                            if ($status!='2'){
                                $query->where('events.status', '=' , $status);
                            }
                        })
                        ->where(function ($query) use ($usuario) {
                            if (!empty($usuario)){
                                $query->whereIn('events.id_usuario' , explode(',', $usuario) );
                            }
                        })
                        ->where(function ($query) use ($empresa) {
                            if (!empty($empresa)){
                                $query->whereIn('events.empresa' , explode(',', $empresa) );
                            }
                        })
                        ->where(function ($query) use ($trabalho) {
                            if (!empty($trabalho)){
                                $query->whereIn('events.tipo_trabalho' , explode(',', $trabalho) );
                            }
                        })
                        ->get();
        } else {
            $events = DB::table('events')
                        ->select(
                            DB::raw("CONCAT('#',trabalho.cor) AS backgroundColor"),
                            DB::raw("CONCAT('#',trabalho.cor) AS borderColor"),
                            'id','title','start','end'
                        )
                        ->join('trabalho', 'trabalho.id_trabalho', '=', 'events.tipo_trabalho')
                        ->where('id_usuario', '=', Auth::user()->id_usuario)
                        ->whereBetween('start', [ $request->start, $request->end ])
                        ->get();
        }
        return response()->json($events);
    }

}