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
                return back()->with('warning',"First please active your account.");
            }

            $user_id = auth()->user()->id;
            $coins = Coin::all();
            foreach ($coins as $coin){
              if ($coin->status != "Active"){
                $coin->user_balance = 0;
                $coin->address = "unknow";
                continue;
              }

              $wallet = Wallet::where('coin_id', $coin->id)->where('user_id', $user_id)->first();
              if ($wallet && $wallet->wallet_address != ''){
                $coin->user_balance = $wallet->balance;
                Log::info('wallet exist');
              } else if ($wallet){
                $rpc_user = $coin->rpc_user;
                $rpc_password = $coin->rpc_password;
                $rpc_port= $coin->rpc_port;
                $rpc_ip= $coin->rpc_ip;
                $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
                $address = $client->getaccountaddress("$user_id");
                $wallet->wallet_address = $address;
              } else {
                $rpc_user = $coin->rpc_user;
                $rpc_password = $coin->rpc_password;
                $rpc_port= $coin->rpc_port;
                $rpc_ip= $coin->rpc_ip;
                $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
                $address = $client->getaccountaddress("$user_id");
                $wallet = Wallet::create([
                  'coin_id' => $coin->id,
                  'user_id' => $user_id,
                  'wallet_address' => $address,
                  'balance' => 0
                ]);
              }
            }
            return redirect()->to('home');
        } else {
            return back()->with('error','Your username and password are wrong.');
        }
    }
}
