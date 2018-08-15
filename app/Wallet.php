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

class Wallet extends Model
{
	protected $fillable = ['user_id', 'coin_id', 'wallet_address', 'total_price'];

	public function user()
	{
			return $this->belongsTo('App\User');
	}

	public function coin()
	{
			return $this->belongsTo('App\Coin');
	}
}
