<?php $__env->startSection('content'); ?>
    

 <center><h3>Our packages</h3></center>
 
 
 <center><h3>Your current package is <?php echo e(Session::get('package_name')); ?>   </h3></center>
               
               
               
<div class="row">
<?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<div class="col"><div class="card" style="width: 18rem;">
  <img src="https://www.evansinvestmentcounsel.com/wp-content/uploads/2017/04/philosophy-wealth-management.jpg" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title"><?php echo e($dt['name']); ?></h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
    <p class="card-text"><?php echo e($dt['invest']); ?> USD</p>
    
     
    <form action="investnow"   method="post">
   
  
         <?php echo csrf_field(); ?>

    <input type="hidden" class="form-control" value="<?php echo e($dt['invest']); ?>" name="plan">
    
    
    <input type="hidden" class="form-control" value="<?php echo e($dt['name']); ?>" name="package_name">
     
    <select class="form-control" name="payment_method">
  <option value="BTC">Bitcoin </option>
    <option  value="ETH">Ethereum</option>
    <option  value="BCH">Bitcoin Cash</option>
     
   
        
</select>
 
  <button type="submit" class="btn btn-primary">Invest Now</button>
</form>


    
    
  </div>
</div></div>



    
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
       
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/aff/packages.blade.php ENDPATH**/ ?>