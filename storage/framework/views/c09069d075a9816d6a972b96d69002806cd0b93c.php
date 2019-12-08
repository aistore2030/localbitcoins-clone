<?php $__env->startSection('content'); ?>

  <div class="container">

      <div class="row">
        <div class="col-md-12">
            
            <h3>   <center>   <?php echo e(Session::get('pagetitle')); ?>   </center>   </h3>
            
            
            <table class="table table-hover" >
 <tr> 
     <td>Txn ID</td>
     <td>Coin</td>
     <td>Amount</td>
     
     <td>Description</td>
      <td>User ID</td>
     </tr> 
 
<?php $__currentLoopData = $trans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>  
    
    <td>   <?php echo e($dt->id); ?></td>
    
    <td>   <?php echo e($dt->coin); ?></td>
    
    <td>   <?php echo e($dt->cr); ?></td>
     
    
    <td>   <?php echo e($dt->description); ?></td>  
    
         <td>   <?php echo e($dt->user_id); ?></td>
         
    </tr>
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
  </div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/aff/refersincome.blade.php ENDPATH**/ ?>