  
<?php $__env->startSection('content'); ?>

                    <h3>Login...</h3>
                    <form  method="post" action="/sendtologin2">
                        
                    <?php echo csrf_field(); ?>
              <input type="hidden" value="<?php echo e($data['email']); ?>" name="email" />
              <input type="hidden" value="<?php echo e($data['password']); ?>" name="password" />
                 <div class="form-group">
                        <label for="message-text" class="col-form-label">Auth code:</label>
                        <input type="text" class="form-control" name="authcode">
                    </div>
                  
                  
                     <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Login" />
                        </div>
                    
                    
                    </form> 
                    
<?php $__env->stopSection(); ?>
          
<?php echo $__env->make('loginsignup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/system/g2f.blade.php ENDPATH**/ ?>