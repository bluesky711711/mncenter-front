<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Coin;
use App\Wallet;
use App\User;
use App\Masternode;
use App\Http\Controllers\Rpc\jsonRPCClient;
use App\Sale;
use App\Notifications\SalesNotification;
use Log;
class testCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testCommand';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command test testCommand';

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
      $sale = Sale::where('id', '>', 0)->first();
      //$admin = User::where('permission', 5)->first();
      $admin = User::where('email', 'krylro@gmail.com')->first();
      $admin->notify(new SalesNotification($sale));

      // $coin = Masternode::where('id', 4)->first();
      // $rpc_user = $coin->rpc_user;
      // $rpc_password = $coin->rpc_password;
      // $rpc_port= $coin->rpc_port;
      // $rpc_ip= $coin->rpc_ip;
      // $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
      // $to_address = 'NcBZUWBD1sGU6pE9j5Lqg3yaA9M2EBqwGT';
      // $amount = '0.001043495';
      //
      // Log::info('-------------------test----------------------------');
      // Log::info($coin);
      // Log::info($rpc_user);
      // Log::info($rpc_password);
      // Log::info($rpc_ip);
      // Log::info($rpc_port);
      // Log::info($to_address);
      // Log::info($amount);
      // $info = $client->sendtoaddress($to_address, floatval($amount));
      // Log::info($info);

    }
}
