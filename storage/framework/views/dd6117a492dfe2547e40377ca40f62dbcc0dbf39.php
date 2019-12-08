<?php $__env->startSection('content'); ?>
    
   
    
    <div class="row">
        <div class="col-lg-6">
<h5 class="mt-0"><?php echo e($user->name); ?></h5>
                <p>Username: <?php echo e($user->username); ?></p>
                <p>Email: <?php echo e($user->email); ?></p>
                
                
                
            <form role="form" action="" enctype="multipart/form-data" method="post">
                
                
              
                    
                    <div class="form-group">
  <label for="usr">Daily Gain Percentage:</label>
  <input type="text" class="form-control" id="usr" value="<?php echo e($user->dailybonus); ?>"     name="dailybonus">
</div> 
                            
                            
                            
                            
       <?php if( $user->widthdrawal ==  "1"): ?>
        <div class="form-group">     <div class="checkbox">
  <label><input type="checkbox"   checked     name="widthdrawal" value=""> Stop widthdrawal for this user</label>
</div></div>

       
       <?php else: ?>
        <div class="form-group">     <div class="checkbox">
  <label><input type="checkbox"     name="widthdrawal" value=""> Stop widthdrawal for this user</label>
</div></div>

       
<?php endif; ?>



                        


                <?php echo csrf_field(); ?>

                        
                  
                  
                 
                <input type="hidden" name="doEdit" value="true">
                
                
                
                <button type="submit" class="btn btn-primary">Update</button> 
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('backend.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/backend/users/profile.blade.php ENDPATH**/ ?>