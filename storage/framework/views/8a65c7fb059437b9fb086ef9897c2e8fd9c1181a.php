<?php $__env->startSection('content'); ?>
    

<div class="row">
    <div class="col-lg-12">
         <center> Your refer id  <?php echo e(Session::get('refer_id')); ?>   </center>
       
       
        <table class="table table-striped datatables table-hover">
           
            <thead>
            <tr>
                <th  >ID</th>
                <th>Name</th>
                <th>email</th>
               <th>Mobile Numer</th>
			   <th>Address</th>
			   
			     
				 
				 
                <th>Created At</th>
                <th>Updated At</th> 
            </tr>
            </thead>
            <tbody>
               
<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <tr>  
    <td>  <a href="#" > <?php echo e($dt->id); ?></a></td>
    <td>   <?php echo e($dt->name); ?></td>
    <td>   <?php echo e($dt->email); ?></td> 
    
	
	 <td>   <?php echo e($dt->mobile); ?></td>
  
    
	 <td>   <?php echo e($dt->address1); ?> <br />
     <?php echo e($dt->address2); ?><br /> 
    
	   <?php echo e($dt->state); ?><br />  <?php echo e($dt->country); ?>   <?php echo e($dt->pin); ?>

	   
	   </td>     


	  
	
      <td>   <?php echo e($dt->created_at); ?></td>
    <td>   <?php echo e($dt->updated_at); ?></td>    
    
	 
  
  
    </tr>
    
    
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
      
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/aff/refersusers.blade.php ENDPATH**/ ?>