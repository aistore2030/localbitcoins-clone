 
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Trade Plateform</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/design/assets/images/favicon.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"  >

<style>
    html,
body {
  overflow-x: hidden; /* Prevent scroll on narrow devices */
}

body {
  padding-top: 180px;
}

@media (max-width: 991.98px) {
  .offcanvas-collapse {
    position: fixed;
    top: 56px; /* Height of navbar */
    bottom: 0;
    left: 100%;
    width: 100%;
    padding-right: 1rem;
    padding-left: 1rem;
    overflow-y: auto;
    visibility: hidden;
    background-color: #343a40;
    transition: visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
  }
  .offcanvas-collapse.open {
    visibility: visible;
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
  }
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  color: rgba(255, 255, 255, .75);
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

.nav-underline .nav-link {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: .875rem;
  color: #6c757d;
}

.nav-underline .nav-link:hover {
  color: #007bff;
}

.nav-underline .active {
  font-weight: 500;
  color: #343a40;
}

.text-white-50 { color: rgba(255, 255, 255, .5); }

.bg-purple { background-color: #6f42c1; }

.lh-100 { line-height: 1; }
.lh-125 { line-height: 1.25; }
.lh-150 { line-height: 1.5; }


footer
{
    margin:50px 0;
}




.title {
  line-height: 100px;
}

.xappcss 
{
    line-height:30px;
}

</style>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"  ></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" ></script>



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"  ></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>


</head>

<body ng-app="myApp">

 <nav class="navbar navbar-expand-lg fixed-top navbar-light "style="background-color:#212467; ">
     
     <a class="navbar-brand" href="#">
          <img src="/assets/images/logo/1.png" alt="">
        </a>
        
        
 
 
  <button class="navbar-toggler p-0 border-0" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault" >
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active" >
        <a class="nav-link" href="/" style="color:#FFFFFF;">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      
      
         <li class="nav-item">   <a class="nav-link"   href="/system/account"style="color:#FFFFFF;">Accounts</a></li><li  class="nav-item">
    
       <a  class="nav-link" href="/trade/BTC/USD" style="color:#FFFFFF;">Exchange</a></li><li  class="nav-item">
       
       
       
    
    <li  class="nav-item">
        
        
    <a  class="nav-link" href="/auth/profile" style="color:#FFFFFF;">Profile</a>
    </li>
    
    
    
    <li class="nav-item dropdown">
       
       
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:#FFFFFF;">Peer to Peer Trade</a>
        
        
        <div class="dropdown-menu" aria-labelledby="dropdown01">
        
             
    <a  class="dropdown-item"  href="/p2p/buy_bitcoins">Buy Bitcoin</a>
    <a class="dropdown-item"  href="/p2p/sell_bitcoins" >Sell Bitcoin</a> 
    <a class="dropdown-item"  href="/p2p/postTrade" >Create Your own Add</a> 
    
         
    <a  class="dropdown-item"  href="/p2p/all_trade"> Own Trades</a>
    
    
        </div>
      </li>
      
      
        <li class="nav-item dropdown">
       
       
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="color:#FFFFFF;">Earning by Refer</a>
        
        
        <div class="dropdown-menu" aria-labelledby="dropdown01">
        
             
    <a  class="dropdown-item"  href="/aff/packages">Packages</a> 
    
    <a  class="dropdown-item"  href="/aff/up_earning">Up Earnings</a> 
    
    
    <a  class="dropdown-item"  href="/aff/ref_earning">Referral Earnings</a> 
    
    
    
    <a  class="dropdown-item"  href="/aff/refers">Direct Refer</a> 
    <a  class="dropdown-item"  href="/aff/refers/1">Refer Level 1</a>  
    
    <a  class="dropdown-item"  href="/aff/refers/2">Refer Level 2</a>  
    
    
    
         
        </div>
      </li>
      
    
    <li class="nav-item dropdown">
       
       
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"style="color:#FFFFFF;">Other menu</a>
        
        
        <div class="dropdown-menu" aria-labelledby="dropdown01">
        
             
    <a  class="dropdown-item"  href="/system/deposits">Deposits</a>
    <a class="dropdown-item"  href="/system/widthdraw">Widthdraw</a> 
    <a  class="dropdown-item" href="/auth/profile">Profile</a>
    
     <a class="dropdown-item" href="/system/transactions">Transactions</a>
     
         
        </div>
      </li>
    
     
    
    <li   class="nav-item"><a class="nav-link" href="/logout"style="color:#FFFFFF;">Logout</a> </li>
    
    </ul>
   
  </div>
</nav> 





    
    
    
     
                                        
                                        
              
              
              
        <div class="content-body">



            <div class="container">
                


                <div class="row">
                    <div class="col">
                        
                        
                        <?php echo $__env->yieldContent('content'); ?>
                        
                        
                        
                    </div>
                </div>

    
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
        
         


<footer class="container">
    <p class="float-right"><a href="#">Back to top</a></p>
    <p>&copy; 2017-2019 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
  </footer>
  
  
    </div>
    
    




 
<script>
    
      var app = angular.module("myApp", [], function($interpolateProvider) {
    $interpolateProvider.startSymbol("<%");
    $interpolateProvider.endSymbol("%>");
});

app.controller('myCtrl', function($scope, $http) {
      console.log("ssssssssssss");


     $scope.getPairRateC1Buy = function  (id,total)
    {
        
        
        $http.get("/p2p/getratec1/"+id+"/"+total )
  .then(function(response) {
  //  $scope.getPairRateRS = response.data ;
    
    console.log(response.data);
   $scope.btcvalue= response.data ;
  });
  
          
    };
    
    
    
     $scope.getPairRateC2Buy = function  (id,total)
    {
        
        
        $http.get("/p2p/getratec2/"+id+"/"+total )
  .then(function(response) {
  //  $scope.getPairRateRS = response.data ;
    
    console.log(response.data);
   $scope.c1value= response.data ;
  });
  
          
    };
    
    
});

    
    
    
    
</script>
 




</body><?php /**PATH /home/xpagg/public_html/resources/views/design1layout.blade.php ENDPATH**/ ?>