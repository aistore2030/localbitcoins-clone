<?php $__env->startSection('content'); ?>
    
    
    <div class="container">
        
         <div class="row"> 
    
    <div class="col-md-6">
       
  
       
      <div class="card  bg-light" ><div class="card-body">
           
          
    <form action="/p2p/release_coin" method="post" class="form-inline">
   <?php echo csrf_field(); ?>
 
 
 <input type="hidden" value="<?php echo e($po->id); ?>" name="trade_order_id" />
 
 <input type="hidden" value="<?php echo e($po->trade_id); ?>" name="trade_id" />
  
   <table class="table table-borderless">
       
       <tr><td>Amount in BTC </td><td><?php echo e($po->btcvalue); ?></td></tr>
       <tr><td>Amount IN your USD  </td><td><?php echo e($po->c1value); ?></td></tr>
       
        <tr><td colspan=2>   
  <label><input type="checkbox" name="confirmchbox" required value=""> I confirm I have received the payment</label>
 
</td></tr>
   <tr><td colspan=2>
  <button type="submit" class="btn btn-primary mb-2">Release Bitcoin </button></td></tr>
   </table>

  
</form>
       </div>  </div>
       
     
     
       
    </div>
     
  </div>
</div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/Localbitcoins/release_coin.blade.php ENDPATH**/ ?>