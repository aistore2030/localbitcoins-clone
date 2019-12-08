<?php

namespace App\Http\Controllers;

use App\ChargeCommision;
use App\Income;
use App\MemberExtra;
use App\Deposit;
use App\Gateway;
use App\Lib\GoogleAuthenticator;
use App\Transaction;
use App\User;


use App\Exchange_bookings;
use Illuminate\Support\Facades\DB;

 
use App\Http\Controllers\Controller;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;

class TradeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth' ]);
    }

    public function index()
    {
        return view('home');
    }

    

public function newsfeed()
    {
       
       $content = file_get_contents("https://news.bitcoin.com/feed");
    $x = new \SimpleXmlElement($content);
     
     
      
    echo "<ul>";
     
    foreach($x->channel->item as $entry) {
        echo "<li><a href='$entry->link' title='$entry->title'>" . $entry->title . "</a></li>";
    }
    echo "</ul>";
    
    
    }
 public function GetTicker($c1,$c2)
    {
        
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.bitfinex.com/v1/pubticker/".$c1.$c2); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);   

// convert response 

 curl_close($ch);
   return $output ;


 
      
       
    } 
 
 
  public function GetTValueBuy( $c1,$c2,$total)
    {
      return  $this->GetTValue("buy",$c1,$c2,$total);
        
    }
    
      public function GetTValueSell( $c1,$c2,$total)
    {
  return  $this->GetTValue("sell",$c1,$c2,$total);
        
    }
    
    
  public function GetTValue($type,$c1,$c2,$total)
    {
        
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.bitfinex.com/v1/pubticker/".$c1.$c2); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);

$ar=json_decode($output);




// convert response 

 curl_close($ch);
 

 if($type=="sell")
 { 
 return  $ar->bid*$total;
 }
 else
 {
    return $ar->ask*$total; 
     
 }
 


 
      
       
    } 
 
 ///////////////////RRRR
 
 
  public function GetTValueBuyR( $c1,$c2,$total)
    {
      return  $this->GetTValueR("buy",$c1,$c2,$total);
        
    }
    
      public function GetTValueSellR( $c1,$c2,$total)
    {
  return  $this->GetTValueR("sell",$c1,$c2,$total);
        
    }
    
    
  public function GetTValueR($type,$c1,$c2,$total)
    {
        
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.bitfinex.com/v1/pubticker/".$c1.$c2); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
$output = curl_exec($ch);

$ar=json_decode($output);




// convert response 

 curl_close($ch);
 

 if($type=="sell")
 { 
 return  (1/$ar->bid)*$total;
 }
 else
 {
    return (1/$ar->ask)*$total; 
     
 }
 


 
      
       
    } 
    
    
  public function getUserBalance()
    {
      
        $user_id =Auth::user()->id;
        
        $q="select sum(cr)-sum(dr) balance,coin  from exchange_orders where  user_id=".$user_id."   GROUP by coin";
        
        
        
    $trans = DB::select($q);
    
    echo json_encode( $trans);
    
    
    } 
 
 
 
  public function trade_theme_one($c1,$c2)
    {
      
        return view('trade.index'   ,  ['c1' => $c1,'c2' => $c2]);
    } 
 
 
  public function tradeIndex($c1,$c2)
    {
      
        return view('fonts.trade.trade' ,  ['c1' => $c1,'c2' => $c2]);
    } 
 
 
 
 

 public function CreateTradeOrder( Request $request )
    { 
    


    $data =  $request->trade;
    
       $obj = json_decode($data, true); ;
     
 
 $order = new Exchange_bookings;
  $order->pair = $obj['pair'];
   
  
   $order->type =$obj['type'];
   $order->quantity =$obj['quantity'];
   
    $order->amount =$obj['amount'];
    
    $order->c1 =$obj['c1'];
    
    $order->c2 =$obj['c2'];
    
      $order->rate =$obj['amount']/$obj['quantity'];
    
     $order->user_id =Auth::user()->id;
     
     $order->ip ="localhost";
        $order->status ="Pending";
  $order->save();
  
 // $this->FinishTradeOrder( $request );
 
 // if order type is sell btc for usd
 
 
 
 
 if($order->type=="sell")
 {
// $this->FinishTradeSellOrder(  $order->user_id,  $order->quantity ,   $order//->pair,$order->id  );
 
 
  $this->FinishTradeSellOrder2($order);
 }
 else
 {
     
    $this->FinishTradeBuyOrder(  $order->user_id,  $order->quantity ,   $order->pair,$order->id  );   
 }
 
 
       return "Booked";
        
    }



 public function CreateTradeOrderRemainingQty(   $order  ,$newQty)
 
 {
     
     
  $order->status ="Pending";
  $order->description ="description Pending";
   $order->quantity =$newQty;
    
  $order->save();
  
  
   
   
 }

 public function FinishTradeSellOrder2( $order )
    { 
        
     $sellor=   $order->user_id;
     
    $qty= $order->quantity ;
    
    
    $pair= $order->pair;
    
   $sellor_order_id=$order->id;
  
    $trans = DB::select("select * from exchange_bookings where pair =  '".$pair."' and quantity >=".$qty." and type='buy' and Status='Pending'  order by id desc limit 1");
         
         

foreach ($trans as $row) {
  
   
   
   DB::delete("delete from exchange_orders where sellor_order_id=".$sellor_order_id." and  buyer_order_id= ".$row->id."");
   
   
   
   //bitcoin transfer 
   
   // SELLOR
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [ $sellor_order_id,$row->id,$row->user_id,'0',$qty,$row->c1,'Success','Trade']);
   
   
   
   
   //BUYER
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$sellor_order_id,$row->id,$sellor,$qty,'0',$row->c1,'Success','Trade']);
   
   
  
// usd transfer 


   // SELLOR
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$sellor_order_id,$row->id,$row->user_id,$row->amount,'0',$row->c2,'Success','Trade']);
   
   


   //BUYER 
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$sellor_order_id,$row->id,$sellor, '0',$row->amount,$row->c2,'Success','Trade']);
   
   
   
    
   
// MARK ORDER COMPLETE

$affected = DB::update("update exchange_bookings  set status = 'complete' where id =".$row->id." or id =".$sellor_order_id);
 // NOW CREATE ANOTHER TRADE ORDER SO THAT REMAINING ORDER CAN ALSO BE COMPLETED..
 
 $newQty=$row->quantity - $qty;
 
    $this-> CreateTradeOrderRemainingQty(   $order  ,$newQty);
    
    
 DB::insert("insert into exchange_rate_sale (pair, rate) values (?, ? )", [ $row->pair,$row->rate]);
     
//print_r($row);

}

         
      // fetch find sellor of same qty 
      
      // do debit from his account  and credit to user account
      
      // mark order complete
        
    }
    
    
    
 public function FinishTradeSellOrder($sellor,$qty,  $pair,  $sellor_order_id  )
    { 
        
  
   
  
    $trans = DB::select("select * from exchange_bookings where pair =  '".$pair."' and quantity='".$qty."' and type='buy' and Status='Pending'  order by id desc limit 1");
         
         

foreach ($trans as $row) {
  
   
   
   DB::delete("delete from exchange_orders where sellor_order_id=".$sellor_order_id." and  buyer_order_id= ".$row->id."");
   
   
   
   //bitcoin transfer 
   
   // SELLOR
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [ $sellor_order_id,$row->id,$row->user_id,'0',$qty,$row->c1,'Success','Trade']);
   
   
   
   //BUYER
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$sellor_order_id,$row->id,$sellor,$qty,'0',$row->c1,'Success','Trade']);
   
   
  
// usd transfer 


   // SELLOR
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$sellor_order_id,$row->id,$row->user_id,$row->amount,'0',$row->c2,'Success','Trade']);
   
   


   //BUYER 
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,dr,cr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$sellor_order_id,$row->id,$sellor, '0',$row->amount,$row->c2,'Success','Trade']);
   
   
   
    
   
// MARK ORDER COMPLETE

$affected = DB::update("update exchange_bookings  set status = 'complete' where id =".$row->id." or id =".$sellor_order_id);
 
 
    
 DB::insert("insert into exchange_rate_sale (pair, rate) values (?, ? )", [ $row->pair,$row->rate]);
     
//print_r($row);

}

         
      // fetch find sellor of same qty 
      
      // do debit from his account  and credit to user account
      
      // mark order complete
        
    }
    
    
    

 public function FinishTradeBuyOrder( $buyer,$qty,$pair ,$buyer_order_id)
    { 
        
/*
$buyer="susheel3010";


$qty="1";   
  $pair="btcusd"; 
  $buyer_order_id=12;
  */
  
   
  
    $trans = DB::select("select * from exchange_bookings where pair =  '".$pair."' and quantity='".$qty."' and type='sell' and Status='Pending'     order by id desc limit 1");
         


foreach ($trans as $row) {
  
   
   
   DB::delete("delete from exchange_orders where sellor_order_id=".$row->id." and  buyer_order_id= ".$buyer_order_id."");
   
   
   
   //bitcoin transfer 
   
   // SELLOR
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,cr,dr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$row->id,$buyer_order_id,$row->user_id,'0',$qty,'BTC','Success','Trade']);
   
   
   
   //BUYER
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,cr,dr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$row->id,$buyer_order_id,$buyer,$qty,'0','BTC','Success','Trade']);
   
   
  
// usd transfer 


   // SELLOR
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,cr,dr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$row->id,$buyer_order_id,$row->user_id,$row->amount,'0','USD','Success','Trade']);
   
   


   //BUYER 
   DB::insert("insert into exchange_orders (sellor_order_id, buyer_order_id,  user_id,cr,dr,coin,status ,type) values (?, ?,?, ?, ?,?, ?,?)", [$row->id,$buyer_order_id,$buyer, '0',$row->amount,'USD','Success','Trade']);
   
   
   
    
   
// MARK ORDER COMPLETE

$affected = DB::update("update exchange_bookings set status = 'complete' where id =".$row->id." or id =".$buyer_order_id);
 
 
 
 DB::insert("insert into exchange_rate_buy (pair, rate) values (?, ? )", [ $row->pair,$row->rate]);
}

         
      // fetch find sellor of same qty 
      
      // do debit from his account  and credit to user account
      
      // mark order complete
   
   
  
   
   
        
    }

 public function FinishTradeSellOrderTest(  )
    { 
        
        $sellor=26;
        $qty=10;
          $pair="btcUSD";
          $sellor_order_id="7";
          $this->FinishTradeSellOrder($sellor,$qty,  $pair,  $sellor_order_id  );
        
    }
    
    
    
    
     

}
