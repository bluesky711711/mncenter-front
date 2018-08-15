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

class Masternode extends Model
{
	protected $fillable = ['name', 'coin_id', 'status', 'total_seats', 'empty_seats', 'seat_amount', 'address', 'server_id', 'active'];

    public function coin()
    {
        return $this->belongsTo('App\Coin');
    }

    public function server()
    {
        return $this->belongsTo('App\Server');
    }
}
