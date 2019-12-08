<?php $__env->startSection('content'); ?>

  <div class="container">

      <div class="row">
        <div class="col-md-6">
            
            
            
            
        <div class="card"><div class="card-header">      
Profile
 </div>
  <div class="card-body">      
   
<form action="" method="post">
    
     <?php echo csrf_field(); ?>
     
     
  <div class="form-group row">
    <label for="fullname" class="col-4 col-form-label">Full Name</label> 
    <div class="col-8">
      <input id="fullname" name="fullname" value="<?php echo e($user->name); ?>" type="text" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="mobile" class="col-4 col-form-label">Mobile Number</label> 
    <div class="col-8">
      <input id="mobile" name="mobile" type="text" value="<?php echo e($user->mobile); ?>" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="country" class="col-4 col-form-label">Country</label> 
    <div class="col-8">
      <input id="country" name="country" type="text" value="<?php echo e($user->country); ?>" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="state" class="col-4 col-form-label">State</label> 
    <div class="col-8">
      <input id="state" name="state" type="text" value="<?php echo e($user->state); ?>" class="form-control" required="required">
    </div>
  </div>
  <div class="form-group row">
    <label for="address" class="col-4 col-form-label">Address Line 1</label> 
    <div class="col-8">
      <input id="address" name="address1" type="text" value="<?php echo e($user->address1); ?>"  required="required" class="form-control">
    </div>
  </div>
  <div class="form-group row">
    <label for="address2" class="col-4 col-form-label">Address Line 2</label> 
    <div class="col-8">
      <input id="address2" name="address2"  value="<?php echo e($user->address2); ?>" type="text" class="form-control" required="required">
    </div>
  </div> 
  <div class="form-group row">
    <div class="offset-4 col-8">
      <button name="submit" type="submit" class="btn btn-primary">Submit</button>
    </div>
  </div>
</form>
 </div></div> 
 <br /><br /> 
 
 <div class="card">
  <div class="card-header">      
   Change Password
 </div>
                    <div class="card-body">
                        <?php if(session('error')): ?>
                            <div class="alert alert-danger">
                                <?php echo e(session('error')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(session('success')): ?>
                            <div class="alert alert-success">
                                <?php echo e(session('success')); ?>

                            </div>
                        <?php endif; ?>
                        <form class="form-horizontal" method="POST" action="/auth/changePassword">
                            <?php echo e(csrf_field()); ?>


                            <div class="form-group<?php echo e($errors->has('current-password') ? ' has-error' : ''); ?>">
                                <label for="new-password" class="col-md-12 control-label">Current Password</label>

                                
                                    <input id="current-password" type="password" class="form-control" name="current-password" required>

                                    <?php if($errors->has('current-password')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('current-password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                                
                            </div>

                            <div class="form-group<?php echo e($errors->has('new-password') ? ' has-error' : ''); ?>">
                                <label for="new-password" class="col-md-12 control-label">New Password</label>

                                 
                                    <input id="new-password" type="password" class="form-control" name="new-password" required>

                                    <?php if($errors->has('new-password')): ?>
                                        <span class="help-block">
                                        <strong><?php echo e($errors->first('new-password')); ?></strong>
                                    </span>
                                    <?php endif; ?>
                              
                            </div>

                            <div class="form-group">
                                <label for="new-password-confirm" class="col-md-12 control-label">Confirm New Password</label>

                                 
                                    <input id="new-password-confirm" type="password" class="form-control" name="new-password_confirmation" required>
                                
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Change Password
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
 </div> 
 
 
 
 
 
 <br /><br /> 
 
 <div class="card">
  <div class="card-header">      
  Google Auth 
 </div>
 
 
 
                    <div class="card-body">
                     
                        <div   ng-controller="myCtrl">

<p>To Enable or Reset  Google 2F Auth scan this code and then type the code below</p>
<p><img src="<% g2f.qr %>"/>

<br /><% g2f.secret %>

</p>

  <form  ng-submit="enableqrcode(g2f)"  >
                          
                          

                            

                            <div class="form-group">
                              
                              

                                 
                                    <input id="new-password-confirm" type="text" ng-model="g2f.authcode" class="form-control" name="new-password_confirmation" required>
                                
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Set the auth code
                                    </button>
                                </div>
                            </div>
                            
                            <h3><% res %></h3>
                        </form>

</div>



                      
                        
  </div>
   </div> 
 
 
  </div>
  
  <div class="col-md-6">
      
      <div class="card">
  <div class="card-body">
      
      Verification is required to comply with KYC/AML regulations and to protect your account from unauthorized access. Client verifications are managed by Onfido - the world’s most advanced KYC enterprise, and are usually completed within minutes. In rare cases it may take up to 24 hours.</div></div>

  <div class="nv"> No Verification</div> 
 <div class="style2">   Cryptocurrency Deposit Limit</div> 
    <div class="style3">    No Limit
</div> 
  <div class="style2">   Cryptocurrency Withdrawal Limit</div> 
    <div class="style3">  $20,000 / day (including loan withdrawals using stablecoins)
</div> 
  <div class="style2">   Bank Withdrawal Limit</div> 
   <div class="style3">   $0 / month</div> 
  
    <div class="nv">   Basic Verification</div> 
  
      <div class="style2"> Cryptocurrency Deposit Limit</div> 
  <div class="style3">    No Limit</div> 

   <div class="style2">   Cryptocurrency Withdrawal Limit</div> 
 <div class="style3">     $100,000 / day (including loan withdrawals using stablecoins)</div> 

   <div class="style2">   Bank Withdrawal Limit</div> 
  <div class="style3">  $0 / month</div> 
    <div class="nv">   Advanced Verification (required for dividends and cards)</div> 
    <div class="style2">   Cryptocurrency Deposit Limit</div>  
    <div class="style3">   No Limit</div> 

  <div class="style2">    Cryptocurrency Withdrawal Limit</div> 
    <div class="style3">  No Limit (including loan withdrawals using stablecoins)</div> 

   <div class="style2">   Bank Withdrawal Limit</div> 
  <div class="style3">    $10,000.00 / month (can be increased to $100,000.00 on request)</div> 
  
<div class="nv">
Please contact YouseBank Support to request larger loan and withdrawal limits or to open a Business Wallet.</div> 

  </div>
  
  </div></div>
  
  
  
  


  
    
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script><script> 

    var app = angular.module("myApp", [], function($interpolateProvider) {
    $interpolateProvider.startSymbol("<%");
    $interpolateProvider.endSymbol("%>");
});

app.controller('myCtrl', function($scope, $http) {
    
    
    
    
  $http.get("/profile/enableg2f")
  .then(function(response) {
    $scope.g2f = response.data;
  });
  
   
  
  $scope.enableqrcode = function (g2f) {

       
          
      var config = {
        params: {
         secret: g2f.secret, authcode: g2f.authcode
        }
      };


$http.post("/profile/enableg2f", null, config)
  .then(function(response) {
    $scope.res = response.data;
  });
  
  
           
  };



  
   



});


</script>

 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/system/profile.blade.php ENDPATH**/ ?>