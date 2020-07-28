<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Validator;
use Session;

use App\Models\usuario;    
use App\Models\usuarioEmpresa;
class usuarioController extends Controller
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

        
        // Ajuste perfil.
        /*
        $usuarios  = DB::table('usuario')->get();
        foreach ($usuarios as $usuario) {

            $perfil = DB::table('usuario_perfil')->where('id_usuario', '=', $usuario->id_usuario)->first();

            if ($perfil){
                DB::table('usuario')
                ->where('id_usuario', '=', $usuario->id_usuario)
                ->update([
                    'id_perfil' => $perfil->id_perfil,
                ]);
            }
        }
        */


        $search = $request->get('search');
        $field  = $request->get('field')  != '' ? $request->get('field') : 'nome';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';
        $status = $request->get('status') != '' ? $request->get('status'): '0';
        
        $usuarios  = DB::table('usuario')
                   ->select('usuario.*', 'empresa.razao_social', 'linha_produto.descricao')
                   ->join('empresa', 'usuario.id_empresa','=', 'empresa.id_empresa')
                   ->join('linha_produto', 'usuario.id_linha_produto','=', 'linha_produto.id_linha_produto')
                   ->where(function ($query) use ($search) {
                    $query->where([
                            ['nome', 'like' , '%' . $search . '%'],
                        ])->orWhere([
                            ['usuario.email', 'like', '%' . $search . '%'],
                        ])->orWhere([
                            ['linha_produto.descricao', 'like', '%' . $search . '%'],
                        ]);
                    })->where(function ($query) use ($status) {
                        if ($status!='2'){
                            $query->where('status', '=' , $status);
                        }
                    })
                   ->orderBy($field, $sort)
                   ->get();
        

        $empresas         = DB::table('empresa')->orderBy('razao_social','asc')->get();
        $empresasUsuario  = DB::table('empresa')->orderBy('razao_social','asc')->get();
        $perfisCombo      = DB::table('perfil')->orderBy('id_perfil','asc')->pluck('nome','id_perfil');
        $empresasCombo    = DB::table('empresa')->orderBy('razao_social','asc')->pluck('razao_social','id_empresa');
        $tipoServicoCombo = DB::table('linha_produto')->orderBy('descricao','asc')->pluck('descricao','id_linha_produto');


        return view("cadastros.usuario.index")->with('usuarios', $usuarios)
                                              ->with('empresas', $empresas)
                                              ->with('perfisCombo',   $perfisCombo)
                                              ->with('empresasCombo', $empresasCombo)
                                              ->with('tipoServicoCombo', $tipoServicoCombo);
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make( $request->all(), usuario::$incRules, [], usuario::$incTranslate);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {
                $usuario = new usuario();
                $usuario->id_usuario = usuario::getId();
                $usuario->nome   = $request->i_nome;
                $usuario->email  = $request->i_email;
                $usuario->login  = $request->i_login;
                $usuario->senha  = Hash::make("123456");
                $usuario->status = $request->i_status;
                $usuario->telefone  = $request->i_telefone;
                $usuario->id_empresa= $request->i_id_empresa;
                $usuario->id_perfil = $request->i_id_perfil;
                $usuario->id_linha_produto = $request->i_id_linha_produto;
                $usuario->especialidade    = $request->i_especialidade;
                $usuario->data_nascimento  = $request->i_data_nascimento;
                $usuario->imagem = "";
                $usuario->save();

                for ($i = 0; $i < count($request->i_arr_empresa); $i++) { 
                    if($request->i_arr_email[$i]){
                        $empresa = new usuarioEmpresa();
                        $empresa->id_usuario = $usuario;
                        $empresa->id_empresa = $request->i_arr_empresa[$i];
                        $empresa->email      = $request->i_arr_email[$i];
                        $empresa->save();
                    }
                }

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect($request->header('referer'));
        }
    }

    

    public function update(Request $request)
    {
    
        session::put('id_modal','update');
        $validator = Validator::make( $request->all(), usuario::$updRules, [], usuario::$updTranslate);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {
                DB::table('usuario')
                ->where('id_usuario', '=', $request->u_id_usuario)
                ->update([
                    'nome'   => $request->u_nome,
                    'email'  => $request->u_email,
                    'login'  => $request->u_login,
                    'status' => $request->u_status,
                    'telefone'  => $request->u_telefone,
                    'id_empresa'=> $request->u_id_empresa,
                    'id_perfil' => $request->u_id_perfil,
                    'id_linha_produto' => $request->u_id_linha_produto,
                    'especialidade'    => $request->u_especialidade,
                    'data_nascimento'  => $request->u_data_nascimento,
                ]);


                for ($i = 0; $i < count($request->u_arr_empresa); $i++) { 
                    if($request->u_arr_empresa[$i]){

                        $mail = DB::table('usuario_empresa')->where([
                                ['id_usuario', '=', $request->u_id_usuario],
                                ['id_empresa', '=', $request->u_arr_empresa[$i]],
                                ])->first();

                        if (empty($mail)){
                            $empresa = new usuarioEmpresa();
                            $empresa->id_usuario = $request->u_id_usuario;
                            $empresa->id_empresa = $request->u_arr_empresa[$i];
                            $empresa->email      = $request->u_arr_email[$i];
                            $empresa->save();
                        } else {

                            DB::table('usuario_empresa')->where([
                                ['id_usuario', '=', $request->u_id_usuario],
                                ['id_empresa', '=', $request->u_arr_empresa[$i]],
                            ])->update([
                                'email' => $request->u_arr_email[$i],
                            ]);
                        }
                    }
                }

             } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect($request->header('referer'));
        }
    }



    public function delete(Request $request)
    {
        try {
            DB::table('usuario_empresa')->where('id_usuario', '=', $request->id_usuario)->delete();
            DB::table('usuario')->where('id_usuario', '=', $request->id_usuario)->delete();
            return redirect($request->header('referer'));
        } catch (\Exception $e) {

            if(strpos($e->getMessage(), 'Cannot delete or update a parent row')>0){
                session::put('erros', 'Não é possível excluir esse registro. - MOTIVO: Esse Usuário já está sendo usada por outro cadastro'); 
                return redirect($request->header('referer'));
            } else {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
                return redirect($request->header('referer'))->with('errors', $e->getMessage());
            }
        }
    }    
    


    public function empresas($usuario){

        return  DB::table('empresa')
                ->select('empresa.id_empresa','empresa.razao_social','usuario_empresa.email')
                ->leftJoin('usuario_empresa' , function($join) use ($usuario) {
                    $join->on('usuario_empresa.id_empresa', '=', 'empresa.id_empresa')
                        ->where('usuario_empresa.id_usuario', '=', $usuario);
                    }
                )
                ->orderBy('empresa.razao_social', 'asc')->get();
    }



    public function updateUser(Request $request){

        $validator = Validator::make( $request->all(), usuario::$updUserRules, [], usuario::$updUserTranslate);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {
                DB::table('usuario')
                ->where('id_usuario', '=', Auth::user()->id_usuario)
                ->update([
                    'nome'     => $request->nome,
                    'email'    => $request->email,
                    'login'    => $request->login,
                    'telefone' => $request->telefone,
                    'senha'    => Hash::make($request->senha),
                ]);

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect('/');
        }
    }
}