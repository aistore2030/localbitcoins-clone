<?php $__env->startSection('content'); ?> 


 
                    <form method="POST" action="/sendtologin">
                        <?php echo csrf_field(); ?>

                        <div class="form-group  ">
                           
 
                                <input placeholder="<?php echo e(__('E-Mail Address')); ?>" id="email" type="email" class="form-control <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="email" value="<?php echo e(old('email')); ?>" required autocomplete="email" autofocus>

                                <?php if ($errors->has('email')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('email'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                           
                        </div>

                        <div class="form-group  ">
                             
                                <input placeholder="<?php echo e(__('Password')); ?>" id="password" type="password" class="form-control <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?> is-invalid <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>" name="password" required autocomplete="current-password">

                                <?php if ($errors->has('password')) :
if (isset($message)) { $messageCache = $message; }
$message = $errors->first('password'); ?>
                                    <span class="invalid-feedback" role="alert">
                                        <strong><?php echo e($message); ?></strong>
                                    </span>
                                <?php unset($message);
if (isset($messageCache)) { $message = $messageCache; }
endif; ?>
                         
                        </div>

                        

                        <div class="form-group    ">
                            
                            
                            <div class="g-recaptcha" data-sitekey="6Lf4bL0UAAAAAIYAgQ3W2v00tiXgahwucKFCk66N"></div>  
                  
                 
                 
                                <button type="submit" class="btn btn-primary">
                                    <?php echo e(__('Login')); ?>

                                </button>

                                <?php if(Route::has('password.request')): ?>
                                    <a class="btn btn-link" href="<?php echo e(route('password.request')); ?>">
                                        <?php echo e(__('Forgot Your Password?')); ?>

                                    </a>
                                    
                                    <a class="btn btn-link" href="/register">
                                        <?php echo e(__('Dont have account? Register')); ?>

                                    </a>
                                    
                                    
                                <?php endif; ?>
                            
                        </div>
                    </form> 
<?php $__env->stopSection(); ?>

<?php echo $__env->make('loginsignup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/auth/login.blade.php ENDPATH**/ ?>