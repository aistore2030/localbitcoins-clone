<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bonus_settings extends Model
{
    protected $table = 'bonus_settings';
    protected $fillable = [
          'name',
            'symbols',    'bonus' 
    ];
}
