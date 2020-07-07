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
  


    public function delete(Request $request)
    {
        return redirect($request->header('referer'));
    }    
    
}