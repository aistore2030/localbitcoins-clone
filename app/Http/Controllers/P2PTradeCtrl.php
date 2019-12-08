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


class P2PTradeCtrl extends Controller
{
    
    
    public function __construct(Request $request) {
        $this->request = $request;
   
        $this->middleware(['auth' ]);
    }

    public function posttrade ()
    {
        return view('Localbitcoins.posttrade');
    }
 
 
 
  public function getratec1 ($id,$c1value)
    {
         
       
        $data = P2PTrade::findOrFail($id);
        
        
        $data->rate= $data->margin*   $this->ExRate("",$data->currency)/100 +$this->ExRate("",$data->currency);
        
       
        
   return    $c1value /  $data->rate ;
        
    }
    
    
    
 
  public function getratec2 ($id,$c1value)
    {
         
        
        $data = P2PTrade::findOrFail($id);
        
        
        $data->rate= $data->margin*   $this->ExRate("",$data->currency)/100 +$this->ExRate("",$data->currency);
        
        
        
    return    $data->rate * $c1value;
        
    }
    
    
    
    
    
    
    public function startTrade ($id)
    {
        
        $data = P2PTrade::findOrFail($id);
        
        
        $data->rate= $data->margin*   $this->ExRate("",$data->currency)/100 +$this->ExRate("",$data->currency);
      
   return view('Localbitcoins.trade',compact('data'));
        
        
    }
    
    
    
    public function  mark_payment_as_paid ( $id )
    {
          $po = P2p_orders::findOrFail($id);
       
      
      if($po->trade->trade_type=="ONLINE_BUY")
      {
                 if($po->user_id ==  Auth::user()->id)
              {
                       $po->status =  "PaymentCompleted";
                    $save =     $po->save();
        
                       return back()->with('success','Payment marked paid.');
              } 
       
      }
      
      else 
      {
               if($po->trade->user_id ==  Auth::user()->id)
              {
                       $po->status =  "PaymentCompleted";
                    $save =     $po->save();
        
                       return back()->with('success','Payment marked paid.');
              } 
          
          
      }
       
        
    } 
    
      public function  dispute_trade ( Request $request )
    {
          $po = P2p_orders::findOrFail($request['trade_order_id']);
       
        $po->status =  "Disputed";
       
    
     $save =     $po->save();
        
        
          
         return back()->with('success','Your transaction started.');
        
        
        
        
        
    } 
    
    
    
    public function all_trades()
    {
        
$data_user_id = P2p_orders::where('user_id',  Auth::user()->id) ->get();



$data_trade_user_id = P2p_orders::where('trade_user_id',  Auth::user()->id) ->get();



       return view('Localbitcoins.trade_order_list',compact('data_user_id','data_trade_user_id'));
    
      
      
    
          
    }
    
    public function  leave_feedback  ( Request $request )
    {
         
$pf = p2p_feedbacks::where('id', '=', $request['feedback_id'])
->where('user_id','=', Auth::user()->id)
->where('trade_order_id','=', $request['trade_order_id'])
->delete();
        
        
          $st = new p2p_feedbacks;
        
        
        $st->user_id = Auth::user()->id;
        
        
        $st->username = Auth::user()->username;
                
        $pt = P2PTrade::findOrFail($request['trade_id']);
 
   

$po = P2p_orders::where('id', '=', $request['trade_order_id'])
->where('status',  'Success')->firstOrFail();
        
        
         $st->feedback_user_id =$pt->user_id;
        
        $st->trade_order_id = $po->id; 
        $st->trade_id =$po->trade_id; 
       
            
       
           $st->message =  $request['message']; 
           
           
           $st->feedback =  $request['feedback']; 
         
        
        
        $save =    $st->save();
        
        
        
         $po->feedback_id =  $st->id;
       
    
      $po->save();
      
          
         return back()->with('success','Your feedback submitted successfully.');
        
        
        
        
    }
    
    
    public function transferbtc($u1,$u2,$v,$invoice_id)
    {
        
       
            $st = new system_transactions;
       
       
        $st->user_id =$u1;
        
        
        $st->cr =0;
       
             $st->dr = $v;
       
             $st->coin ="BTC";
       
           $st->status =  "Escrow";
       
             $st->invoice_id = $invoice_id;
       
             $st->description ="P2P Trade order id ".$invoice_id;
         
        
        
        $save =    $st->save();
        
          $st1 = new system_transactions;
      
          $st1->user_id =$u2;
       
        
        $st1->dr =0;
       
             $st1->cr = $v;
       
       
             $st1->coin ="BTC";
       
           $st1->status =  "Escrow";
       
            $st1->invoice_id = $invoice_id;
       
             $st1->description =  "P2P Trade order id ".$invoice_id;
         
        
        
        $save =    $st1->save();
        
         
        
     
    }
    
    public function  release_coin ( Request $request )
    {
         
        
 $po = P2p_orders::where('id', '=', $request['trade_order_id'])->where('status','<>', 'Success')->firstOrFail();

 $lid=Auth::user()->id;
 
     if( ($po->trade->user_id==$lid ) or  ( $po->user_id== $lid) )
    
    {
        
        system_transactions::where('status',"Escrow")
          ->where('invoice_id',"TRADE".$po->id)
          ->update(['status' => "Success"]);
          
          
           
     }
          
       
            
       echo '<script type="text/javascript">'
			   , 'history.go(-2);'
			   , '</script>';
    
       
        
    } 
    public function get_release_coin ($id )
    {
        
        
          
       //  $data = P2P_orders_discussion::where('trade_order_id', $id)
        //       ->orderBy('created_at', 'desc')
        //      ->get(); 
        
     
        
    $po = P2p_orders::findOrFail($id);
        
              
        $pt = P2PTrade::findOrFail($po->trade_id);
       
       return view('Localbitcoins.release_coin',compact( 'pt','po'));
        
        
        
    }
    
    public function submit_process_trade_chats ( )
    {
        
        
         
        $data = new P2P_orders_discussion;
        $data->user_id = Auth::user()->id;
        
         
        $data->username = Auth::user()->username;
        
        
        $data->trade_id = $this->request['trade_id'];
         
        $data->trade_order_id = $this->request['trade_order_id'];
         
        
        $data->trade_message =$this->request['trade_message'];
         
         $save = $data->save();
        
   
       
 return back()->with('success',  'Message Sent Successfully' );
    
  
     
     
        
    }
    
    
    
    public function process_trade_order ($id)
    {
        
         $po  = P2p_orders::where('id', $id)->permitionTo( Auth::user()->id)->firstOrFail();
        
  if($po->trade->trade_type=="ONLINE_BUY")
      {
      
           return redirect('/p2p/process_trade_sell/'.$po->id) ;
        
      }
       if($po->trade->trade_type=="ONLINE_SELL")
      {
              
           return redirect('/p2p/process_trade_sell/'.$po->id) ;
    }
  
  
  
    }
    
    
    public function process_trade_buy ($id)
    {
        
        
        
        
      
       $po  = P2p_orders::where('id', $id)->permitionTo( Auth::user()->id)->firstOrFail();
        
  if($po->trade->trade_type=="ONLINE_BUY")
      {
        $data = P2P_orders_discussion::where('trade_order_id', $id)
               ->orderBy('created_at', 'desc')
              ->get(); 
  return view('Localbitcoins.process_trade_buy',compact('data' , 'po'));
        
        
      }
    }
    public function process_trade_sell ($id)
    {
        
        
        
   
      
       $po  = P2p_orders::where('id', $id)->permitionTo( Auth::user()->id)->firstOrFail();
        
  if($po->trade->trade_type=="ONLINE_SELL")
      {
             $data = P2P_orders_discussion::where('trade_order_id', $id)
               ->orderBy('created_at', 'desc')
              ->get(); 
  return view('Localbitcoins.process_trade_sell',compact('data' , 'po'));
        
        
    }
    
    }
    
    
    
    
       
    public function ExRate($exchange,$cr)
    {
        $url="https://www.xpagg.com/ticket.json";
        
        $d=file_get_contents($url);
        $ar=json_decode($d);
        
        
          return $ar->$cr->rates->last ;
       
    }
    
    public function buy_bitcoins ()
    {
        
        
        $url="https://www.xpagg.com/ticket.json";
        
        $d=file_get_contents($url);
        $ar=json_decode($d);
        
        
        //print_r($ar);
        
     
     $TC=new TradeController();
        
        $data=array();
      $brate= $TC->GetTValue("buy","btc","USD","100");
        
        
    Session::put('buy_rate', $brate);
     
    
        $data1 = P2PTrade::all()->toArray();  
        
        foreach($data1 as $d)
        {
            
             $d['rate']= $this->getrate($ar,$d['currency'])+$d['margin']* $this->getrate($ar,$d['currency'])/100;
             
            
            
            array_push($data,$d);
        }
            
 return view('Localbitcoins.buy',compact('data'));
 
        
    }
    public function getrate($ar,$cr)
    {
        return $ar->$cr->rates->last ;
        
    }
    
    
    public function sell_bitcoins ()
    {
        $TC=new TradeController();
        
      $srate= $TC->GetTValue("Sell","btc","USD","100");
     // $brate= $TC->GetTValue("buy","btc","USD","100");
        
    Session::put('sell_rate', $srate);
   // Session::put('buy_rate', $brate);
     
    
        $data = P2PTrade::all()->toArray();  
            
        return view('Localbitcoins.sell',compact('data'));
        
      
        //return view('Localbitcoins.posttrade');
    }
    
    
    
     
    
    
    public function createtradeSell(Request $request)
    {
        
        
      
      
        $validator = Validator::make($request->all(),[
            
            'c1value' => 'required',
            'btcvalue' => 'required',
            'trade_message' => 'required|string',
            // 'ad-track_max_amount' => 'required'

        ],[
         
            'c1value.required' => 'This Currency value is required.',
            'btcvalue.required' => 'This Bitcoin Value field is required.',
            'trade_message.required' => 'This trade message field is required',
            // 'ad-track_max_amount.required' => 'This field is required'
        ]);

        if($validator->fails()){
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
        }
       
   
       
$pt = P2PTrade::where('id', '=', $request['trade_id'])
->where('status',  'Active')->firstOrFail();
        
         if($pt->user_id==Auth::user()->id)
         {
             
             return "Sorry you can not trade with your self";
         }
            
            
            
           if($pt->trade_type <> "ONLINE_SELL")
      {
         
         
          return "Some Technical Error".$pt->trade_type;
      }
      
      
        $data = new P2p_orders;
            
             $data->trade_id = $pt->id;
             
             
             $r=$this->ExRate("",$pt->currency);
             
          
             
             $data->rate =  $r+$pt->margin* $r /100;
            
            
         $data->trade_user_id= $pt->user_id;
      
        
        
        
         
        $data->user_id = Auth::user()->id;
        
        
        $data->username = Auth::user()->username;
        
        
        
        $data->c1value = $request['c1value'];
        
        
        
        
        $data->btcvalue = $request['btcvalue'];
        
        $data->trade_message = $request['trade_message'];
         
         
         
        
        
        $save = $data->save();
        
       
           ///////////////////
        $datam = new P2P_orders_discussion;
        $datam->user_id = Auth::user()->id;
        
         
        $datam->username = Auth::user()->username;
        
        
        $datam->trade_id = $pt->id;
         
        $datam->trade_order_id =$data->id;
         
        
        $datam->trade_message =$this->request['trade_message'];
         
        $save = $datam->save();
        
        
     if($save){ 
         
      
              
              $this->transferbtc(  $data->user_id,$data->trade->user_id,$data->btcvalue,"TRADE".$data->id);
              
               
               
            return redirect('/p2p/process_trade_sell/'.$data->id)->with('success','Your transaction started.');
               
           
       }
    }

    
    
    public function createtradeBuy(Request $request)
    {
        
        
      
      
        $validator = Validator::make($request->all(),[
            
            'c1value' => 'required',
            'btcvalue' => 'required',
            'trade_message' => 'required|string',
            // 'ad-track_max_amount' => 'required'

        ],[
         
            'c1value.required' => 'This Currency value is required.',
            'btcvalue.required' => 'This Bitcoin Value field is required.',
            'trade_message.required' => 'This trade message field is required',
            // 'ad-track_max_amount.required' => 'This field is required'
        ]);

        if($validator->fails()){
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
        }
       
   
       
$pt = P2PTrade::where('id', '=', $request['trade_id'])
->where('status',  'Active')->firstOrFail();
        
         if($pt->user_id==Auth::user()->id)
         {
             
             return "Sorry you can not trade with your self";
         }
            
            
            
           if($pt->trade_type <> "ONLINE_BUY")
      {
         
         
          return "Some Technical Error".$pt->trade_type;
      }
      
      
        $data = new P2p_orders;
            
             $data->trade_id = $pt->id;
             
             
             $r=$this->ExRate("",$pt->currency);
             
          
             
             $data->rate =  $r+$pt->margin* $r /100;
            
            
         $data->trade_user_id= $pt->user_id;
      
        
        
        
         
        $data->user_id = Auth::user()->id;
        
        
        $data->username = Auth::user()->username;
        
        
        
        $data->c1value = $request['c1value'];
        
        
        
        
        $data->btcvalue = $request['btcvalue'];
        
        $data->trade_message = $request['trade_message'];
         
         
         
        
        
        $save = $data->save();
        
       
           ///////////////////
        $datam = new P2P_orders_discussion;
        $datam->user_id = Auth::user()->id;
        
         
        $datam->username = Auth::user()->username;
        
        
        $datam->trade_id = $pt->id;
         
        $datam->trade_order_id =$data->id;
         
        
        $datam->trade_message =$this->request['trade_message'];
         
         
         
        
        
        $save = $datam->save();
        
        
     if($save){ 
         
      
              
              $this->transferbtc( $data->trade->user_id, $data->user_id,$data->btcvalue,"TRADE".$data->id);
              
               
               
            return redirect('/p2p/process_trade_buy/'.$data->id)->with('success','Your transaction started.');
               
               
          
      
  
      
       
 
 
 
       }
    }

     
    
    
    public function posttradesubmit(Request $request)
    {
        $validator = Validator::make($request->all(),[
            
            'ad-trade_type' => 'required',
            'ad-place' => 'required',
            'ad-bank_name' => 'required|string',
            // 'ad-track_max_amount' => 'required'

        ],[
         
            'ad-trade_type.required' => 'This trade type is required.',
            'ad-place.required' => 'This location field is required.',
            'ad-bank_name.required' => 'This bank name field is required',
            // 'ad-track_max_amount.required' => 'This field is required'
        ]);

        if($validator->fails()){
            return redirect()->back()
                    ->withInput($request->input())
                    ->withErrors($validator);
        }
        $days = array('sun_start' => $request['ad-opening_hours_0_0'],'sun_end' => $request['ad-opening_hours_0_1'],'mon_start' => $request['ad-opening_hours_1_0'],'mon_end' => $request['ad-opening_hours_1_1'],'tue_start' => $request['ad-opening_hours_2_0'],'tue_end' => $request['ad-opening_hours_2_1'],'wed_start' => $request['ad-opening_hours_3_0'],'wed_end' => $request['ad-opening_hours_3_1'],'thu_start' => $request['ad-opening_hours_4_0'],'thu_end' => $request['ad-opening_hours_4_1'],'fri_start' => $request['ad-opening_hours_5_0'],'fri_end' => $request['ad-opening_hours_5_1'],'sat_start' => $request['ad-opening_hours_6_0'],'sat_end' => $request['ad-opening_hours_6_1']);
        // print_r($days);die;
        $data = new P2PTrade;
        $data->user_id = Auth::user()->id;
        
        
        
        $data->username = Auth::user()->username;
        
        
        
        $data->trade_type = $request['ad-trade_type'];
        $data->trade_place = $request['ad-place'];
        $data->currency = $request['ad-currency'];
        $data->bank_name = $request['ad-bank_name'];
        $data->margin = $request['ad-commission'];
        $data->price_equation = $request['ad-price_equation'];
        $data->min_trans_limit = $request['ad-min_amount'];
        $data->max_trans_limit = $request['ad-max_amount'];
        $data->opening_hours =  implode(',', $days);
        $data->terms_of_trade = isset($request['ad-other_info']) ? $request['ad-other_info'] : "";
        $data->track_liquidity = isset($request['ad-track_max_amount']) ? $request['ad-track_max_amount'] : "0";
        $data->idenetity_people = isset($request['ad-require_identification']) ? $request['ad-require_identification'] : "0";
        $data->sms_verify = isset($request['ad-sms_verification_required']) ? $request['ad-sms_verification_required'] : "0";
        $data->trusted_people = isset($request['ad-require_trusted_by_advertiser']) ? $request['ad-require_trusted_by_advertiser'] : "0";
        $save = $data->save();
        if($save){
            return redirect('/home')->with('success','Your advertisement published successfully.');
        }
    }

}
