<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    public function username()
    {
        return 'login';
    }

    protected function login(Request $data)
    {

        $this->validate($data, [
            'login'    => ['required'],
            'password' => ['required'],
        ], [], [
            'login' => 'Usuário',
            'password' => 'Senha',
        ]);



        $usuario = DB::table('usuario')->where('login', '=', $data->login)->first();
        if($usuario->reset_password){

            if (Auth::attempt(['login' => $data->login, 'password' => $data->password])) {
                // Success
                return redirect()->intended('/');
            } else {
                // Go back on error (or do what you want)
                return redirect()->back();
            }
        } else {

            return view('auth.passwords.email')->with('usuario', $usuario);

        }
    }


}
