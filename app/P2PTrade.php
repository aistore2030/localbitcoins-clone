<?php

namespace App;

use App\Notifications\AdminPasswordResetNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class P2PTrade extends Authenticatable
{
    use Notifiable;

    
    protected $table = 'p2p_trade';
   
    
public function orders()
{
   
   return $this->hasOne('App\P2p_orders', 'trade_id');
    
    
}
    
}
