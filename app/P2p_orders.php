<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class P2p_orders extends Model
{
    protected $table = 'p2p_orders';
    
      
    
public function trade()
{
    
      
    
    return $this->belongsTo('App\P2PTrade', 'trade_id');
    
    
    //return $this->belongsToMany('App\P2PTrade' );
}
    
      public function scopepermitionTo($query, $user_id)
    {
        return $query->where('user_id', $user_id)->orWhere('trade_user_id', $user_id);
    }
    
    
    
}
