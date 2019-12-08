

<!doctype html>
<html lang="en">
  <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
     
     
    <title>Welcome...</title>


<!-- general csrf token for all jquery ajax request -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/bootstrap.min.css')); ?>">
    <!-- Custom styles for this template -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('frontend/css/blog.css')); ?>">

   
    <!-- Bootstrap core CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" >
    <style>
    
body {
  padding-top: 100px;
}
@import  url('https://fonts.googleapis.com/css?family=Numans');

html,body{
background-image: url('http://wishmoney.trade/assets/login/img/bg-03-01.svg');
background-size: cover;
background-repeat: no-repeat;
height: 100%;
font-family: 'Numans', sans-serif;


}

      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
      
      .container {
  max-width: 960px;
}

/*
 * Custom translucent site header
 */

.site-header {
  background-color: rgba(0, 0, 0, .85);
  -webkit-backdrop-filter: saturate(180%) blur(20px);
  backdrop-filter: saturate(180%) blur(20px);
}
.site-header a {
  color: #999;
  transition: ease-in-out color .15s;
}
.site-header a:hover {
  color: #fff;
  text-decoration: none;
}

/*
 * Dummy devices (replace them with your own or something else entirely!)
 */

.product-device {
  position: absolute;
  right: 10%;
  bottom: -30%;
  width: 300px;
  height: 540px;
  background-color: #333;
  border-radius: 21px;
  -webkit-transform: rotate(30deg);
  transform: rotate(30deg);
}

.product-device::before {
  position: absolute;
  top: 10%;
  right: 10px;
  bottom: 10%;
  left: 10px;
  content: "";
  background-color: rgba(255, 255, 255, .1);
  border-radius: 5px;
}

.product-device-2 {
  top: -25%;
  right: auto;
  bottom: 0;
  left: 5%;
  background-color: #e5e5e5;
}


/*
 * Extra utilities
 */

.flex-equal > * {
  -ms-flex: 1;
  flex: 1;
}
@media (min-width: 768px) {
  .flex-md-equal > * {
    -ms-flex: 1;
    flex: 1;
  }
}

.overflow-hidden { overflow: hidden; }
 
 #sell{
     padding:0 30px;
     background-color:red;
 } 
 
 #buy{  background-color:green;
          padding:0 30px;
 
 }
    </style>
    <?php echo $__env->yieldContent('style'); ?>
    
   
   
  </head>
  <body  ng-app="mainModule"  ng-controller="buyController">
   
 
 

  <?php echo $__env->make('ExchangePages.menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<br /><br /> <br />



 
	
	
	 <?php echo $__env->yieldContent('content'); ?>
 

                                 

 
 

 

<footer class="container  py-5">


</footer>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"  ></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"  ></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"  ></script>
      
      
    
 




      
      
      
      <?php echo $__env->yieldContent('script'); ?>
      
      
      
      
      </body>
</html>



<?php /**PATH /home/xpagg/public_html/resources/views/trade.blade.php ENDPATH**/ ?>