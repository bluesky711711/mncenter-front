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

class Sale extends Model
{
	protected $fillable = ['user_id', 'transaction_id', 'coin_id', 'user_id', 'sales_amount', 'total_price',  'masternode_id',  'status'];

	public function user()
	{
			return $this->belongsTo('App\User');
	}

	public function masternode()
	{
			return $this->belongsTo('App\Masternode');
	}
}
