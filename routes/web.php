<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

 //Route::get('/home', 'HomeController@profileIndex')->name('profile.index');
    
    
Route::get('home', 'SystemCtrl@index')->name('auth.profile');
 
Route::any('sendtologin', 'AuthController@systemlogin') ;
 

Route::any('sendtologin2', 'AuthController@systemlogin2') ;
 
 
//Auth::routes();

Auth::routes(['verify' => true]);
 
  
 
    
    Route::get('/profile/enableg2f', 'GoogleAuthCtrl@getenableg2f')->name('profile.enableg2f');
    
    Route::post('/profile/enableg2f', 'GoogleAuthCtrl@postenableg2f')->name('profile.enableg2f');
    
    
    Route::get('/profile/getQRCodeGoogleUrl', 'GoogleAuthCtrl@getQRCodeGoogleUrl')->name('profile.getQRCodeGoogleUrl');
    
    
    
    Route::get('/profile', 'HomeController@profileIndex')->name('profile.index');
    
    
    
    
Route::get('auth/profile', 'AuthController@profile')->name('auth.profile');

Route::post('auth/profile', 'AuthController@postprofile')->name('auth.profile');

Route::post('auth/changePassword','AuthController@postchangePassword')->name('auth.changePassword');





Route::get('/logout', 'FrontSystemCtrl@logout');




Route::get('system/bonusprocess','FrontSystemCtrl@ProcessBonus') ;


Route::prefix('aff')->group(function() {


// awardreferincome($amount,$m)
 
 
 
Route::get('packages','ReferCtrl@getPackages') ;


 
Route::post('investnow','ReferCtrl@investnow') ;




Route::get('refers','ReferCtrl@getrefer') ;

Route::get('up_earning','ReferCtrl@up_earning') ;


Route::get('ref_earning','ReferCtrl@ref_earning') ;

 
Route::get('testrefers','ReferCtrl@test_awardreferincome') ;

 
Route::get('refers/{i}','ReferCtrl@getreferbylevelid') ;


});
    
    
    
Route::prefix('background')->group(function() {


Route::get('dailybonus','BackgroundCtrl@dailybonus') ;



});
    


Route::prefix('system')->group(function() {


Route::get('btcdeposit','BackgroundCtrl@btcdeposit') ;





 Route::get('account','SystemCtrl@index')  ;


Route::get('widthdraw/{i}','SystemCtrl@getwidthdrawbyid') ;

Route::get('deposits/{i}','SystemCtrl@getdepositsbyid') ;


Route::get('widthdraw','SystemCtrl@getwidthdraw') ;
Route::post('widthdraw','SystemCtrl@postwidthdraw') ;

Route::get('deposits','SystemCtrl@getdeposits') ;
Route::post('deposits','SystemCtrl@postdeposits') ;

Route::get('transactions','SystemCtrl@LedgetTransactions') ;


Route::get('coins','SystemCtrl@CoinsMaster') ;



Route::get('Xpub','SystemCtrl@getBtcAddress') ;






 	});




    
 Route::get('/trade/{c1}/{c2}', 'TradeController@trade_theme_one')->name('user.manage') ;
 
  Route::any('store','P2PTradeCtrl@posttradesubmit');
  
  
Route::prefix('p2p')->group(function() {

        
 Route::get('postTrade', 'P2PTradeCtrl@posttrade')  ;
 
 	Route::get('getratec1/{id}/{c1value}','P2PTradeCtrl@getratec1');
 
 	Route::get('getratec2/{id}/{c1value}','P2PTradeCtrl@getratec2');
 
 	Route::post('postTrade','P2PTradeCtrl@posttradesubmit');
 	
 	
 	Route::get('store','P2PTradeCtrl@posttradesubmit');
 
 
 
 	Route::get('buy_bitcoins','P2PTradeCtrl@buy_bitcoins');
 
 
 	Route::get('sell_bitcoins','P2PTradeCtrl@sell_bitcoins');
 	
 	
 //	Route::get('CreateTrade','P2PTradeCtrl@createtradePost');
 
 	Route::get('CreateTradeBuy','P2PTradeCtrl@createtradeBuy');
 	Route::get('CreateTradeSell','P2PTradeCtrl@createtradeSell');
 
 
 	Route::get('trade/{id}','P2PTradeCtrl@startTrade');
 	
 	Route::get('all_trade','P2PTradeCtrl@all_trades');
 	
 	Route::get('tradeinfo/{id}','P2PTradeCtrl@process_trade_order');
 	
 	
 	
 //	Route::get('process_trade/{id}','P2PTradeCtrl@process_trade');
 	
 	
 	Route::get('process_trade_buy/{id}','P2PTradeCtrl@process_trade_buy');
 	
 	Route::get('process_trade_sell/{id}','P2PTradeCtrl@process_trade_sell');
 	
 	
 	Route::post('process_trade_chat','P2PTradeCtrl@submit_process_trade_chats');
 	
 	 	Route::get('release_coin/{id}','P2PTradeCtrl@get_release_coin'); 
 	 	
 	 	
 	 	
 	 	Route::post('release_coin','P2PTradeCtrl@release_coin');
 	 	
 	 	Route::get('mark_payment_as_paid/{id}','P2PTradeCtrl@mark_payment_as_paid');
 	 	
 	 	Route::post('dispute_trade','P2PTradeCtrl@dispute_trade');
 	
 	  	Route::post('leave_feedback','P2PTradeCtrl@leave_feedback');
 	
 	 
 
 
 	});
 
Route::prefix('exchange')->group(function() {

        
 Route::get('/Ticker', 'TickerController@GetTickerCoins')->name('user.manage') ;
 
    
     
   
 Route::get('/sending', 'RedirectManagementController@ipredirect')->name('user.manage') ;
   
     
      
 Route::get('/UserBalance', 'TradeController@getUserBalance')->name('user.manage') ;
 
 
 Route::get('/Withdraw_Fund_History', 'ExchangeCtrl@Withdraw_Fund_History')->name('user.manage') ; 
 
 
 
 Route::get('/Withdraw_Fund', 'ExchangeCtrl@Withdraw_Fund')->name('user.manage') ; 
 
 
 Route::post('/Withdraw_Fund', 'ExchangeCtrl@SubmitWithdraw_Fund')->name('user.manage') ; 
 
 
  Route::get('/deposit/{deposit_id}', 'ExchangeCtrl@getdepositdetails')->name('user.manage') ; 
  
  
 Route::get('/deposit', 'ExchangeCtrl@getBtcAddress')->name('user.manage') ; 
  
  Route::post('/deposit', 'ExchangeCtrl@getDepositSubmit')->name('user.manage') ; 
  
 
 
   Route::any('/deposit_history', 'ExchangeCtrl@getDepositList')->name('user.manage') ; 
  
 
 
 Route::get('/deposit/process', 'ExchangeCtrl@getBtcProcess')->name('user.manage') ; 
  
  
  
  
 Route::get('/transactions', 'ExchangeCtrl@LedgetTransactions')->name('user.manage') ; 
  
  
    
    
 Route::get('/tradeMarketBuy', 'TradeController@FinishTradeBuyOrderTest')->name('user.manage') ;
 
  Route::get('/tradeMarketSell', 'TradeController@FinishTradeSellOrderTest')->name('user.manage') ;
 
 
    
     
 
 

Route::get('/newsfeed', 'TradeController@newsfeed')->name('user.manage') ;


 Route::get('/ticker/{c1}/{c2}', 'TradeController@GetTicker')->name('user.manage') ; 
 
 
 Route::get('/tickerValueBuy/{c1}/{c2}/{total}', 'TradeController@GetTValueBuy')->name('user.manage') ; 
 
  Route::get('/tickerValueSell/{c1}/{c2}/{total}', 'TradeController@GetTValueSell')->name('user.manage') ; 
 
 
  
 Route::get('/tickerValueBuyR/{c1}/{c2}/{total}', 'TradeController@GetTValueBuyR')->name('user.manage') ; 
 
  Route::get('/tickerValueSellR/{c1}/{c2}/{total}', 'TradeController@GetTValueSellR')->name('user.manage') ; 
 
 
 
 Route::post('/tradeorder', 'TradeController@CreateTradeOrder')->name('user.manage') ; 
  
  
  
 Route::get('/trades/{type}/{c2}', function ($type,$c2) { 
      
      if($type=="buy")
      {
    return  response(DB::table('exchange_bookings')->where('pair',"BTC".$c2)->where('type',$type)->where('status',"Pending")->orderBy('rate', 'desc')->limit(5)->get()->toJson())->header('Content-Type', 'application/json');  
    
      }
      
      else
      {
          
          return  response(DB::table('exchange_bookings')->where('pair',"BTC".$c2)->where('type',$type)->where('status',"Pending")->orderBy('rate', 'asc')->limit(5)->get()->toJson())->header('Content-Type', 'application/json');  
    
      }
});



 Route::get('/owntrades', function () { 
      
      
    return  response(DB::table('exchange_bookings')->where('user_id', Auth::user()->id)->where('status',"Pending")->orderBy('id', 'desc')->limit(5)->get()->toJson())->header('Content-Type', 'application/json');  ;
});





Route::get('/ticker', 'TickerController@SelfDBTicker')->name('user.manage') ; 
  
  
  
  
Route::get('/ticker/buy', function () { 
      
      
    return  response(DB::table('exchange_rate_buy')->select("pair","rate")->where('pair',"BTCUSD")->orderBy('timest', 'desc')->limit(1)->get()->toJson())->header('Content-Type', 'application/json');  ;
});



Route::get('/ticker/sale', function () { 
      
      
    return  response(DB::table('exchange_rate_sale')->select("pair","rate")->where('pair',"BTCUSD")->orderBy('timest', 'desc')->limit(1)->get()->toJson())->header('Content-Type', 'application/json');  ;
});




 
  Route::get('/widthdraw_crypto', 'Trade_TransactionController@withdraw')->name('user.manage');
  
  
  
   
  
  
  

  	});





Route::prefix('admin')->group(function() {

   		Route::get('/login',

   		'Auth\AdminLoginController@showLoginForm')->name('admin.login');

   		Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');

   		Route::get('logout/', 'Auth\AdminLoginController@logout')->name('admin.logout');
 //Route::get('/', 'AdminController@allwidthdraw')->name('admin.dashboard');
    		
    // Route::post('/', 'AdminController@allwidthdraw')->name('admin.dashboard');
    		
    		
    				
    		
    		
    		
    		
  
  
    Route::get('/settings', 'AdminController@systemsettings') ;
	
    Route::get('/', 'AdminController@dashboard')->name('admin.dashboard') ;
	
	
  
Route::get('/autologin/{id}', 'AdminController@autoLoginbyID')->name('autologin');

 

  
  
    
    Route::get('/g2f', 'AdminController@getg2fall')->name('g2f');
    
       
    Route::get('/g2f/delete/{id}', 'AdminController@g2fdelete') ;
    
    
    Route::get('/deposits', 'AdminController@alldeposits')->name('deposits');
    
    
    
    Route::get('/deposits/{id}', 'AdminController@depositsdetails') ;
    
  //  Route::get('deposits_details', 'SystemCtrl@alldeposits')->name('deposits');
    
    
    
    Route::get('/widthdraw', 'AdminController@allwidthdraw')->name('widthdraw');
    
  Route::get('/widthdraw/{id}', 'AdminController@widthdrawdetails'  );
    
  Route::post('/updatewidthdraw/{id}', 'AdminController@updatewidthdraw'  );
    
    Route::get('/transactions', 'AdminController@alltransactions')->name('transactions');
    
      Route::get('/transactions/{id}', 'AdminController@transactionsdetails'  );
      
      
      
      
     
   
 //  Route::get('/users', 'AdminController@index');
    
   Route::get('/users', 'AdminController@index')->name('backend.users');
    
    
    Route::get('/users/add', 'AdminController@add')->name('backend.users.add');
    Route::post('/users/add', 'AdminController@addPost')->name('backend.users.add.post');
    
    Route::get('/users/edit/{id}', 'AdminController@edit')->name('backend.users.edit');
    
    
    Route::post('/users/profile/{id}', 'AdminController@editprofile')->name('backend.users.edit');
    Route::get('/users/profile/{id}', 'AdminController@profile')->name('backend.users.edit');
    
    Route::post('/users/edit/{id}', 'AdminController@editPost')->name('backend.users.edit.post');
    
    
    Route::get('/users/delete/{id}', 'AdminController@delete')->name('backend.users.delete');
    
    
    
  
  
  
  

  	});




