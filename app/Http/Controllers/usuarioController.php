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

use App\Models\usuario;    
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

        $search = $request->get('search');
        $field  = $request->get('field')  != '' ? $request->get('field') : 'nome';
        $sort   = $request->get('sort')   != '' ? $request->get('sort')  : 'asc';
        $status = $request->get('status') != '' ? $request->get('status'): '0';
        
        $usuarios  = DB::table('usuario')
                   ->select('usuario.*', 'empresa.razao_social') 
                   ->join('empresa', 'usuario.id_empresa','=', 'empresa.id_empresa')
                   ->where(function ($query) use ($search) {
                    $query->where([
                            ['nome', 'like' , '%' . $search . '%'],
                        ])->orWhere([
                            ['usuario.email', 'like', '%' . $search . '%'],
                        ]);
                    })->where(function ($query) use ($status) {
                        if ($status!='2'){
                            $query->where('status', '=' , $status);
                        }
                    })
                   ->orderBy($field, $sort)
                   ->get();
                    
        return view("cadastros.usuario.index")->with('usuarios', $usuarios);
    }


    public function create(Request $request)
    {
    }
  


    public function delete(Request $request)
    {
        return redirect($request->header('referer'));
    }    
    
}