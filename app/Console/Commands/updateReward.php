<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Log;
use App\Coin;
use App\Masternode;
use App\Paymentsetting;
use App\Server;
class updatePrice extends Command
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
        $coin = Coin::where('id', $masternode->coin_id)->get()
        $server = Server::where('id', $masternode->server_id)->first();
        
      }
    }
}
