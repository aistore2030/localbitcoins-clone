<?php $__env->startSection('content'); ?>
<style>
  
  

 
 #sell{
     padding:0 30px;
     background-color:red;
 } 
 
 #buy{  background-color:steelblue;
          padding:0 30px;
 
 }
 
 .smallfont{
     font-size:11px;
 }
 
 
 .buybg{
  
 background-color:steelblue;
 
 } .sellbg{
  
 background-color:red;
 
 }
 
 .owntable{
     color:#fff;
     
 }
 
  
 .owntable :hover{
     color:#fff;
     
 }
 
 </style>
 <br /><br /> 
       
<div class="container-fluid ">
  <div class="row ">
  
  
  
    <div class="col-md-4"   >
        Current Rate
	 <div class="ticker.."   >
   <table class="table table-bordered table-dark table-hover table-sm smallfont">   
                    <tr><td>Pair</td><td>Rate Buy</td><td>Rate Sale</td></tr>
	         <tr ng-repeat="row in Ticker">
		  <td>  <% row.pair  %>  </td >
		  <td>  <% row.rate_buy %>  </td>
	   <td>  <% row.rate_sale %>  </td>
	        </tr>
	        
	        </table>
	        
  </div>
         <div class="order book.."   >	
		
        <ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
        <a class="nav-link active" id="buy-tab" data-toggle="tab" href="#buy" role="tab" aria-controls="buy" aria-selected="true">BUY</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="sell-tab" data-toggle="tab" href="#sell" role="tab" aria-controls="sell" aria-selected="false">SELL</a>
  </li>
   
</ul>
<div class="tab-content" id="myTabContent">
  <div    class="tab-pane fade show active" id="buy" role="tabpanel" aria-labelledby="buy-tab">
      
      <br /><br />   
      <form   >
      <div class="form-group row">
        Amount
        </div>
   
    <div class="form-group row">
   <div class="input-group mb-2 mr-sm-2"> 
    
    <input ng-change="getPairRateC1Buy('btc','<?php echo e($c2); ?>',buy.quantity)" ng-model="buy.quantity" type="text" class="form-control" id="inlineFormInputGroupUsername2" >
  <div class="input-group-prepend">
      <div class="input-group-text">BTC</div>
    </div></div>
    </div>

 <div class="form-group row">
  <div class="input-group mb-2 mr-sm-2">
        <% getPairRateRS %>
    <input   ng-change="getPairRateC2Buy('btc','<?php echo e($c2); ?>',buy.amount)"  ng-model="buy.amount" type="text" class="form-control" id="inlineFormInputGroupUsername2"  >
  <div class="input-group-prepend">
      <div class="input-group-text"> <?php echo e($c2); ?></div>
    </div></div>
    </div>
     
     <div class="form-group row">
       Trade Type
        </div>
   
   
   
 <div class="form-group row">
  
  <div class="input-group mb-2 mr-sm-2">
      <select ng-model="buy.trade_type" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
       
        <option value="market">Market</option>
        <option value="limit">Limit</option> 
      </select>
    </div>
    </div>
    
   <div class="form-group row">
  
  <div class="input-group mb-2 mr-sm-2"> 
  
    <input ng-model="buy.c1"  ng-init="buy.c1='BTC'" value="BTC" type="hidden" >
    
    <input ng-model="buy.c2"  ng-init="buy.c2='<?php echo e($c2); ?>'" value="<?php echo e($c2); ?>" type="hidden" >
    
  
    <input ng-model="buy.pair"  ng-init="buy.pair='BTC<?php echo e($c2); ?>'" value="BTC<?php echo e($c2); ?>" type="hidden" >
    
   <input  ng-model="buy.type"  ng-init="buy.type='buy'" value="buy" type="hidden" >
   
   
 
         <button type="submit"
              ng-click="submitDataSell(buy, 'ajaxSubmitResult2')"
               >BUY </button>
              <% sell_order_result %>
             
    </div>
    </div> 

</form>

</div>
  <div     class="tab-pane fade" id="sell" role="tabpanel" aria-labelledby="sell-tab">
      
        <br /><br />
     <form>
     <div class="form-group row">
        Amount
        </div>
   
    <div class="form-group row">
   <div class="input-group mb-2 mr-sm-2"> 
    
    <input ng-change="getPairRateC1Sell('btc','<?php echo e($c2); ?>', sell.quantity)"  ng-model="sell.quantity" type="text" class="form-control" id="inlineFormInputGroupUsername2" >
  <div class="input-group-prepend">
      <div class="input-group-text">BTC</div>
    </div></div>
    </div>

 <div class="form-group row">
  <div class="input-group mb-2 mr-sm-2">
    <% getPairRateRS %>
    <input  ng-change="getPairRateC2Sell('btc','<?php echo e($c2); ?>', sell.amount)" ng-model="sell.amount" type="text" class="form-control" id="inlineFormInputGroupUsername2"  >
  <div class="input-group-prepend">
      <div class="input-group-text"><?php echo e($c2); ?></div>
    </div></div>
    </div>
    
      

    
     <div class="form-group row">
       Trade Type
        </div>
   
   
   
 <div class="form-group row">
  
  <div class="input-group mb-2 mr-sm-2">
      <select ng-model="sell.trade_type" class="custom-select mr-sm-2" id="inlineFormCustomSelect">
       
        <option value="market">Market</option>
        <option value="limit">Limit</option> 
      </select>
    </div>
    </div>
    
   <div class="form-group row">
  
  <div class="input-group mb-2 mr-sm-2"> 
      <input ng-model="sell.pair"  ng-init="sell.pair='BTC<?php echo e($c2); ?>'" value="BTC<?php echo e($c2); ?>" type="hidden" >
        
        <input ng-model="sell.c1"  ng-init="sell.c1='BTC'" value="BTC" type="hidden" >  
        
        <input ng-model="sell.c2"  ng-init="sell.c2='<?php echo e($c2); ?>'" value="<?php echo e($c2); ?>" type="hidden" >
        
        
           <input  ng-model="sell.type"  ng-init="sell.type='sell'" value="sell" type="hidden" >
  
   
         <button type="submit"
              ng-click="submitDataSell(sell, 'ajaxSubmitResult2')"
               >SELL </button>
              <% sell_order_result %>
             
    </div>
    </div> 

</form>

  </div> 
  
  
</div>
</div> <!-- order booking form end -->

<div class="our balance.."   >Your Balance
 <table class="table table-bordered table-dark table-hover table-sm">   
                         
	         <tr ng-repeat="row in getUserBalance">
	   <td>  <% row.coin %>  </td >
		  <td>  <% row.balance %>  </td>
		  
		      </tr>
	        
	        </table>
  </div>
  
  
</div>




    <div class="col-md-8  buybg">
	
	
	<div style="height:560px; background-color: #FFFFFF; overflow:hidden; box-sizing: border-box; border: 1px solid #56667F; border-radius: 4px; text-align: right; line-height:14px; font-size: 12px; box-sizing:content-box; font-feature-settings: normal; text-size-adjust: 100%; box-shadow: inset 0 -20px 0 0 #56667F;padding:1px;padding: 0px; margin: 0px;"><div style="height:540px;padding:0px;margin:0px;">
	    
	    <iframe src="https://widget.coinlib.io/widget?type=chart&theme=light&coin_id=859&pref_coin_id=1505" width="100%" height="536" scrolling="auto" marginwidth="0" marginheight="0" frameborder="0" border="0" style="border:0;margin:0;padding:0;line-height:14px;box-sizing:content-box;"></iframe>
	    
	    </div>
	
	


	
	
	</div>
	
	
	
	
   
   <div class="row">
       
                <div class="col-md-4 buybg">
    <table class="table table-borderless  table-hover table-sm  smallfont ">   
                        <tr><td>Amount</td><td>Total</td><td>Price</td></tr>   
	         <tr ng-repeat="row in btcusdOrderHistory">
		    <td>  <% row.quantity | number:4 %>  </td >
		  <td>  <% row.amount  | number:4 %>  </td>
		  
		  <td>  <% row.amount/row.quantity  | number:4 %>  </td>  
		  
		  </tr>
	        
	        </table>  </div>  <div class="col-md-4  sellbg"> 
	        
                      <table class="table table-borderless  table-hover table-sm smallfont ">   
                               
                               <tr><td>Amount</td><td>Total</td><td>Price</td></tr>
	            <tr ng-repeat="row in usdbtcOrderHistory">
		   <td>  <% row.quantity | number:4 %>  </td >
		  <td>  <% row.amount  | number:4 %>  </td>
		  
		  <td>  <% row.amount/row.quantity  | number:4 %>  </td>  </tr>
	        
	        </table> 
</div> 

          <div class="col-md-4 table-dark"> 

                               <table class="table table-borderless table-dark  table-hover table-sm owntable  smallfont">   
	          <tr><td>Amount</td><td>Total</td><td>Price</td></tr>     <tr ng-repeat="row in OwnOrderHistory">
		   <td>  <% row.quantity | number:4 %>  </td >
		  <td>  <% row.amount | number:4 %>  </td>
		  
		  <td> <% row.amount/row.quantity | number:4 %> </td>    </tr>
	        
	        </table>
</div> 

                    
                
                </div>
                 

                                 

 
 
 
 
 
	
	</div>
   

 


  </div>
  
  
   
                 

                                 

 
 

 
 
 
      
      
      <script src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js" ></script>
      
      <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.7.8/angular-sanitize.js"></script>
    <script> 
   
 
    var sampleApp = angular.module("mainModule", [], function($interpolateProvider) {
    $interpolateProvider.startSymbol("<%");
    $interpolateProvider.endSymbol("%>");
});


sampleApp.filter('trustAs', ['$sce', 
    function($sce) {
        return function (input, type) {
            if (typeof input === "string") {
                return $sce.trustAs(type || 'html', input);
            }
       
            return "";
        };
    }
]);
    
  sampleApp.controller("buyController", function ($scope, $http)
  {      
    getOrderHistory( );
    $scope.buy = {};
   $scope.sell = {};
   
   
  
  
 
 $scope.getPairRateC1Sell = function  (c1,c2 ,total)
    {
        
        
        $http.get("/exchange/tickerValueSell/"+c1+"/"+c2+"/"+total )
  .then(function(response) {
  //  $scope.getPairRateRS = response.data ;
    
    $scope.sell.amount= response.data ;
  });
  
          
    };
    
    
    
     $scope.getPairRateC1Buy = function  (c1,c2 ,total)
    {
        
        
        $http.get("/exchange/tickerValueBuy/"+c1+"/"+c2+"/"+total )
  .then(function(response) {
  //  $scope.getPairRateRS = response.data ;
    
    $scope.buy.amount= response.data ;
  });
  
          
    };
    
    
    
    $scope.getPairRateC2Sell = function  (c1,c2 ,total)
    {
        
        
        $http.get("/exchange/tickerValueSellR/"+c1+"/"+c2+"/"+total )
  .then(function(response) {
  //  $scope.getPairRateRS = response.data ;
    
    $scope.sell.quantity= response.data ;
  });
  
          
    };
    
    
    
     $scope.getPairRateC2Buy = function  (c1,c2 ,total)
    {
        
        
        $http.get("/exchange/tickerValueBuyR/"+c1+"/"+c2+"/"+total )
  .then(function(response) {
  //  $scope.getPairRateRS = response.data ;
    
    $scope.buy.quantity= response.data ;
  });
  
          
    };
    
    
  
    
    
    
    
    $scope.getPairRate = function  (c1,c2)
    {
        $http.get("/exchange/ticker/"+c1+"/"+c2 )
  .then(function(response) {
    $scope.getPairRateRS = response.data.bid;
  });
  
          
    };
     
    
    
      $scope.submitDataSell= function (sell, buy_order_result)
    {
        
        
          $scope.sell_order_result = "started..";


          
      var config = {
        params: {
          trade: sell
        }
      };


$http.post("/exchange/tradeorder", null, config)
  .then(function(response) {
    $scope.sell_order_result = response.data;
  });
  
   getOrderHistory( );
  
      
    };
    
    
    function getOrderHistory( )
    {
        


   
        $http.get("/exchange/UserBalance" )
  .then(function(response) {
    $scope.getUserBalance = response.data;
  });
  
           
     
     
     
     
$http.get("/exchange/owntrades" )
  .then(function(response) {
    
      $scope.OwnOrderHistory= response.data;
    
  });
  
  
$http.get("/exchange/trades/buy/<?php echo e($c2); ?>" )
  .then(function(response) {
    
      $scope.btcusdOrderHistory= response.data;
    
  });
  
  
  $http.get("/exchange/trades/sell/<?php echo e($c2); ?>" )
  .then(function(response) {
    
      $scope.usdbtcOrderHistory= response.data;
    
  });
  
      
      
  
  $http.get("/exchange/newsfeed" )
  .then(function(response) {
    
      $scope.newsfeed= response.data;
    
  });
  
  
  
  
  $http.get("/exchange/ticker" )
  .then(function(response) {
    
      $scope.Ticker= response.data;
    
  });
  
  
    };
    
    
    
  });
      
 
  
  
</script>
      
      
       
<?php $__env->stopSection(); ?>

<?php echo $__env->make('trade', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/trade/index.blade.php ENDPATH**/ ?>