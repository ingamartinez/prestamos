<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flash;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('login.index');
    }

    public function store(Request $request)
    {
        $user = User::withTrashed()->where([
            ['email','=',$request->email],
            ['password','=',$request->password]
        ])->first();

        if($user){
            if ($user->trashed()){
                Flash::error('Usuario deshabilitado');
                return redirect()->back();
            }else{
                Auth::login($user);
                return redirect()->intended('/');
            }
        }else{
            Flash::error('Credenciales Incorrectas');

            return redirect()->back();
        }

    }

    public function logout(){
        Auth::logout();
        return redirect()->intended('login');
    }

}
