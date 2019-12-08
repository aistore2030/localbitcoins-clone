<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange_widthdraw extends Model
{
    protected $table = 'exchange_widthdraw';
    protected $fillable = [
          'coin',
            'amount', 'widthdraw_address',      'description',    
      'widthdraw_transaction_id',
        'status',
    'user_id',
        'ip',
    ];
}
