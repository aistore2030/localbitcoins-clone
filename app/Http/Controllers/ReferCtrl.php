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


use App\P2PTrade;

use App\P2p_orders;
use Validator;

use App\P2P_orders_discussion;

use App\System_transactions;


use App\p2p_feedbacks;


class ReferCtrl extends Controller
{
    
    
    public function __construct(Request $request) {
        $this->request = $request;
   
        $this->middleware(['auth' ]);
    } 



public function getPackages()
{
    
     $packages = array( 
             array (
               "invest" => 20,
               "name" => "Package one" 
            ),
            
              array (
               "invest" => 50,
              "name" => "Package two" 
            ),
            
          array (
               "invest" => 100,
                "name" => "Package three" 
            )
         );
         
      
          $package_name =Auth::user()->package_name;  
      
    Session::put('package_name', $package_name);
    
    
    
    return view('aff.packages'   ,['packages' => $packages]);
    
   
}




public function investnow( )

{
    
    
    $st = new system_transactions;
        $st->user_id =Auth::user()->id;   
        
        
        $st->cr =  0; 
       
             $st->dr = $this->request['plan']; 
       
             $st->coin = $this->request['payment_method']; 
             
             $st->invoice_id = "REG".time(); 
       
           $st->status =  "Success";
        
       
             $st->description =  "Registeration charges " ;
         
        
        
        $save =    $st->save();
        
        
 
 $this->awardreferincome( $this->request['plan'],  $this->request['payment_method'] );
 
 
 
  $user = User::find((Auth::user()->id));
       
       
            $user->package_name  =    $this->request['package_name'];
               
            $user->save();
            
            
            
       return redirect('/aff/up_earning');
}



private function creditearning($user_id,$amount,$r,$coin)

{
    
   // echo  $coin;
    
    $st = new system_transactions;
        $st->user_id =$user_id;
        
        
        $st->cr =$amount;
       
             $st->dr =0;
       
             $st->coin = $coin;    
             
             $st->invoice_id ="R".$r;
       
           $st->status =  "Success";
        
       
             $st->description =  "Referral income for the user registration with ID ".$r;
         
        
        
        $save =    $st->save();
        
        
        
        
}




public function test_awardreferincome()
{
 
 $amount=1000;
 $m=array(30,30,30);
 
 $this->awardreferincome($amount );
 
 
}


public function awardreferincome($amount,$coin )
{
 
  $id=  Auth::user()->id;   
  
  $m=array(30,30,30);
  
  $refer_id=  Auth::user()->refer_id;   
  
  
     $this->creditearning($refer_id,$amount*$m[0]/100, $id,$coin);
 
  
      //get direct referjj
    $user = DB::table('users')->where('id', $refer_id)->first();
//echo $user->refer_id;
 
 
   $this->creditearning($user->refer_id,$amount*$m[1]/100, $id,$coin);
 
 
    //get direct refer  level one
    $user1 = DB::table('users')->where('id',$user->refer_id)->first();
//echo $user1->refer_id;

 $this->creditearning($user1->refer_id,$amount*$m[2]/100, $id,$coin);
 
    //get direct refer  level two
   // $user2= DB::table('users')->where('id',$user1->refer_id)->first();
//echo $user2->refer_id;
 // $this->creditearning($user2->refer_id,$amount*$m[2]/100,  $id);

 
    //get direct refer  level three
  //  $user3= DB::table('users')->where('refer_id',$user2->refer_id)->first();

// $this->creditearning($user3->refer_id,$amount*$m[3]/100, $refer_id);
 
}




public function up_earning()
{  

 $refer_id=  Auth::user()->id;
      
// Session::put('refer_id', $refer_id);
   
 $wh ="  select * from system_transactions   where invoice_id= 'R".$refer_id. "'  ";
 //echo $wh;
 
 $trans = DB::select( $wh );
 
// var_dump( $trans);
    
    Session::put('pagetitle',  "Income from your joining");
    
  return view('aff.refersincome'   ,['trans' => $trans]);
    
    
}


public function ref_earning()
{  

 $id=  Auth::user()->id;
      
// Session::put('refer_id', $refer_id);
   
 $wh ="  select * from system_transactions   where invoice_id like 'R%'  and user_id=". $id;
 
 //echo $wh;
 
 $trans = DB::select( $wh );
 
// var_dump( $trans);
    
    Session::put('pagetitle',  "Your income from your referral");
    
  return view('aff.refersincome'   ,['trans' => $trans]);
    
    
}



public function getrefer()
{  
      $refer_id=  Auth::user()->id;
      
         Session::put('refer_id', $refer_id);
   
 $wh ="  select * from users   where refer_id= '".$refer_id. "'  ";
 $users = DB::select( $wh );
    
 return view('aff.refersusers'   ,['users' => $users]);
    
 
    
}

public function getreferbylevelid($i)
{
   
    
    $wh="";
    
    
      $refer_id=  Auth::user()->id;
   
         Session::put('refer_id', $refer_id);
   
   if($i >= 1 )   
     
     
      $wh ="  select id from users   where refer_id= '".$refer_id. "'  ";
       
      
           if($i >= 2 )   
      
       
      $wh  =" refer_id in (".$wh. " )";
       
      
      
      
             if($i >=  3 )   
      $wh  =" refer_id in (".$wh. " )";
       
       
             if($i >=  4 )   
      $wh  =" refer_id in (".$wh. " )";
      
      
       
            if($i >=  5 )   
      $wh  =" refer_id in (".$wh. " )";
      
      
       
         if($i >=   6 )   
      $wh=" refer_id in (".$wh. " )";
      
      
      
              if($i >=  7 )   
      $wh   =" refer_id in (".$wh. " )";
      
      
      $q="select * from users 
      where id in   ( " .$wh.")";
       
      // echo $q;
       
   $users = DB::select($q );
      
      
      
      
     
 return view('aff.refersusers'   ,['users' => $users]);
    
    
    
}



}
