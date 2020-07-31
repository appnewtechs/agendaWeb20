<?php

namespace App\Http\Controllers;
use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Validator;
use Session;

use App\Models\tipoAgenda;    
class tipoAgendaController extends Controller
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
        $field  = $request->get('field')  != '' ? $request->get('field') : 'descricao';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';

        $tiposAgenda = DB::table('trabalho')
                        ->orwhere('descricao' , 'like', '%' . $search . '%')                
                        ->orderBy($field, $sort)
                        ->get();
        return view("cadastros.tipoAgenda.index")->with('tiposAgenda', $tiposAgenda);
    }


    public function create(Request $request)
    {

        session::put('id_modal','insert');
        $validator = Validator::make($request->all(), [
                     'descricao'   => ['required'],
                     'colorpicker' => ['required'],
                     ], [], [
                     'descricao'   => 'Descrição',
                     'colorpicker' => 'Cor',
                     ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput()->with('errors', $validator->messages());
        } else {  

            try {

                $tipoAgenda = new tipoAgenda();
                $tipoAgenda->id_trabalho = tipoAgenda::getId();
                $tipoAgenda->descricao   = $request->descricao;
                $tipoAgenda->cor         = substr($request->colorpicker,1,6);
                $tipoAgenda->codigo      = tipoAgenda::getCod();
                $tipoAgenda->save();
                
            } catch (\Exception $e) {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
            }

            return redirect($request->header('referer'));
        }
    }


    public function delete(Request $request)
    {
        try {

            DB::table('trabalho')->where('id_trabalho', '=', $request->id_trabalho)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {

            if(strpos($e->getMessage(), 'Cannot delete or update a parent row')>0){
                session::put('erros', 'Não é possível excluir esse registro. - MOTIVO: Esse Tipo de Agenda já está sendo usada por outro cadastro.'); 
                return redirect($request->header('referer'));
            } else {
                session::put('erros', Config::get('app.messageError').' - ERRO: '.$e->getMessage() ); 
                return redirect($request->header('referer'))->with('errors', $e->getMessage());
            }
        }
    }    
    
}