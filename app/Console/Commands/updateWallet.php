<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Coin;
use App\Wallet;
use App\User;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
class updateWallet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatewallets';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command update wallets';

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
      $wallets = Wallet::all();

      foreach ($wallets as $wallet){
        $balance = 0;
        $coin = Coin::where('id', $wallet->coin_id)->first();
        if ($coin->status != "Active"){
          continue;
        }
        $rpc_user = $coin->rpc_user;
        $rpc_password = $coin->rpc_password;
        $rpc_port= $coin->rpc_port;
        $rpc_ip= $coin->rpc_ip;
        $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
        $address = $wallet->wallet_address;

        $addresses = $client->listaddressgroupings();

        foreach ($addresses as $item) {
          foreach ($item as $address){
            if ( strtolower($address[0]) == strtolower($wallet->wallet_address)){
              $balance = $address[1];
            }
          }
        }

        if (floatval($balance) > 0){
          $user = User::where('id', $wallet->user_id)->first();
          $address = $client->getnewaddress("$user->id");
          $wallet->wallet_address = $address;
          $wallet->balance = floatval($wallet->balance) + floatval($balance);
          $wallet->save();
        }
      }
    }
}
