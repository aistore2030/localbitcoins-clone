<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Exchange_bookings extends Model
{
    protected $table = 'exchange_bookings';
    protected $fillable = [
          'pair',
            'type',    'rate','description',
        'c1',
        'c2',
        'status',
    'user_id',
        'ip',
    ];
}
