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
        $validator = Validator::make( $request->all(), 
        [
            'i_title'      => 'required',
            'i_id_usuario' => 'required',
            'i_empresa'    => 'required',
            'i_start'      => 'required',
            'i_end'        => 'required',
            'i_tipo_trabalho' => 'required',
        ], [], evento::$incTranslate);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                $empresas = new evento();
                $empresas->title         = $request->i_title;
                $empresas->empresa       = $request->i_empresa;
                $empresas->tipo_trabalho = $request->i_tipo_trabalho;
                $empresas->start         = $request->i_start;
                $empresas->end           = Carbon::parse($request->i_end)->endOfDay();
                $empresas->status        = $request->i_status;
                $empresas->id_usuario    = $request->i_id_usuario;
                $empresas->id_creator    = Auth::user()->id_usuario;
                $empresas->save();

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }
  

    public function update(Request $request) 
    {
        session::put('id_modal','update');
        $validator = Validator::make($request->all(), empresa::$updRules, [], empresa::$updTranslate);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                DB::table('empresa')
                ->where('id_empresa', '=', $request->u_id_empresa)
                ->update([
                    'razao_social'  => $request->u_razao_social,
                    'nome_fantasia' => $request->u_nome_fantasia,
                    'tipo_pessoa'   => $request->u_tipo_pessoa,
                    'cpf_cnpj'      => $request->u_cpf_cnpj,
                    'endereco'      => $request->u_endereco,
                    'complemento'   => $request->u_bairro,
                    'cep'           => $request->u_cep,
                    'estado'        => $request->u_estado,
                    'municipio'     => $request->u_municipio,
                    'telefone_fixo'    => $request->u_telefone_fixo,
                    'telefone_celular' => $request->u_telefone_celular,
                ]);

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }



    public function delete(Request $request)
    {
        try {
            DB::table('events')->where('id', '=', $request->id_evento)->delete();
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
                            'id','empresa','events.status AS status','tipo_trabalho',
                            'start', 'start AS datainicial', 'end', 'usuario.id_usuario AS usuario'
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