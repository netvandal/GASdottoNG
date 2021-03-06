<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use Theme;
use App\User;
use App\Gas;

class LoginController extends Controller
{
    use AuthenticatesUsers {
        login as realLogin;
    }

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function showLoginForm()
    {
        $gas = Gas::first();

        return Theme::view('auth.login', ['gas' => $gas]);
    }

    public function login(Request $request)
    {
        $gas = Gas::first();
        if ($gas->restricted == '1') {
            $username = $request->input('username');
            $user = User::where('username', $username)->first();
            if ($user == null || $user->can('gas.access', $gas) == false) {
                return redirect(url('login'));
            }
        }

        return $this->realLogin($request);
    }
}
