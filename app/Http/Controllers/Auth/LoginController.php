<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Coin;
use App\Wallet;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
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
    protected $redirectTo = '/balances';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (auth()->attempt(array('email' => $request->input('email'), 'password' => $request->input('password'))))
        {
            if(auth()->user()->is_activated != 1){
                Auth::logout();
                return back()->with(['warning' => "First please active your account.", 'email' => $request->input('email')]);
            }


            return redirect()->to('home');
        } else {
            return back()->with('error','Your username or password are wrong.');
        }
    }
}
