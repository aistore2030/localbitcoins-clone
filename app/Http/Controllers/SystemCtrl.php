<?php


namespace App\Http\Controllers;

 
use App\Page;
use View;
use MetaTag; 

use App\ChargeCommision;
use App\Income;
use App\MemberExtra;
use App\Deposit;
use App\Gateway;
use App\Lib\GoogleAuthenticator;
use App\Transaction;
use App\User;
use Config;
use App\Coins;

use App\Exchange_deposit;

use App\Exchange_widthdraw;
use App\Exchange_bookings;
use Illuminate\Support\Facades\DB;

 
use App\Http\Controllers\Controller;


use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;



class SystemCtrl extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        
            $this->middleware(['auth' ,'verified'] );
            
            
    }
 
 
 


    
   
 
 
    
    

function getXpub( )
{


 
 
 $qr="select xpub ,n from (SELECT count(address) n, xpub FROM `exchange_btcaddress` GROUP by xpub ) t WHERE n < 12 order by n desc limit 1 ";
 
 
  $xp = DB::select($qr) ;

return  $xp[0]->xpub;


        
 
}

function getBtcAddress( )
{
    
 
 $user_id= Auth::user()->id;
    
     
    $deposit_address = DB::table('deposit_address')->where('user_id', $user_id)->count();
    
    
   
   if( $deposit_address==0)
   {
 
 
        $this->setBtcAddress($user_id );
   
   }
  
   $data=   DB::table('deposit_address')->where('user_id', $user_id)->where('coin', "Bitcoin")->get()->first(); 
  
  return $data->address ;	
}

function setBtcAddress($user_id )
{
     
 
 $secret = 'ZzsMLGZzsMLGKe162CfA5EcG6jKe162CfA5EcG6j';

$my_xpub = $this->getXpub( );// Config::get('settings.bitcoin');
 
 
$my_api_key = '36276ce3-16c5-471d-bcfd-ac143bfeccd2';


$invoice=date("MdYhisA").$user_id;

$hit_url=$_SERVER['HTTP_HOST'] ."/". $_SERVER['REQUEST_URI'];




$my_callback_url ="https://". $_SERVER['HTTP_HOST'] ."/system/btcdeposit?invoice_id=".$invoice."&user_id=".$user_id."&secret=".$secret;
 

$root_url = 'https://api.blockchain.info/v2/receive';

$parameters = 'xpub=' .$my_xpub. '&callback=' .urlencode($my_callback_url). '&key=' .$my_api_key;

 
 $call=$root_url . '?' . $parameters;
 
 
$response = file_get_contents( $call);
 //var_dump( $call);
$object = json_decode($response);


DB::table('deposit_address')->insert(['coin'=>"Bitcoin", 'user_id' => $user_id, 'address' => $object->address,'url_hit' => $call ,'url_res' =>$response ]);

 
 DB::table('exchange_btcaddress')->insert(['xpub'=>$my_xpub , 'user_id' => $user_id, 'address' => $object->address ]);

 
 
     
  return $object->address ;		    


}

     
    
    
    public function index()
    {
  
 
 
            $user_id=  Auth::user()->id;
            
            
            $coins = array();
            
            
                 
        $coin  = array("name"=>"Bitcoin",
        "Balance"=> $this->UserBalance(  "BTC",$user_id), 
          "BalanceUSD"=> $this->UserBalanceinUSD(  "BTC",$user_id),
         "Symbol"=>"BTC",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("BTC"),    
         "deposit"=> $this->getBtcAddress( ),
         "withdraw"=>""
           );  
                 
    array_push($coins,$coin);
                 
       
       
           $coin  = array("name"=>"Ether",
        "Balance"=>$this->CoinsMaster("ETH"),
         "BalanceUSD"=> $this->UserBalanceinUSD(  "ETH",$user_id),
             "Symbol"=>"ETH",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("ETH"),   
         "deposit"=>Config::get('settings.Ether'),
         "withdraw"=>" "
           );  
                  
    array_push($coins,$coin);
                 
       
       
           $coin  = array("name"=>"XRP",
        "Balance"=>$this->CoinsMaster("XRP"),  
        
             "Symbol"=>"XRP",
                 "BalanceUSD"=> $this->UserBalanceinUSD(  "xrp",$user_id),
             
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("XRP"),    
         "deposit"=>Config::get('settings.XRP'),
         "withdraw"=>" "
           );  
                  
    array_push($coins,$coin);
                 
         
                 
                 
                  
           $coin  = array("name"=>"Litecoin",
        "Balance"=>$this->CoinsMaster("LTC"),     
        "BalanceUSD"=> $this->UserBalanceinUSD(  "LTC",$user_id),
         "Symbol"=>"LTC",  
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("LTC"),     
         "deposit"=>Config::get('settings.Litecoin'),
         "withdraw"=>" "
           );  
                  
    array_push($coins,$coin);
    
    
    
           $coin  = array("name"=>"USD",
        "Balance"=>$this->CoinsMaster("USD"),   
        //  "BalanceUSD"=> $this->UserBalanceinUSD(  "USD",$user_id),
         "Symbol"=>"USD",  
          "Market Value"=>"0.00",
          "Credit Line"=>"0.00",   
         "deposit"=>Config::get('settings.USD'),
         "withdraw"=>" "
           );  
                  
  //  array_push($coins,$coin);
    
    
    
           $coin  = array("name"=>"Stellar",
        "Balance"=>$this->CoinsMaster("Stellar"),   
           "BalanceUSD"=> $this->UserBalanceinUSD(  "Stellar",$user_id),
         "Symbol"=>"Stellar",  
          "Market Value"=>"0.00",
          "Credit Line"=>"0.00",   
         "deposit"=> Config::get('settings.Stellar') ,
         "withdraw"=>" "
           );  
                  
    array_push($coins,$coin);
    
     
     $coin  = array("name"=>"Bitcoin Cash",
        "Balance"=>$this->CoinsMaster("BCH"), 
           "BalanceUSD"=> $this->UserBalanceinUSD(  "BCH",$user_id),
         "Symbol"=>"BCH",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("BCH"),    
         "deposit"=>Config::get('settings.BCH'),
         "withdraw"=>""
           );  
           
           
           
    array_push($coins,$coin);
    
   
     
     $coin  = array("name"=>"Dash",
        "Balance"=>$this->CoinsMaster("DASH"),   
           "BalanceUSD"=> $this->UserBalanceinUSD(  "DASH",$user_id),
         "Symbol"=>"DASH",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("DASH"),    
         "deposit"=>Config::get('settings.Dash'),
         "withdraw"=>""
           );  
           
           
           
           
    array_push($coins,$coin);     
     $coin  = array("name"=>"QTUM",
        "Balance"=>$this->CoinsMaster("QTUM"),  
          "BalanceUSD"=> $this->UserBalanceinUSD(  "QTUM",$user_id),
         "Symbol"=>"QTUM",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("QTUM"),    
         "deposit"=>Config::get('settings.QTUM'),
         "withdraw"=>""
           );  
           
           
                      
    array_push($coins,$coin);     
     $coin  = array("name"=>"NEO",
        "Balance"=>$this->CoinsMaster("NEO"), 
        "BalanceUSD"=> $this->UserBalanceinUSD(  "NEO",$user_id),
         "Symbol"=>"NEO",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("NEO"),    
         "deposit"=>Config::get('settings.NEO'),
         "withdraw"=>""
           );  
           
           
           
           
           
                          
    array_push($coins,$coin);     
     $coin  = array("name"=>"TUSD",
        "Balance"=>$this->CoinsMaster("TUSD"), 
            "BalanceUSD"=> $this->UserBalanceinUSD(  "TUSD",$user_id),
         "Symbol"=>"TUSD",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("TUSD"),    
         "deposit"=>Config::get('settings.TUSD'),
         "withdraw"=>""
           );  
           
           
           
                                    
    array_push($coins,$coin);     
     $coin  = array("name"=>"Zcash",
        "Balance"=>$this->CoinsMaster("Zcash"),  
            "BalanceUSD"=> $this->UserBalanceinUSD(  "Zcash",$user_id),
         "Symbol"=>"Zcash",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("Zcash"),    
         "deposit"=>Config::get('settings.Zcash'),
         "withdraw"=>""
           );  
           
           
           
           
                
                                    
    array_push($coins,$coin);     
     $coin  = array("name"=>"Tether",
        "Balance"=>$this->CoinsMaster("Tether"),
         "BalanceUSD"=> $this->UserBalanceinUSD(  "Tether",$user_id),
         "Symbol"=>"Tether",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("Tether"),    
         "deposit"=>Config::get('settings.Tether'),
         "withdraw"=>""
           );  
           
           
                
                                    
    array_push($coins,$coin);     
     $coin  = array("name"=>"Binance",
        "Balance"=>$this->CoinsMaster("Binance"),
              "BalanceUSD"=> $this->UserBalanceinUSD(  "Binance",$user_id),
         "Symbol"=>"Binance",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("Binance"),    
         "deposit"=>Config::get('settings.Binance'),
         "withdraw"=>""
           );  
           
           
           
                
                                    
    array_push($coins,$coin);     
     $coin  = array("name"=>"TRON",
        "Balance"=>$this->CoinsMaster("TRON"),  
            "BalanceUSD"=> $this->UserBalanceinUSD(  "TRON",$user_id),
         "Symbol"=>"TRON",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("TRON"),    
         "deposit"=>Config::get('settings.TRON'),
         "withdraw"=>""
           );  
           
           
                                    
    array_push($coins,$coin);   
    
     $coin  = array("name"=>"USDC",
        "Balance"=>$this->CoinsMaster("USDC"),   
        "BalanceUSD"=> $this->UserBalanceinUSD(  "USDC",$user_id),
         "Symbol"=>"USDC",
          "Market Value"=>"0.00",
          "Credit Line"=>$this->getCreditLimit("USDC"),    
         "deposit"=>Config::get('settings.USDC'),
         "withdraw"=>""
           );  
           
           
    array_push($coins,$coin);
    
   
   
 // print_r($coins);
   
   
           
   $user = Auth::user();
  
  
     $view = View::make('system.index',  compact(['coins', 'user'])) ;
 

     return $view;  
    }
    
    
     
    public function getCreditLimit($coin)
    {
        
        
        $balance=$this->CoinsMaster($coin);
        
        return $balance*0.8;
    }
    
    public function CoinsMaster($coin)
    {
            
 
    $user_id=  Auth::user()->id;
    
         $data = DB::table('system_transactions')
                     ->select(DB::raw('sum(cr) - sum(dr) as balance '))
                     ->where('status', '<>', 1)
                        ->where('coin', $coin)
                         ->where('user_id', $user_id)
                        ->get();
                     
      return    $data[0]->balance;   
    
    }
    
    
      public function UserBalance($coin,$user_id)
    {
         
  
         $data = DB::table('system_transactions')
                     ->select(DB::raw('sum(cr) - sum(dr) as balance '))
                     ->where('status', '=', "Success")
                        ->where('coin', $coin)
                         ->where('user_id', $user_id)
                        ->get();
     
                     
      //return $data[0]->balance * 0.00000001;  
      
     
          return  number_format($data[0]->balance  ,10);
            
    
    }
    
    
      public function UserBalanceinUSD($coin,$user_id)
    {
            
  
         $data = DB::table('system_transactions')
                     ->select(DB::raw('sum(cr) - sum(dr) as balance '))
                     ->where('status', '=', "Success")
                        ->where('coin', $coin)
                         ->where('user_id', $user_id)
                        ->get();
     
                     
      //return $data[0]->balance * 0.00000001;  
      
     $vusd=$this->GetTValue( $coin,"USD",$data[0]->balance);
     
     return  $vusd;
    //      return  number_format($vusd  ,3);
            
    
    }
    
      
  public function GetTValue( $c1,$c2,$total)
    {
        
         
           $call=  "https://api-pub.bitfinex.com/v2/tickers?symbols=ALL";
          
         $response =json_decode( file_get_contents( $call));
          
          
        
foreach($response as $r)
 
      {
        
          
          if($r[0]=="t".$c1.$c2)
             return $r[1]*$total;
        
          
          
          
      }
       return "0";
    } 
    
    
   
   
              
         public function LedgetTransactions()
{ 
    
    $user_id= Auth::user()->id;
 $data=DB::table('system_transactions')->where('user_id',$user_id)->orderBy('id', 'desc')->get()  ;
      
 //  print_r($data);
      
 return view('system.Transactions'   ,['data' => $data]);
    
}      

public function postdeposits(Request $r)
{
   $r->coin="BTC";
   
    $s=strtolower($r->coin);
    
    if($s=="btc")
  {  $deposit=  $this->getBtcAddress( );
    
    $user_id= Auth::user()->id;
     
     
     
     $id = DB::table('exchange_deposit')->insertGetId(
    [ 'user_id' => $user_id ,'coin' => $r->coin ,'deposit_address' => $deposit ,'amount' => $r->amount ]
);
 
  }
   else {  $deposit=   "";
   
   
     $id = DB::table('exchange_deposit')->insertGetId(
    [ 'user_id' => $user_id ,'coin' => $r->coin ,'deposit_address' => $deposit ,'amount' => $r->amount ]
);
 
   $q="https://5ktrade.com/public/deposit_1/cryptoapi/?user_id=".$user_id."&order_id=".$id."&amount=".$r->amount;
 
 $data=json_decode(file_get_contents(''.$q));
 
 
 
 DB::table('exchange_deposit')
            ->where('id', $id)
            ->update(['coin' => $data->coinlabel ,'deposit_address' => $data->addr ,'amount' => $data->amount]);
   
 
   }
 
   
 
  return redirect('/system/deposits/'.$id);
  
   
} 




public function postwidthdraw(Request $r)
{ 
    
    $user_id= Auth::user()->id;
  
      $max= $this->UserBalance( $r->coin,$user_id);
      
      if($max > $r->amount) {
          
          
      
      
            
     $trid = DB::table('system_transactions')->insertGetId(
    [ 'user_id' => $user_id ,'coin' => $r->coin ,'cr' => 0 ,'dr' => $r->amount,'status' =>"Success" ,'descriptioin' =>"Widthdraw Request "    ]
);

     
            
     $id = DB::table('exchange_widthdraw')->insertGetId(
    [ 'user_id' => $user_id ,'coin' => $r->coin ,'amount' => $r->amount,'widthdraw_address' => $r->widthdraw_address  ]
);



 
   return redirect('/system/widthdraw/'.$id);
      }
      else
      {
        $msg ="Insufficient balance. Max avaialble balance is ".$r->coin ." ".  $max;
        
         
 return view('system.message'   ,['data' => $msg]);
   
   
      }
      
     
 
   
   
   
}


public function getwidthdraw()
{ 
    
    
    $user_id= Auth::user()->id;
 $data=DB::table('exchange_widthdraw')->where('user_id',$user_id)->orderBy('id', 'desc')->get()  ; 
      
 return view('system.widthdraw'   ,['data' => $data]);
    
}   
 

public function getdeposits()
{  
   
    
   $user_id= Auth::user()->id;
 $data=DB::table('exchange_deposit')->where('user_id',$user_id)->orderBy('id', 'desc')->get()  ;
  
  
 
      
 return view('system.deposits'   ,['data' => $data]);
    
}   
public function getwidthdrawbyid($i)
{  
    $user_id= Auth::user()->id;
 $data=DB::table('exchange_widthdraw')->where('user_id',$user_id)->orderBy('id', 'desc')->first()  ; 
      
 return view('system.widthdraw_details'   ,['data' => $data]);
    
}   
 

public function getdepositsbyid($i)
{ 
   
    
     
    $user_id= Auth::user()->id;
 $data=DB::table('exchange_deposit')->where('user_id',$user_id)->where('id',$i)->orderBy('id', 'desc')->first()  ;
      
  
  
  return view('system.deposit_detail'   ,['data' => $data]);
    
}   
            
}