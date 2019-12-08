<?php $__env->startSection('content'); ?>

  <div class="container">

      <div class="row">
        <div class="col-md-6">
            <h3> Deposit ID <?php echo e($data->id); ?></h3>
            
            
            <table class="table ">
                <tr><td>Deposit ID  </td><td><?php echo e($data->id); ?></td></tr>
                
                
                
                  <tr><td>Amount</td><td><?php echo e($data->amount); ?></td></tr>
                    <tr><td>Coin</td><td><?php echo e($data->coin); ?></td></tr>
                      <tr><td>Created Time</td><td><?php echo e($data->created_at); ?></td></tr>
                        <tr><td>Deposit Address</td></td><td><?php echo e($data->deposit_address); ?>   <?php echo e(Config::get($data->coin)); ?>   </td></tr>
                        
                        <tr><td>Status  </td><td><?php echo e($data->status); ?></td></tr>
            </table>
            </div>
            <div class="col-md-6"> 
             <?php if($data->coin=='BTC'): ?>
          
           Plese send payment to following address
            
         <b>  <?php echo e($data->deposit_address); ?> 
              
            </b> <br /><br /> <img src="https://blockchain.info/qr?data=<?php echo e($data->deposit_address); ?>&size=200"   /> 
        <?php endif; ?>
        
        
             </div></div></div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/system/deposit_detail.blade.php ENDPATH**/ ?>