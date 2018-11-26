<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Coin;
use App\Masternode;
use App\Paymentsetting;
use App\User;
use App\Wallet;
use App\Referral;
use App\Reward;
use App\Server;
use App\Generalsetting;
use App\Http\Controllers\Rpc\jsonRPCClient;
use DB;
use Carbon\Carbon;
use App\Notifications\RewardNotification;
use App\Notifications\AdminRewardNotification;
class updateReward extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updaterewards';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command updaterewards to database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function CallAPI($method, $url, $data = false)
    {
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json'
              )
            );
            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    //curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    //curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $masternodes = Masternode::where('status', 'Completed')->get();
      $codeList = Paymentsetting::all();
      $payment_settings = [];
      for($i = 0; $i < count($codeList); $i++) {
        $payment_settings[$codeList[$i]["name"]] = $codeList[$i]["value"];
      }

      $now = Carbon::now();
      $next_time = $now->addDays(7);

      $code = Paymentsetting::firstOrCreate(["name" => "reward_date"]);
      $code->value = $next_time->toDateTimeString();
      $code->save();

      foreach ($masternodes as $masternode){
        $coin = Coin::where('id', $masternode->coin_id)->first();
        $sales = DB::table('sales')
                 ->select(DB::raw('user_id, sum(total_price) as sales_total'))
                 ->where('masternode_id', $masternode->id)
                 ->where('coin_id', $coin->id)
                 ->groupBy('user_id')
                 ->get();
        $rpc_user = $masternode->rpc_user;
        $rpc_password = $masternode->rpc_password;
        $rpc_port= $masternode->rpc_port;
        $rpc_ip= $masternode->rpc_ip;
        if ($rpc_user == '' || $rpc_user == NULL || $rpc_password == '' || $rpc_password == NULL || $rpc_port == '' || $rpc_port == NULL || $rpc_ip == '' || $rpc_ip == NULL){
          continue;
        }
        Log::info('$sales');
        Log::info($sales);
        $total_amount = 0;
        foreach ($sales as $sale){
          $total_amount = $total_amount + $sale->sales_total;
        }
        Log::info('$total_amount');
        Log::info($total_amount);
        if ($total_amount < $masternode->masternode_amount) continue;
        Log::info($rpc_user);
        Log::info($rpc_password);
        $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
        if ($client == null) continue;
        $balance = $client->getbalance();
        Log::info('$balance');
        Log::info($balance);

        if ($balance < 0.0001) continue;

        $profit = $balance - 0.0001;

        Log::info('profit');
        Log::info($profit);

        if ($profit > 0){
          foreach ($sales as $sale){
            $each_profit = $sale->sales_total / $total_amount * $profit;
            Log::info('each profit');
            Log::info($each_profit);
            $referred_by = Referral::where('user_id', $sale->user_id)->first();
            $user_profit = 0;
            $platform_profit = 0;
            $referral_profit = 0;
            $platform_address = $payment_settings[$coin->coin_name];
            Log::info('$referred_by');
            Log::info($referred_by);
            if (isset($referred_by->id)){
              $user_profit = $each_profit * 0.9;
              $platform_profit = $each_profit * 0.09;
              $referral_profit = $each_profit * 0.01;
              Log::info('$referred_by->id');
              Log::info($referred_by->id);
              $referred_by = User::where('id', $referred_by->referred_by)->first();
              $referral_wallet = Wallet::where('user_id', $referred_by->id)->where('coin_id', $coin->id)->first();
              if ($referral_wallet && $referral_wallet->wallet_address != ''){

                $res = $client->sendtoaddress($referral_wallet->wallet_address, floatval(number_format($referral_profit, 8)));

                if ($res != NULL){
                  $reward = Reward::create([
                    'user_id' => $sale->user_id,
                    'coin_id' => $coin->id,
                    'referral_id' => $referred_by->id,
                    'transaction_id' => $res,
                    'masternode_id' => $masternode->id,
                    'reward_amount' => $referral_profit,
                    'status' => 'completed',
                    'type' => 'to_referral'
                  ]);
                  if (isset($referred_by->id)){
                      $referred_by->notify(new RewardNotification($reward));
                  }
                  $data = [
                    "api_key" => "MNCENTER_API_KEY_ENCRYPTED_1.0",
                    "sale_id" => $reward->id,
                    "user_email" => $referred_by->email,
                    "sale_coin" => $coin->coin_name,
                    "sale_amount" => $user_profit,
                    "sale_masternode_id" => $masternode->id
                  ];
                  $data_string = json_encode($data);
                  Log::info('referral $data_string');
                  Log::info($data_string);
                  $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordrewords', $data_string);
                  Log::info('referral recordrewards');
                  Log::info($res);
                  $res = json_decode($res);
                  if (isset($res->status) && $res->status == "failed"){
                    $code = Generalsetting::firstOrCreate(["name" => "etherem_balance_status"]);
                    $code->value = false;
                    $code->save();
                  }
                }
              }
            } else {
              $user_profit = $each_profit * 0.9;
              $platform_profit = $each_profit * 0.1;
            }
            if ($platform_address != ''){
              Log::info('$platform_address');
              Log::info("$platform_address");
              Log::info('$platform_profit');
              Log::info(floatval($platform_profit));
              Log::info('sendtoaddress');
              $res = $client->sendtoaddress($platform_address, floatval(number_format($platform_profit, 8)));

              Log::info('$res');
              Log::info($res);
              if ($res != NULL){
                $referrer_id = NULL;
                if (isset($referred_by->id))  $referrer_id = $referred_by->referred_by;
                $reward = Reward::create([
                  'user_id' => $sale->user_id,
                  'coin_id' => $coin->id,
                  'referral_id' => $referrer_id,
                  'transaction_id' => $res,
                  'masternode_id' => $masternode->id,
                  'reward_amount' => $platform_profit,
                  'status' => 'completed',
                  'type' => 'to_platform'
                ]);
                $notification_platform_user = User::where('permission', 5)->first();
                if (isset($notification_platform_user->id)){
                    $notification_platform_user->notify(new AdminRewardNotification($reward));
                }
                $data = [
                  "api_key" => "MNCENTER_API_KEY_ENCRYPTED_1.0",
                  "sale_id" => $reward->id,
                  'coin_id' => $coin->id,
                  "user_email" => "platform",
                  "sale_coin" => $coin->coin_name,
                  "sale_amount" => $platform_profit,
                  "sale_masternode_id" => $masternode->id
                ];
                $data_string = json_encode($data);
                Log::info('user, datastring');
                Log::info($data_string);
                $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordrewords', $data_string);
                Log::info('referral $res');
                Log::info($res);
                $res = json_decode($res);
                if (isset($res->status) && $res->status == "failed"){
                  $code = Generalsetting::firstOrCreate(["name" => "etherem_balance_status"]);
                  $code->value = false;
                  $code->save();
                }
              }
            }
            $user = User::where('id', $sale->user_id)->first();
            $user_wallet = Wallet::where('user_id', $sale->user_id)->where('coin_id', $coin->id)->first();
            if ($user_wallet && $user_wallet->wallet_address != ''){
                Log::info('$user_profit');
                Log::info($user_profit);
                $res = $client->sendtoaddress($user_wallet->wallet_address, floatval(number_format($user_profit,8)));
                if ($res != NULL){
                  $referrer_id = NULL;
                  if (isset($referred_by->id))  $referrer_id = $referred_by->referred_by;
                  $reward = Reward::create([
                    'user_id' => $sale->user_id,
                    'transaction_id' => $res,
                    'coin_id' => $coin->id,
                    'referral_id' => $referrer_id,
                    'masternode_id' => $masternode->id,
                    'reward_amount' => $user_profit,
                    'status' => 'completed',
                    'type' => 'to_user'
                  ]);
                  $data = [
                    "api_key" => "MNCENTER_API_KEY_ENCRYPTED_1.0",
                    "sale_id" => $reward->id,
                    "user_email" => $user->email,
                    "sale_coin" => $coin->coin_name,
                    "sale_amount" => $user_profit,
                    "sale_masternode_id" => $masternode->id
                  ];
                  if (isset($user->id)){
                      $user->notify(new RewardNotification($reward));
                  }
                  $data_string = json_encode($data);

                  $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordrewords', $data_string);

                  $res = json_decode($res);
                  if (isset($res->status) && $res->status  == "failed"){
                    $code = Generalsetting::firstOrCreate(["name" => "etherem_balance_status"]);
                    $code->value = false;
                    $code->save();
                  }
                }
            }
          }
        }
      }


    }
}
