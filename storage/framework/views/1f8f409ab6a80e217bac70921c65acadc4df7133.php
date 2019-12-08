<?php $__env->startSection('content'); ?>

  <div class="container">

      <div class="row">
        <div class="col-md-12">
            
            <h3>Recent Deposits  </h3>
            <table class="table   table-hover " >
 <tr> 
     <td>Txn ID</td>
     <td>Coin</td> 
     <td>Amount</td>
     <td>Status</td>
     </tr> 
 
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>  
    <td>  <a href="/system/deposits/<?php echo e($dt->id); ?>" > <?php echo e($dt->id); ?></a></td>
    <td>   <?php echo e($dt->coin); ?></td>
    <td>   <?php echo e($dt->amount); ?></td> 
    <td>   <?php echo e($dt->status); ?></td>  
    
    </tr>
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
  </div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/system/deposits.blade.php ENDPATH**/ ?>