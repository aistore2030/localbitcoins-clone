
<?php $__env->startSection('content'); ?>
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="<?php echo e(Config::get('settings.admin_path')); ?>">Control Panel</a>
        </li>
        <li class="breadcrumb-item active">All System Widthdraw Requests.</li>
    </ol>
    <div class="row">
        <div class="col-lg-12">
            
             
            <table class="table   table-hover " >
 <tr> 
     <td>Coin</td>
     <td><?php echo e($deposit->coin); ?></td> 
     </tr>
     
    <tr> 
     <td>ID</td>
     <td><?php echo e($deposit->id); ?></td> 
     </tr>  
     
     
     
         <tr> 
     <td>User ID</td>
     <td><?php echo e($deposit->user_id); ?></td> 
     </tr>  
     
         <tr> 
     <td>Description</td>
     <td><?php echo e($deposit->description); ?></td> 
     </tr>   
     
     
         <tr> 
     <td>Amount</td>
     <td><?php echo e($deposit->amount); ?></td> 
     </tr>  
     
     
     
     
     
     
     
        
     
     
     
         <tr> 
     <td>Status</td>
     <td><?php echo e($deposit->status); ?></td> 
     </tr>  
     
     
 
      
     </table>
        
            
  
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/system/deposit_details.blade.php ENDPATH**/ ?>