<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange_deposit extends Model
{
    protected $table = 'exchange_deposit';
    protected $fillable = [
          'coin',
            'amount', 'deposit_address',   
      
        'status',
    'user_id',
        'ip',
    ];
}
