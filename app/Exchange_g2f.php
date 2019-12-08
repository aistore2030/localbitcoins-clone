<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange_g2f extends Model
{
    protected $table = 'exchange_g2f';
    protected $fillable = [
          'coin',
            'amount', 'deposit_address',   
      
        'status',
    'user_id',
        'ip',
    ];
}
