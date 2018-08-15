<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Coin;
use App\Masternode;
use App\Transaction;
use App\Reward;
use App\User;
use Log;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        date_default_timezone_set('UTC');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function balances()
    {
      $coins = Coin::all();

      foreach ($coins as $coin){
        $masternodes = Masternode::where('coin_id', $coin->id)->where('status', 'completed')->get();
        $coin->completed_mn_count = count($masternodes);

        $masternode = Masternode::where('coin_id', $coin->id)->where('status', 'preparing')->first();
        $coin->queue_masternode = null;
        if ($masternode) $coin->queue_masternode = $masternode;
        Log::info($coin->queue_masternode);
        $coin->user_balance = 0;
        //$res = $client->get('https://api.coinmarketcap.com/v1/ticker/'.$coin->coin_name);
        //$result = $this->CallAPI('GET', 'https://api.coinmarketcap.com/v1/ticker/'.$coin->coin_name);
        //Log::info($res);
      }

        return view('balances', [
          'page' => 'balances',
          'coins' => $coins,
        ]);
    }

    public function home()
    {
        return view('home', []);
    }

    public function withdrawal_history()
    {
        $user = Auth::user();
        $withdrawals = Transaction::where('type', 'WITHDRAW')->where('user_id', $user->id)->get();
        return view('withdrawal_history', [
          'page' => 'withdrawal_history',
          'withdrawals' => $withdrawals
        ]);
    }

    public function deposit_history()
    {
        $user_id = Auth::user()->id;
        $deposits = Transaction::where('type', 'DEPOSIT')->where('user_id', $user_id)->get();
        return view('deposit_history', [
          'page' => 'deposit_history',
          'deposits' => $deposits
        ]);
    }

    public function user_settings()
    {
        $user_id = Auth::user()->id;
        Log::info($user_id);
        $user = User::where('id', $user_id)->first();
        return view('user_settings', [
          'page' => 'user_settings',
          'user' => $user
        ]);
    }

    public function reward_history()
    {
        $rewards = Reward::where('user_id', Auth::user()->id);
        foreach ($rewards as $reward){
            $sales = Sale::where('user_id', Auth::user()->id)->where('masternode_id', $reward->masternode_id)->where('status', 'completed')->get();
            $sale_amount = 0;
            foreach ($sales as $sale){
              $sale_amount = $sale->total_price + $sale_amount;
            }
            $reward->sale_mn_amount = $sale_amount;

            $rewards_masternode = Reward::where('masternode_id', $reward->masternode_id)->get();
            $reward_mn_total = 0;
            foreach ($rewards_masternode as $item){
              $reward_mn_total = $reward_mn_total + $item->reward_amount;
            }
            $reward->mn_total = $reward_mn_total;

        }

        return view('reward_history', [
          'page' => 'reward_history',
          'rewards' => $rewards
        ]);
    }
}
