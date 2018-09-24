<?php

namespace App;

/******************************************************
 * IM - Vocabulary Builder
 * Version : 1.0.2
 * Copyright© 2016 Imprevo Ltd. All Rights Reversed.
 * This file may not be redistributed.
 * Author URL:http://imprevo.net
 ******************************************************/

use Illuminate\Database\Eloquent\Model;
use App\Word;

class Coin extends Model
{
	protected $fillable = ['coin_name', 'coin_symbol', 'masternode_amount', 'coin_price', 'seat_price', 'rpc_ip', 'rpc_user', 'rpc_password', 'rpc_port', 'status'];
}
