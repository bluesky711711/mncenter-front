<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sale;
use App\Coin;
use App\Transaction;
use App\Wallet;
use App\User;
use App\Generalsetting;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
class updateSale extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatesales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
      $sales = Sale::where('status', 'Pending')->get();
      foreach ($sales as $sale){
        $user_id = $sale->user_id;
        $coin = Coin::where('id', $sale->coin_id)->first();
        $user = User::where('id', $user_id)->first();
        if ($coin->status == 'Deactive'){
          continue;
        }
        $rpc_user = $coin->rpc_user;
        $rpc_password = $coin->rpc_password;
        $rpc_port= $coin->rpc_port;
        $rpc_ip= $coin->rpc_ip;
        $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
        $tran = $client->gettransaction($sale->transaction_id);
        if ($sale->confirms <= 5 && $tran['confirmations'] > 5){
          $sale->status = "Completed";
          $sale->save();
          $data = [
            "api_key" => "MNCENTER_API_KEY_ENCRYPTED_1.0",
            "sale_id" => $sale->id,
            "user_email" => $user->email,
            "sale_coin" => $coin->coin_name,
            "sale_amount" => $sale->total_price,
            "sale_masternode_id" => $sale->masternode_id
          ];
          $wallet = Wallet::where('coin_id', $sale->coin_id)->where('user_id', $sale->user_id)->first();

          $wallet->balance = floatval($wallet->balance) + floatval($tran['amount']);
          Log::info('sale complete ------------');
          Log::info($wallet->balance);
          $wallet->save();
          $data_string = json_encode($data);
          $res = $this->CallAPI('POST', 'http://95.179.179.106:3000/api/recordsales', $data_string);
          if ($res->status == "failed"){
            $code = Generalsetting::firstOrCreate(["name" => "etherem_balance_status"]);
            $code->value = false;
            $code->save();
          }
        }
        $sale->confirms = $tran['confirmations'];
        $sale->save();
      }
    }
}
