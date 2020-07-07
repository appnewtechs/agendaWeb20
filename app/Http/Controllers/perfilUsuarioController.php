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

use App\Models\perfil;    
class perfilUsuarioController extends Controller
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
        $field  = $request->get('field')  != '' ? $request->get('field') : 'nome';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';

 
        $perfil  = DB::table('perfil')
                   ->where('nome', 'like', '%' . $search . '%')
                   ->orwhere('descricao' , 'like', '%' . $search . '%')                
                   ->orderBy($field, $sort)
                   ->get();

        $testes = DB::table('rotina')->orderBy('id_rotina', 'asc')->get();
        return view("cadastros.perfil.index")->with('perfil', $perfil)
                                             ->with('testes', $testes);
    }


    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'nome'     => ['required'],
            'descricao'=> ['required'],
            ], [], [
                'nome'      => 'Nome',
                'descricao' => 'Descrição',
            ]);


        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            $perfil = new perfil();
            $perfil->id_perfil = perfil::getId();
            $perfil->nome      = $request->nome;
            $perfil->descricao = $request->descricao;
            $perfil->save();
            return redirect($request->header('referer'));
        }        
    }
  


    public function delete(Request $request)
    {
        try {

            DB::table('perfil')->where('id_perfil', '=', $request->id_perfil)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {
            log::Debug($e);
            return redirect($request->header('referer'))->with('errors', $e->getMessage());
        }
    }    
    
}