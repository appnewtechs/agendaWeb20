<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
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

        $validator = Validator::make( $request->all(), evento::$rules, [], evento::$translate);
        if ($validator->fails()) {
            return response()->json(['code'=>'401', 'erros'=>$validator->messages()]);
        } else {  

            try {
                evento::gerarAgendas($request);
            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return response()->json(['code'=>'200']);
        }
    }
  

    public function update(Request $request) 
    {

        $validator = Validator::make( $request->all(), evento::$rules, [], evento::$translate);
        if ($validator->fails()) {
            return response()->json($validator->messages() );
        } else {  

            try {

                DB::table('events')->where('id_evento', '=', $request->id_evento)->delete();
                evento::gerarAgendas($request);

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
 
    
    public function carregaDatas($idEvento)
    {
        $datas = DB::table('events')
                ->where('id_evento', '=', $idEvento)
                ->get();
        return response()->json($datas);
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
                            'id_evento AS id','empresa','events.status AS status','tipo_trabalho', 'start', 'end',  
                            'tipo_data', 'events.title AS descricao', 'start AS datainicial', 'usuario.id_usuario AS usuario',
                            'trabalho.descricao AS descTrabalho'
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
                        return response()->json($events);

        } else {

            $events = DB::table('events')
                        ->select(
                            DB::raw("CONCAT(usuario.nome,' - ',events.title) AS title"),
                            DB::raw("CONCAT('#',trabalho.cor) AS backgroundColor"),
                            DB::raw("CONCAT('#',trabalho.cor) AS borderColor"),
                            'id_evento AS id','empresa','events.status AS status','tipo_trabalho', 'start', 'end',  
                            'tipo_data', 'events.title AS descricao', 'start AS datainicial', 'usuario.id_usuario AS usuario',
                            'trabalho.descricao AS descTrabalho'
                        )
                        ->join('usuario' , 'usuario.id_usuario',   '=', 'events.id_usuario')
                        ->join('trabalho', 'trabalho.id_trabalho', '=', 'events.tipo_trabalho')
                        ->where('events.id_usuario', '=', Auth::user()->id_usuario)
                        ->whereBetween('start', [ $request->start, $request->end ])
                        ->get();
            return response()->json($events);
        }

    }

    public function relatorio(Request $request)
    {

        $search   = $request->search;
        $status   = $request->filterStatus;
        $empresa  = $request->checkEmpresas ?? '';
        $usuario  = $request->checkUsuarios ?? '';
        $trabalho = $request->checkTrabalhos ?? '';

        $dates = [];
        $dtDe  = Carbon::parse($request->data_rel_ini);
        $dtAte = Carbon::parse($request->data_rel_fin);

        for($d = $dtDe; $d->lte($dtAte); $d->addDay()) {
            $dates[]  = $d->format('Y-m-d');
        }                    


        $feriados = DB::table('feriados')
                    ->whereBetween('data', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                    ->get();

        $usuarios = DB::table('events')
                    ->select('events.id_usuario', 'usuario.nome', 'linha_produto.descricao AS atuacao')
                    ->join('usuario' , 'usuario.id_usuario',   '=', 'events.id_usuario')
                    ->join('linha_produto', 'linha_produto.id_linha_produto', '=', 'usuario.id_linha_produto')
                    ->whereBetween('start', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                    ->where(function ($query) use ($search) {
                        $query->where([
                             ['usuario.nome', 'like' , '%' . $search . '%'],
                         ])->orWhere([
                             ['events.title', 'like', '%' . $search . '%'],
                         ]);
                    })
                    ->where(function ($query) use ($status) {
                         if ($status!='2'){
                             $query->where('events.status', '=' , $status);
                         }
                    })
                    ->where(function ($query) use ($empresa) {
                        if (!empty($empresa)){
                            $query->whereIn('events.empresa', $empresa );
                        }
                    })
                    ->where(function ($query) use ($usuario) {
                        if (!empty($usuario)){
                            $query->whereIn('events.id_usuario', $usuario );
                        }
                    })
                    ->where(function ($query) use ($trabalho) {
                        if (!empty($trabalho)){
                            $query->whereIn('events.tipo_trabalho', $trabalho );
                        }
                    })

                    ->groupBy('events.id_usuario','nome', 'atuacao')
                    ->orderBy('atuacao')
                    ->get();


        $events = DB::table('events')
                    ->select('events.*','nome', DB::raw("CONCAT('#',trabalho.cor) AS backgroundColor") )
                    ->join('usuario' , 'usuario.id_usuario',   '=', 'events.id_usuario')
                    ->join('trabalho', 'trabalho.id_trabalho', '=', 'events.tipo_trabalho')
                    ->whereBetween('start', [ Carbon::parse($request->data_rel_ini), Carbon::parse($request->data_rel_fin) ])
                    ->where(function ($query) use ($search) {
                        $query->where([
                             ['usuario.nome', 'like' , '%' . $search . '%'],
                         ])->orWhere([
                             ['events.title', 'like', '%' . $search . '%'],
                         ]);
                    })
                    ->where(function ($query) use ($status) {
                         if ($status!='2'){
                             $query->where('events.status', '=' , $status);
                         }
                    })
                    ->where(function ($query) use ($empresa) {
                        if (!empty($empresa)){
                            $query->whereIn('events.empresa', $empresa);
                        }
                    })
                    ->where(function ($query) use ($usuario) {
                        if (!empty($usuario)){
                            $query->whereIn('events.id_usuario', $usuario );
                        }
                    })
                    ->where(function ($query) use ($trabalho) {
                        if (!empty($trabalho)){
                            $query->whereIn('events.tipo_trabalho', $trabalho );
                        }
                    })
                    ->orderBy('usuario.nome')
                    ->get();


        
        return view("cadastros.eventos.relatorio")->with('dates', $dates)
                                                  ->with('events', $events)
                                                  ->with('feriados', $feriados)
                                                  ->with('usuarios', $usuarios);
    }
}