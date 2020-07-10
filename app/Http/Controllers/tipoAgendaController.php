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
        $tipoAgenda = new tipoAgenda();
        $tipoAgenda->id_trabalho = tipoAgenda::getId();
        $tipoAgenda->descricao   = $request->descricao;
        $tipoAgenda->save();
        return redirect($request->header('referer'));
    }
  


    public function delete(Request $request)
    {
        try {

            DB::table('trabalho')->where('id_trabalho', '=', $request->id_trabalho)->delete();
            return redirect($request->header('referer'));

        } catch (\Exception $e) {
            return redirect($request->header('referer'))->with('errors', $e->getMessage());
        }
    }    
    
}