<?php $__env->startSection('content'); ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(Config::get('settings.admin_path')); ?>">Control Panel</a>
        </li>
        <li class="breadcrumb-item active">All System transactions Requests.</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            
            
        
            
            <h3>Recent transactions  </h3>
            <table class="table   table-hover " >
 <tr> 
     <td>Txn ID</td>
     <td>Coin</td> 
     
        <td>User ID</td>
          <td>Debit Amount</td>
          
               <td>Credit Amount</td>
                  <td>descriptioin</td>
                 <td>Created at</td>    <td>Updated at</td>    <td>Status</td>
               
     </tr> 
 
<?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>  
    <td>  <a href="/admin/transactions/<?php echo e($dt->id); ?>" > <?php echo e($dt->id); ?></a></td>
    <td>   <?php echo e($dt->coin); ?></td>
 
    <td>   <?php echo e($dt->user_id); ?></td>  
      <td>   <?php echo e($dt->dr); ?></td>    <td>   <?php echo e($dt->cr); ?></td>    
            <td>   <?php echo e($dt->descriptioin); ?></td>  
   
   
    <td>   <?php echo e($dt->created_at); ?></td>  
    <td>   <?php echo e($dt->updated_at); ?></td>  
    <td>   <?php echo e($dt->status); ?></td>  
    
    </tr>
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</table>
  
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/system/transactions.blade.php ENDPATH**/ ?>