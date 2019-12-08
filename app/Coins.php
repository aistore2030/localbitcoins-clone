<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coins extends Model
{
    protected $table = 'coins';
    protected $fillable = [
          'name',
            'symbols', 'deposit_address',   
      
        'status' 
 
    ];
}
