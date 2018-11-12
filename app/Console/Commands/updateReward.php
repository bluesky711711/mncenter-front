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
use App\Server;
use App\Generalsetting;

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
      foreach ($masternodes as $masternode){
        $coin = Coin::where('id', $masternode->coin_id)->first();
        $sales = DB::table('sales')
                 ->select(DB::raw('sum(sales_amount) as sales_total'))
                 ->groupBy('user_id')
                 ->get();
        $rpc_user = $masternode->rpc_user;
        $rpc_password = $masternode->rpc_password;
        $rpc_port= $masternode->rpc_port;
        $rpc_ip= $masternode->rpc_ip;
        if ($rpc_user == '' || $rpc_user == NULL || $rpc_password == '' || $rpc_password == NULL || $rpc_port == '' || $rpc_port == NULL || $rpc_ip == '' || $rpc_ip == NULL){
          continue;
        }

        $total_amount = 0;
        foreach ($sales as $sale){
          $total_amount = $total_amount + $sale->sales_total;
        }

        if ($total_amount < $masternode->masternode_amount) continue;

        $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
        if ($client == null) continue;
        $balance = $client->getbalance();
        $profit = $balance - $coin->masternode_amount - 1;

        $codeList = Paymentsetting::all();
        $payment_settings = [];
        for($i = 0; $i < count($codeList); $i++) {
          $payment_settings[$codeList[$i]["name"]] = $codeList[$i]["value"];
        }

        if ($profit > 0){
          foreach ($sales as $sale){
            $each_profit = $sale->sales_total / $total_amount * $profit;
            $referred_by = Referral::where('user_id', $sale->user_id)->first();
            $user_profit = 0;
            $platform_profit = 0;
            $referral_profit = 0;
            if ($referred_by){
              $user_profit = $each_profit * 0.9;
              $platform_profit = $each_profit * 0.09;
              $referral_profit = $each_profit * 0.01;
              $platform_address = $payment_settings[$coin->coin_name];

              $referral_wallet = Wallet::where('user_id', $referred_by->id)->where('coin_id', $coin->id)->first();
              if ($referral_wallet && $referral_wallet->wallet_address != ''){
                $res = $client->sendtoaddress($referral_wallet->wallet_address, floatval($referral_profit));
                if ($res != NULL){
                  $reward = Reward::create([
                    'user_id' => $sale->user_id,
                    'referral_id' => $referred_by->id,
                    'transaction_id' => $res,
                    'masternode_id' => $masternode->id,
                    'reward_amount' => $referral_profit,
                    'status' => 'pending',
                    'type' => 'to_referral'
                  ]);
                  $data = [
                    "api_key" => "MNCENTER_API_KEY_ENCRYPTED_1.0",
                    "sale_id" => $reward->id,
                    "user_email" => $referred_by->email,
                    "sale_coin" => $coin->coin_name,
                    "sale_amount" => $user_profit,
                    "sale_masternode_id" => $sale->masternode_id
                  ];
                  $data_string = json_encode($data);
                  $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordrewords', $data_string);
                  if ($res->status == "failed"){
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
              $res = $client->sendtoaddress($platform_address, floatval($platform_profit));
              if ($res != NULL){
                $reward = Reward::create([
                  'user_id' => $sale->user_id,
                  'coin_id' => $coin->id,
                  'referral_id' => $referred_by->id,
                  'transaction_id' => $res,
                  'masternode_id' => $masternode->id,
                  'reward_amount' => $platform_profit,
                  'status' => 'completed',
                  'type' => 'to_platform'
                ]);

                $data = [
                  "api_key" => "MNCENTER_API_KEY_ENCRYPTED_1.0",
                  "sale_id" => $reward->id,
                  'coin_id' => $coin->id,
                  "user_email" => "platform",
                  "sale_coin" => $coin->coin_name,
                  "sale_amount" => $platform_profit,
                  "sale_masternode_id" => $sale->masternode_id
                ];
                $data_string = json_encode($data);
                $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordrewords', $data_string);
                if ($res->status == "failed"){
                  $code = Generalsetting::firstOrCreate(["name" => "etherem_balance_status"]);
                  $code->value = false;
                  $code->save();
                }
              }
            }
            $user = User::where('id', $sale->user_id)->first();
            $user_wallet = Wallet::where('user_id', $sale->user_id)->where('coin_id', $coin->id)->first();
            if ($user_wallet && $user_wallet->wallet_address != ''){
                $res = $client->sendtoaddress($user_wallet->wallet_address, floatval($user_profit));
                if ($res != NULL){
                  $reward = Reward::create([
                    'user_id' => $sale->user_id,
                    'transaction_id' => $res,
                    'coin_id' => $coin->id,
                    'referral_id' => $referred_by->id,
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
                    "sale_masternode_id" => $sale->masternode_id
                  ];
                  $data_string = json_encode($data);
                  $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordrewords', $data_string);
                  if ($res->status == "failed"){
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
