<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange_widthdraw extends Model
{
    protected $table = 'exchange_btcaddress';
    protected $fillable = [
          'xpub',
            'address', 'user_id'   
       
    ];
}
