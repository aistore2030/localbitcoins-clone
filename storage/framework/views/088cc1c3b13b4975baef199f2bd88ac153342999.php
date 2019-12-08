<?php $__env->startSection('content'); ?>
    <caption><h2>All Traders</h2></caption>
    <table class="table table-striped" id="myTable">
      
      <tbody>
        <?php //print_r($data);die; ?>
        <?php echo e($data_trade_user_id); ?>

        
             <?php if(count($data_trade_user_id) > 0): ?>
          <?php $__currentLoopData = $data_trade_user_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          
          
          

          <tr>
              
            <td><?php echo e($list['username']); ?></td>
            <td>Contact #<?php echo e($list['id']); ?>: trade <?php echo e($list['btcvalue']); ?> BTC for <?php echo e($list['c1value']); ?>  <?php echo e($list['currency']); ?>    </td>
            <td><?php echo e($list['id']); ?></td>
            
            <td>  
                
              <a href="/p2p/process_trade_sell/<?php echo e($list['id']); ?>" class="btn btn-outline-dark btn-xs"  >
                  
                Details
              </i></a>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
          <tr>
            <td colspan="11" align="center">No Record Found</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table><br>
    
    <br>
    <br>
     
      <table class="table table-striped" id="myTable">
      
      <tbody>
        <?php //print_r($data);die; ?>
           <?php if(count($data_user_id) > 0): ?>
          <?php $__currentLoopData = $data_user_id; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $list): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <tr>
              
            <td><?php echo e($list['username']); ?></td>
            <td>Contact #<?php echo e($list['id']); ?>: trade <?php echo e($list['btcvalue']); ?> BTC for <?php echo e($list['c1value']); ?> <?php echo e($list['currency']); ?>   </td>
            <td><?php echo e($list['id']); ?></td>
              
                <td> 
              <a href="/p2p/tradeinfo/<?php echo e($list['id']); ?>" class="btn btn-outline-dark btn-xs"  >
                  
                Details
              </i></a>
            </td>
          </tr>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
          <tr>
            <td colspan="11" align="center">No Record Found</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table><br>
    
    <br>
    <br>

<?php $__env->stopSection(); ?>


<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/Localbitcoins/trade_order_list.blade.php ENDPATH**/ ?>