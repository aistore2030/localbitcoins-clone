<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class System_Deposit extends Model
{
    protected $table = 'exchange_deposit';
    protected $fillable = [
          'coin',
            'amount', 'widthdraw_address',   
      
        'status',   'id',
    'user_id',
        'ip',
    ];
}
