<?php $__env->startSection('content'); ?>


<div class="row">
    <div class="col-md-4">
         
         
         <div class="card">
  <h5 class="card-header">Total users</h5>
  <div class="card-body">
    <h5 class="card-title"><?php echo e($total_users); ?></h5>
    
    
    <a href="/admin/users" class="btn btn-primary">Users </a>
  </div>
</div>
</div> 


   <div class="col-md-4">
         
         
         <div class="card">
  <h5 class="card-header">Total users</h5>
  <div class="card-body">
    <h5 class="card-title"><?php echo e($total_users); ?></h5>
    
    
    <a href="/admin/users" class="btn btn-primary">Users </a>
  </div>
</div>

</div> 



      
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/dashboard.blade.php ENDPATH**/ ?>