<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Page;
use Auth;
use App\System_Deposit;
use App\Exchange_widthdraw;
use App\System_transactions;
use App\Exchange_g2f ;

use DB;
use App\User;
class AdminController extends Controller

{

    /**

     * Create a new controller instance.

     *

     * @return void

     */ 
    public function __construct( Request $request)

    {$this->request = $request;

        $this->middleware('auth:admin');

    }

    /**

     * show dashboard.

     *

     * @return \Illuminate\Http\Response

     */

 
 public function autoLoginbyID($id)
    {
        
         
	   
	   
Auth::guard('web')->loginUsingId($id);
 
 
  $user_id= Auth::guard('web')->user()  ;
  
  
 //var_dump($user_id); 
 
 
  
  return redirect('system/account');
   
   
	   }



    public function dashboard()
    {
        
 
         isset($_GET['q']) ? $term = $_GET['q'] : $term = '';
/*  
     if($term) {
         $users = (new User)->get('users.name LIKE ?', '%' . $term . '%', 20, true);
        } else {
            $users = (new User)->get(null, null, 20, true);
        }*/
        $users = DB::table('users')->orderBy('id','desc')->get();
     
    // print_r($users);

     $total_users = DB::table('users')->count();

        return view('backend.dashboard')
            ->with('users', $users)
            ->with('total_users', $total_users)
            ->with('term', $term);
    }

    public function index()
    {
        
 
         isset($_GET['q']) ? $term = $_GET['q'] : $term = '';
/*  
     if($term) {
         $users = (new User)->get('users.name LIKE ?', '%' . $term . '%', 20, true);
        } else {
            $users = (new User)->get(null, null, 20, true);
        }*/
        $users = DB::table('users')->orderBy('id','desc')->get();
     
    // print_r($users);

     $total_users = DB::table('users')->count();

        return view('backend.users.index')
            ->with('users', $users)
            ->with('total_users', $total_users)
            ->with('term', $term);
    }

    public function delete()
    {
        DB::table('users')
            ->where('id', $this->request->route('id'))
            ->delete();

        DB::table('comments')
            ->where('user_id', $this->request->route('id'))
            ->delete();

        return redirect()->route('backend.users')->with('status', 'success')->with('message', 'User successfully deleted!');
    }
    
        
 public function editprofile ($id)
    {
 
       $user = User::find($id);
       
       
            $user->dailybonus =    $this->request['dailybonus'];
              
                    
       
            $user->widthdrawal = (isset( $this->request['widthdrawal']) ? 1: 0);   ;
              
                 
            $user->save();
            
            
        return redirect('/admin/users/')->with('status', 'Updated successfully');
         
           
           
    }
   
public function profile($id)
    {
  $user = User::find($id);
  
  
  
          return view('backend.users.profile')
           ->with('user', $user); 
           
           
           
  
     //$view = View::make('backend.users.profile',  compact([ 'user'])) ;
 

   // return $view; 
    }
     public function getg2fall()
    {
       



$exchange_g2f = Exchange_g2f::all();

        return view('backend.system.g2f')
            ->with('exchange_g2f', $exchange_g2f);
    }
    
     public function g2fdelete($email )
    {
       
        $deletedRows = Exchange_g2f::where('email', $email)->delete();
        
       // echo "";
        return redirect('/admin/g2f')->with('status', 'Deleted for the username '.$email);
    }
    
 public function getCoins()
    {
      $user_id= Auth::user()->roles ;
           
         
         if ($user_id < 10 ) {
    
 
   return redirect()->back()->with('success', ['Please login with admin password']);   
   exit(1);
}  $roles = Role::all();

        return view('backend.system.index')
            ->with('roles', $roles);
    }
    
    
    
 public function alldeposits()
    {
        $deposits = System_Deposit::all();

        return view('backend.system.deposits')
            ->with('deposits', $deposits);
    }
    
    
      public function depositsdetails($id)
    { 
        
        $deposit = System_Deposit::where('id', '=',$id)->firstOrFail();
       // return $deposit;
        
        
        
          return view('backend.system.deposit_details')
           ->with('deposit', $deposit);
    }
    
    
    
     public function allwidthdraw()
    {     
         
           $widthdraw = Exchange_widthdraw::all()->sortByDesc('id');

        return view('backend.system.widthdraw')
            ->with('widthdraw', $widthdraw);
    }
    
       public function widthdrawdetails($id)
    {
        
        $widthdraw = Exchange_widthdraw::where('id', '=',$id)->firstOrFail();
        
          return view('backend.system.widthdraw_details')
           ->with('widthdraw', $widthdraw);
    }
    
    public function updatewidthdraw($id )
    {
        
        
         $widthdraw = Exchange_widthdraw::where('id', '=',$id)->firstOrFail();
         
      
 

$widthdraw->status ="Processed";

$widthdraw->description = $this->request->input('description') ;
 
$widthdraw->widthdraw_transaction_id = $this->request->input('widthdrawtransactionid') ;

$widthdraw->save();
 
  
       return view('backend.system.widthdraw_details')
        ->with('widthdraw', $widthdraw);
         
           
           
    }
    
    
    
    public function alltransactions()
    {
         
 
        $transactions = System_transactions::all()->sortByDesc('id');

        return view('backend.system.transactions')
            ->with('transactions', $transactions); 
    }
    
    
    
    
      public function transactionsdetails($id)
    { 
        
          
        $transaction = System_transactions::where('id', '=',$id)->firstOrFail();
        
          return view('backend.system.transaction_details')
           ->with('transaction', $transaction); 
    }
    
    
    
    
    
    
    

}