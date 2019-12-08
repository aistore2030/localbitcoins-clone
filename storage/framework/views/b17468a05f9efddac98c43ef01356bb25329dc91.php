<?php $__env->startSection('content'); ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(Config::get('settings.admin_path')); ?>">Control Panel</a>
        </li>
        <li class="breadcrumb-item active">All System depoists.</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            
            
        
            
            <h3>Recent Deposits  </h3>
            <table class="table   table-hover " >
  <tr> 
     <td>Txn ID</td>
     <td>Coin</td> 
     <td>Amount</td>
     <td>User ID</td>
     
       <td>Deposit  Address</td>
         <td>Creation Time</td>
         <td>Update Time</td>  <td>Status</td>
     </tr> 
 
<?php $__currentLoopData = $deposits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>  
    <td>  <a href="/admin/deposit/<?php echo e($dt->id); ?>" > <?php echo e($dt->id); ?></a></td>
    <td>   <?php echo e($dt->coin); ?></td>
    <td>   <?php echo e($dt->amount); ?></td> 
    <td>   <?php echo e($dt->user_id); ?></td>  
    
    <td>   <?php echo e($dt->deposit_address); ?></td>  
   
    <td>   <?php echo e($dt->created_at); ?></td>  
    <td>   <?php echo e($dt->updated_at); ?></td>  
    <td>   <?php echo e($dt->status); ?></td>  
    
    </tr>
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
  
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/system/deposits.blade.php ENDPATH**/ ?>