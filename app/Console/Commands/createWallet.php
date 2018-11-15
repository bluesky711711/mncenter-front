<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Coin;
use App\Wallet;
use App\User;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
class createWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:createwallets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command createwallets';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $users = User::all();
      foreach ($users as $user){
        $user_id = $user->id;
        $coins = Coin::all();
        foreach ($coins as $coin){
          if ($coin->status != "Active"){
            continue;
          }
          $wallet = Wallet::where('coin_id', $coin->id)->where('user_id', $user_id)->first();

          if ($wallet){
            continue;
          } else  {
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
      }
    }
}
