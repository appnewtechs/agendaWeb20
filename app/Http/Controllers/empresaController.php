<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Session;

class empresaController extends Controller
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

        $search = $request->get('search');
        $field  = $request->get('field')  != '' ? $request->get('field') : 'razao_social';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';
        
        $empresas = DB::table('empresa')
                    ->where('razao_social', 'like' , '%' . $search . '%')
                    ->orderBy($field, $sort)
                    ->get();
                    
        return view("cadastros.empresas.index")->with('empresas', $empresas);
    }


    public function create(Request $request)
    {
    }
  

    public function update(Request $request) 
    {
        session::put('id_modal','update');
        $validator = Validator::make($request->all(), [
                    'u_razaoSocial'    => ['required'],
                    'u_nomeFantasia'   => ['required'],
                    'u_cpfCNPJ'        => ['required'],
                    'u_codEstado'      => ['required'],
                    'u_codMunicipio'   => ['required'],
                    'u_cepEmpresa'     => ['required'],
                    'u_contatoEmpresa' => ['required'],
                    'u_numeroTelefone' => ['required'],
                    ], [], [
                    'u_razaoSocial'  => 'Razão Social',
                    'u_nomeFantasia' => 'Nome Fantasia',
                    'u_cpfCNPJ'      => 'CPF/CNPJ',
                    'u_codEstado'    => 'Estado/UF',
                    'u_codMunicipio' => 'Município',
                    'u_cepEmpresa'   => 'CEP',
                    'u_contatoEmpresa' => 'Contato',
                    'u_numeroTelefone' => 'Telefone',
                    ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                DB::table('empresas')
                ->where('codEmpresa', '=', $request->u_codEmpresa)
                ->update([
                    'razaoSocial'  => $request->u_razaoSocial,
                    'nomeFantasia' => $request->u_nomeFantasia,
                    'tipoPessoa'   => $request->u_tipoPessoa,
                    'cpfCNPJ'      => $request->u_cpfCNPJ,
                    'enderecoEmpresa' => $request->u_enderecoEmpresa,
                    'bairroEmpresa'   => $request->u_bairroEmpresa,
                    'cepEmpresa'      => $request->u_cepEmpresa,
                    'codEstado'       => $request->u_codEstado,
                    'codMunicipio'    => $request->u_codMunicipio,
                    'contatoEmpresa'  => $request->u_contatoEmpresa,
                    'numeroTelefone'  => $request->u_numeroTelefone,
                ]);

            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }
            return redirect($request->header('referer'));
        }
    }



    public function delete(Request $request)
    {
        return redirect($request->header('referer'));
    }    
    
}