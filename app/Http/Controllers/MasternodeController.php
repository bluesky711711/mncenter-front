<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Coin;
use App\Masternode;
use App\Setting;
use App\Reward;
use GuzzleHttp\Client;
use App\Http\Controllers\Rpc\jsonRPCClient;
use Log;
class MasternodeController extends Controller
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

  public function CallAPI($method, $url, $data = false)
  {
    $curl = curl_init();

    switch ($method)
    {
      case "POST":
      curl_setopt($curl, CURLOPT_POST, 1);

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
    // curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    // curl_setopt($curl, CURLOPT_USERPWD, "username:password");

    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
  }

  public function coins()
  {
    $coins = Coin::all();
    $client = new Client();
    foreach ($coins as $coin){
      $masternodes = Masternode::where('coin_id', $coin->id)->where('status', 'completed')->get();
      $coin->completed_mn_count = count($masternodes);

      $masternode = Masternode::where('coin_id', $coin->id)->where('status', 'preparing')->first();
      $coin->queue_masternode = null;
      if ($masternode) $coin->queue_masternode = $masternode;
      Log::info($coin->queue_masternode);
    }


    return view('masternodecoins', [
      'page' => 'masternodecoins',
      'coins' => $coins,
    ]);
  }

  public function masternodes($id)
  {
    $coin = Coin::where('id', $id)->first();

    $masternodes = Masternode::where('coin_id', $id)->get();
    $completed_masternodes = Masternode::where('coin_id', $id)->where('status', 'Completed')->get();
    $preparing_masternode = Masternode::where('coin_id', $id)->where('status', 'Preparing')->first();
    return view('masternodes', [
      'page' => 'masternodes',
      'masternodes' => $masternodes,
      'completed_masternodes' => $completed_masternodes,
      'preparing_masternode' => $preparing_masternode,
      'coin' => $coin
    ]);
  }

  public function masternode($id)
  {
    $masternode = Masternode::where('id', $id)->first();
    $rewards = Reward::where('masternode_id', $id)->get();
    $coin = Coin::where('id', $masternode->coin_id)->first();
    return view('masternodedetails', [
      'page' => 'masternodedetails',
      'masternode' => $masternode,
      'rewards' => $rewards,
      'coin' => $coin,
    ]);
  }

  public function addseats(Request $request){
    $coin_id = $request->input('coind_id');
    $masternode_id = $request->input('masternode_id');
    $user_id = Auth::user()->id;

  }
}
