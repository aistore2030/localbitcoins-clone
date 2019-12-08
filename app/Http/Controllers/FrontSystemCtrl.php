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



class FrontSystemCtrl extends Controller
{
    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
        
           
            
            
    }
 
 
 public function logout () {
    //logout user
    auth()->logout();
    // redirect to homepage
    return redirect('/');
}


public function login()
    {
        
         
        $view = View::make('system.login' ) ;
 

    return $view;  
       
    }
    
    
    public function register()
    {
        $view = View::make('system.register' ) ;
 

    return $view; 
       
    }
    
   
 
 
    
function   btcdeposit(){
   
   
 
    $user_id=$_REQUEST['user_id'];
    
    $confirmations=$_REQUEST['confirmations'];
$secret=$_REQUEST['secret'];
$transaction_hash=$_REQUEST['transaction_hash'];
$value=$_REQUEST['value'];
$address=$_REQUEST['address'];

$value=$value * 0.00000001;

$hit_url=$_SERVER['HTTP_HOST'] ."/". $_SERVER['REQUEST_URI'];



   DB::delete("delete from system_transactions where transaction_hash ='". $transaction_hash."'");
  
  
    
     DB::table('system_transactions')-> Insert(
    ['status'=> "Success",'user_id' => $user_id ,'confirmations' => $confirmations , 'coin' => 'BTC', 'dr' => '0', 'cr' => $value,'transaction_hash' => $transaction_hash ,'hit_url' => $hit_url , 'address' => $address ,  'dump' => print_r($_REQUEST,true)]
);



DB::table('system_transactions_backup')-> Insert(
    ['status'=> "Success",'user_id' => $user_id ,'confirmations' => $confirmations , 'coin' => 'BTC', 'dr' => '0', 'cr' => $value,'transaction_hash' => $transaction_hash , 'address' => $address , 'hit_url' => $hit_url ,  'dump' => print_r($_REQUEST,true)]
);



   $confirmations=$confirmations+1;
  
    //echo json_encode( $trans);
     
 if ($_GET['confirmations'] >10)
  {
 echo '*ok*';
 exit();
  }
  
  print_r($_REQUEST);
  
echo   $this->UserBalance(  "Bitcoin",$user_id);
 
}

function getXpub( )
{


 
  
        
 
}

 
function setBtcAddress($user_id )
{
      

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
    
    
      public function ProcessBonus()
    {
         
         $users = (new User)->get(null, null, 20, true); 
         
     
       
  $coins=  DB::table('exchange_orders') ->select('coin')->distinct()->get();
       
        
       
         foreach($users as $u)
         {   foreach($coins as $c)
         {   $coin=$c->coin;
            $date = date('Y-m-d');
             $cr= $this->UserBalance($coin,$u->id)* Config::get('settings.bonus')/100;
            
             DB::table('system_transactions')
     ->where('user_id', '=',$u->id)
     ->where('coin', '=',$coin)
     ->where('dt', '=', $date)->delete();
            
    DB::table('system_transactions')->insertOrIgnore(
    ['user_id' => $u->id, 'coin' =>   $coin,'cr' =>    $cr, 'dt' => $date]
);

          echo " <br /> Processed for the user id ".$u->id." and coin ".$coin.PHP_EOL; 
            
             
         }
             
         }
    
    
    }
          
            
}