<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use App\Coin;
use App\Masternode;
use App\Transaction;
use App\Reward;
use App\Wallet;
use App\User;
use App\Sale;
use App\Paymentsetting;
use App\Referral;

use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
use Mail;
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
      $user = Auth::user();

      foreach ($coins as $coin){
        $balance = 0;
        $address = "unknown";
        $coin->user_balance = 0;
        $coin->address = "unknow";
        if ($coin->status != "Active"){
          continue;
        }
        $sales = Sale::where('status', 'completed')->where('coin_id', $coin->id)->where('user_id', $user->id)->get();
        $total_amount = 0;
        foreach ($sales as $sale){
          $total_amount += $sale->total_price;
        }

        $withdraws = Transaction::where('status', 'pending')->where('type', 'WITHDRAW')->where('coin_id', $coin->id)->where('user_id', $user->id)->get();
        $pending_withdraw_amount = 0;
        foreach ($withdraws as $withdraw){
          $pending_withdraw_amount = $pending_withdraw_amount + floatval($withdraw->amount);
        }
        $coin->pending_withdraw_amount = $pending_withdraw_amount;

        $deposits = Transaction::where('status', 'pending')->where('type', 'DEPOSIT')->where('coin_id', $coin->id)->where('user_id', $user->id)->get();
        $pending_deposit_amount = 0;
        foreach ($deposits as $deposit){
          $pending_deposit_amount = $pending_deposit_amount + floatval($deposit->amount);
        }
        $coin->pending_deposit_amount = $pending_deposit_amount;

        $rewards = Reward::where('status', 'completed')->where('user_id', $user->id)->where('coin_id', $coin->id)->where('type', 'to_user')->get();

        $paid_reward_amount = 0;
        foreach ($rewards as $reward){
          $paid_reward_amount = $paid_reward_amount + floatval($reward->reward_amount);
        }
        $coin->paid_reward_amount = $paid_reward_amount;

        $masternodes = Masternode::where('coin_id', $coin->id)->where('status', 'completed')->get();
        $coin->completed_mn_count = count($masternodes);

        $masternode = Masternode::where('coin_id', $coin->id)->where('status', 'preparing')->first();
        $coin->queue_masternode = null;
        if ($masternode) $coin->queue_masternode = $masternode;

        $wallet = Wallet::where('coin_id', $coin->id)->where('user_id', $user->id)->first();
        $coin->address = $wallet->wallet_address;
        $coin->tx_fee = 0;
        $coin->user_balance = floatval($wallet->balance);
        $coin->total_amount = floatval($total_amount) + floatval($wallet->balance);


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

    public function withdraw_post(Request $request){
      $user = Auth::user();
      $coin = Coin::where('id', $request->coin_id)->first();
      $amount = $request->input('amount');
      $wallet = Wallet::where('user_id', $user->id)->where('coin_id', $coin->id)->first();
      $to_address = $request->input('to_address');
      $rpc_user = $coin->rpc_user;
      $rpc_password = $coin->rpc_password;
      $rpc_port= $coin->rpc_port;
      $rpc_ip= $coin->rpc_ip;
      $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');

      $res = $client->sendtoaddress($to_address, floatval($amount));
      if ($res){
        $transaction = Transaction::create([
          'transaction_hash' => $res,
          'coin_id' => $coin->id,
          'type' => 'WITHDRAW',
          'user_id'=> $user->id,
          'amount' => $amount,
          'status' => 'Pending',
          'to_address' => $to_address,
          'confirms' => 0
        ]);
        //Log::info($res);
      } else {
          return back()->with('failed','transaction failed!');
      }
      return back()->with('success','successfully submitted the sending request!');
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
        Log::info($user_id);
        return view('deposit_history', [
          'page' => 'deposit_history',
          'deposits' => $deposits
        ]);
    }

    public function user_settings()
    {
        $user_id = Auth::user()->id;
        $user = User::where('id', $user_id)->first();
        $referrals = Referral::where('referred_by', $user->id)->get();

        $rewards = Reward::where('referral_id', $user->id)->where('type', 'to_referral')->get();
        $profit = 0;
        foreach ($rewards as $reward){
          $profit = $reward->reward_amount + $profit;
        }
        return view('user_settings', [
          'page' => 'user_settings',
          'user' => $user,
          'profit' =>$profit,
          'referrals' => $referrals
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

    public function post_deposit(Request $request){
      $coin_id = $request->input('coin_id');
      $user = Auth::user();

    }

    public function deposit(Request $request){
      $coin_id = $request->input('coin_id');
    }

    public function withdraw(Request $request){
      $coin_id = $request->input('coin_id');
    }

    public function buyseats(Request $request){
      $user = Auth::user();
      $coin_id = $request->input('sale_coin_id');
      $masternode_id = $request->input('masternodeid');
      $seat_amount = $request->input('seat_amount');
      $coin = Coin::where('id', $coin_id)->first();
      $amount = $seat_amount * $coin->seat_price;
      $rpc_user = $coin->rpc_user;
      $rpc_password = $coin->rpc_password;
      $rpc_port= $coin->rpc_port;
      $rpc_ip= $coin->rpc_ip;
      $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');

      $codeList = Paymentsetting::all();
      $payment_settings = [];
      for($i = 0; $i < count($codeList); $i++) {
        $payment_settings[$codeList[$i]["name"]] = $codeList[$i]["value"];
      }

      if (isset($payment_settings[$coin->coin_name])){
          Log::info($payment_settings[$coin->coin_name]);
          Log::info($amount);
          $res = $client->sendtoaddress($payment_settings[$coin->coin_name], floatval($amount));
          if (!$res){
              return back()->with('failed','failed for generating transaction!');
          } else {
            Sale::create([
              'transaction_id' => $res,
              'coin_id' => $coin_id,
              'masternode_id' => $masternode_id,
              'user_id' => $user->id,
              'sales_amount' => $seat_amount,
              'total_price' => $amount,
              'status' => 'Pending',
              'confirms' => '0'
            ]);
          }
      } else {
        return back()->with('failed','No any target address!');
      }
      return back()->with('success','successfully submitted the sales request! it may takes some times for confirming it.');
    }

    public function changepassword(Request $request){
      Log::info('resetpassword');
      $user_id = $request->input('id');
      $password = $request->input('password');
      $password_confirm = $request->input('password-confirmation');
      Log::info($user_id);
      Log::info($password);
      Log::info($password_confirm);
      if ($password == $password_confirm){
          $user = User::where('id', $user_id)->first();
          if (isset($user->id)){
            $user->password = bcrypt($password);
            $user->save();
            $user = $user->toArray();
            $user['password'] = $password;
            Mail::send('emails.forgetpassword', $user, function($message) use ($user) {
                $message->to($user['email']);
                $message->subject('Site - Reset Password');
            });
            return back()->with('success', 'Your password successfully changed!');
          }
          return back()->with('failed', 'Your email is not registered yet!');
      }
      return back()->with('failed', 'Passwords are not match! Please input again!');
    }
}
