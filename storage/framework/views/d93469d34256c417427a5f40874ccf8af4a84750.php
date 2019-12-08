<?php $__env->startSection('content'); ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(Config::get('settings.admin_path')); ?>">Control Panel</a>
        </li>
        <li class="breadcrumb-item active">All System Widthdraw Requests.</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            
            
        
            
            <h3>Recent Widthdraw  </h3>
            <table class="table   table-hover " >
 <tr> 
     <td>Txn ID</td>
     <td>Coin</td> 
     <td>Amount</td>
     <td>User ID</td>
     
       <td>Widthdraw Address</td>
         <td>Creation Time</td>
         <td>Update Time</td>  <td>Status</td>
     </tr> 
 
<?php $__currentLoopData = $widthdraw; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>  
    <td>  <a href="/admin/widthdraw/<?php echo e($dt->id); ?>" > <?php echo e($dt->id); ?></a></td>
    <td>   <?php echo e($dt->coin); ?></td>
    <td>   <?php echo e($dt->amount); ?></td> 
    <td>   <?php echo e($dt->user_id); ?></td>  
    
    <td>   <?php echo e($dt->widthdraw_address); ?></td>  
   
    <td>   <?php echo e($dt->created_at); ?></td>  
    <td>   <?php echo e($dt->updated_at); ?></td>  
    <td>   <?php echo e($dt->status); ?></td>  
    
    </tr>
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
  
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/system/widthdraw.blade.php ENDPATH**/ ?>