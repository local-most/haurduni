<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/administrator';

    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user != null) {
            if ($user->role == role('pelanggan')) {
                return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
            }else{
                if (Auth::attempt(['username'=>$request->username,'password'=>$request->password])) 
                {
                    return redirect()->route('dashboard');
                }
                return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
            }
        }else{
            return back()->with('msg',['type'=>'danger','text'=>'Username dan Password Tidak Cocok!'])->withInput();
        }
    }

    public function logout() {
        Auth::guard('web')->logout();
        return redirect()->route('login.admin');
    }
}
