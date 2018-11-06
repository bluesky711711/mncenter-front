<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Coin;
use App\Wallet;
use App\User;
use App\Http\Controllers\Rpc\jsonRPCClient;
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
      $coin = Coin::where('id', 7)->first();
      $rpc_user = $coin->rpc_user;
      $rpc_password = $coin->rpc_password;
      $rpc_port= $coin->rpc_port;
      $rpc_ip= $coin->rpc_ip;
      $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
      $to_address = 'bW2RPzUYL2WhHVkmraKsUL36F6H81xNZ1N';
      $amount = '0.1';
      Log::info('-------------------test----------------------------');
      Log::info($coin);
      Log::info($rpc_user);
      Log::info($rpc_password);
      Log::info($rpc_ip);
      Log::info($rpc_port);
      Log::info($to_address);
      Log::info($amount);
      $info = $client->sendtoaddress($to_address, $amount);
      Log::info($info);
    }
}
