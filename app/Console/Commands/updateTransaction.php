<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Sale;
use App\Coin;
use App\Transaction;
use App\Wallet;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
class updateTransaction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:updatetransactions';

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

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $wallets = Wallet::all();
      foreach ($wallets as $wallet){
        $user_id = $wallet->user_id;
        $wallet_address = $wallet->wallet_address;
        $coin = Coin::where('id', $wallet->coin_id)->first();
        if ($coin->status == 'Deactive'){
          continue;
        }
        $rpc_user = $coin->rpc_user;
        $rpc_password = $coin->rpc_password;
        $rpc_port= $coin->rpc_port;
        $rpc_ip= $coin->rpc_ip;
        $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
        $trans = $client->listtransactions("$user_id", 1000);
        if (!$trans) continue;
        foreach ($trans as $tran){
            if ($tran['category'] == 'send') continue;
            $item = Transaction::where('transaction_hash', $tran['txid'])->where('user_id', $user_id)->where('type', 'DEPOSIT')->first();
            if (isset($item->id)){
              $item->confirms = $tran['confirmations'];
              if ($item->status != "Completed" && $tran["confirmations"] > 5) {
                  $item->status="Completed";
                  // $wallet->balance = floatval($wallet->balance) + floatval($tran['amount']);
                  // $wallet->save();
              }
              $item->save();
            } else {
              $status = 'Pending';
              if ($tran["confirmations"] > 5) $status="Completed";
              Transaction::create([
                'transaction_hash' => $tran['txid'],
                'coin_id' => $coin->id,
                'user_id' => $user_id,
                'type' => 'DEPOSIT',
                'to_address' => $tran['address'],
                'amount' => $tran['amount'],
                'confirms' => $tran["confirmations"],
                'transaction_time' => $tran['time'],
                'status' => $status
              ]);
            }
          }
      }

      $withdraws = Transaction::where('status', 'Pending')->where('type', 'WITHDRAW')->get();
      foreach ($withdraws as $withdraw){
        $user_id = $withdraw->user_id;
        $coin = Coin::where('id', $withdraw->coin_id)->first();

        if ($coin->status == 'Deactive'){
          continue;
        }
        $rpc_user = $coin->rpc_user;
        $rpc_password = $coin->rpc_password;
        $rpc_port= $coin->rpc_port;
        $rpc_ip= $coin->rpc_ip;
        $client = new jsonRPCClient('http://'.$rpc_user.':'.$rpc_password.'@'.$rpc_ip.':'.$rpc_port.'/');
        $tran = $client->gettransaction($withdraw->transaction_hash);
        $withdraw->confirms = $tran['confirmations'];
        // Log::info($tran);
        // Log::info($tran['confirmations']);
        if ($tran['confirmations'] > 5){
          $withdraw->status = "Completed";
          $wallet = Wallet::where('coin_id', $withdraw->coin_id)->where('user_id', $user_id)->first();
          $wallet->balance = floatval($wallet->balance) + floatval($tran['amount']);
          $wallet->save();
        }
        $withdraw->save();
      }
    }
}
