<?php $__env->startSection('content'); ?>
     <meta http-equiv="refresh" content="5" />
    
    <div class="container">
        
         <div class="row">  <div class="col-md-12">
             
 
        <?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>
 
 
     <h1>Contact #<?php echo e($po->id); ?>: Buy  <?php echo e($po->btcvalue); ?> BTC for <?php echo e($po->c1value); ?> BRS </h1> 

<h3>Buy in advertisement #<?php echo e($po->trade_id); ?> (Other online payment) to <?php echo e($po->trade->username); ?> at the exchange rate  	<?php echo e($po->rate); ?> BRL .</h3> 

        
          </div>  </div>
        
        
      <div class="row"> 
<div class="col-md-6">
    
    
    
    <form action="/p2p/process_trade_chat" method="post" class="form-inline">
   <?php echo csrf_field(); ?>
 
 
 <input type="hidden" value="<?php echo e($po->id); ?>" name="trade_order_id" />
 
 <input type="hidden" value="<?php echo e($po->trade_id); ?>" name="trade_id" />
  
  
<div class="form-group">
    
    
    
    
      <p>
    <textarea class="form-control  form-control-lg" id="exampleFormControlTextarea1" name="trade_message" style="  max-width: 100% ;"  rows="3" ></textarea>
    </p>
  </div>  
  
  <button type="submit" class="btn btn-primary btn-lg btn-block">Send</button>
  
</form>

 
 
<?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <p> <?php echo e($d->trade_message); ?> <br> <br> <br> <br> <?php echo e($d->username); ?> -- <?php echo e($d->created_at); ?></p> <hr/>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    
     </div>
    
    <div class="col-md-6"> 
      Terms of trade with <?php echo e($po->trade->username); ?>

      
      <div class="card bg-light" ><div class="card-body">
          <?php echo e($po->trade->terms_of_trade); ?>

    
       
    trade_type    <?php echo e($po->trade->trade_type); ?> <br />
       trade_status  <?php echo e($po->status); ?><br />
       
        user id    <?php echo e($po->user_id); ?><br />
       trade_user_id  <?php echo e($po->trade->user_id); ?>


       
       
       

   </div>  </div>
   
   
   
       <?php if( $po->status ==  "Success"): ?>
       
      <div class="card bg-light" ><div class="card-body">
   
       <pre>
       
==== P2P Trade  Receipt Contact #<?php echo e($po->id); ?> ==== 
Seller: <?php echo e($po->username); ?>

Buyer: <?php echo e($po->trade->username); ?>

<?php echo e($po->username); ?> BTC sent to buyer on 2019-11-29 07:17:35+00:00
xpagg.com fee BTC: 0.00020000
Payment details as shown to buyer: {}
Amount:  <?php echo e($po->username); ?>

Reference/message: <?php echo e($po->id); ?>

==== End ====
</pre>


   </div>  </div>
   
<?php endif; ?>
         <br >  <br >
 
 
    
      
      
      
      
       <?php if( $po->status ==  "PaymentCompleted"): ?>
       
       
       
   
    
       <div class="card  bg-light" ><div class="card-body">
           
          
    <form action="/p2p/dispute_trade" method="post" class="form-inline">
   <?php echo csrf_field(); ?>
 
 
 <input type="hidden" value="<?php echo e($po->id); ?>" name="trade_order_id" />
 
 <input type="hidden" value="<?php echo e($po->trade_id); ?>" name="trade_id" />
  
   
  
  
  <button type="submit" class="btn btn-primary mb-2">Dispute Trade</button>
</form>
       </div>  </div>
       
       
       
      
   
      
      
<?php endif; ?>

       
      
       
       <?php if( $po->status  ==  "Success"): ?>
     
     
      <form action="/p2p/leave_feedback" method="post" class="form-inline">
   <?php echo csrf_field(); ?>
 
 
 <input type="hidden" value="<?php echo e($po->id); ?>" name="trade_order_id" />
 
 <input type="hidden" value="<?php echo e($po->trade_id); ?>" name="trade_id" />
 
  <input type="hidden" value="<?php echo e($po->feedback_id); ?>" name="feedback_id" />
 
 
 
     <table class="table table-bordered"> 

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"  >
     
     <tr><td>
     <div class="form-check">  
     
     
       <input class="form-check-input" type="radio" name="feedback" id="feedback" value="Trustworthy"  ><label style="color:green;  "><b>Trustworthy</b></label></div>
 </td></tr>    <tr><td>
       
 
 
<div class="form-check">
    <input class="form-check-input" type="radio" name="feedback" id="feedback" value="Trustworthy">  <label  style="color:green;"><b>Positive</b></label>


 </div>
 <p>Give your trading partner positive feedback to increase his reputation.</p>
 
 
 
 </td></tr>    <tr><td>
<div class="form-check">
<input class="form-check-input" type="radio" name="feedback" id="feedback" value="Trustworthy"  > <b> Neutral</b>

 </div>
 <p>Give your trading partner neutral feedback that does not affect his reputation.</p>
 
 </td></tr>    <tr><td>

<div class="form-check">
<input class="form-check-input" type="radio" name="feedback" id="feedback" value="Trustworthy"  > <label  style="color:red;" margin-left:5px;><b> Distrust and block</b></label>
  
 </div>
 <p>Give your trading partner negative feedback that decreases his reputation and block his account, this prevents him from trading with you again.</p>
 </td></tr>    <tr><td>
 

<div class="form-check">
<input class="form-check-input" type="radio" name="feedback" id="feedback" value="Trustworthy"><label  style="color:red;"><b>Block without feedback</b></label><br>
   
 </div>
 <p >Block your trading partner from trading with you, but don't give him any feedback.</p>
</td></tr>    </table>

      
     
     <div class="form-group">
     
    <textarea class="form-control  form-control-lg" id="exampleFormControlTextarea1" name="message"placeholder="enter your message (optional)"   ></textarea>

  </div>  
  
  <button type="submit" class="btn btn-primary mb-2"rows="3" cols="30"style="margin-left:20px;">Submit Feedback</button>





      
      <?php endif; ?>
      
       
      
 <?php if( $po->user_id ==  Auth::user()->id): ?>
       
  <?php if( $po->status <>  "Success"  and $po->status <>  "Disputed"  and   $po->status <>  "PaymentCompleted"  ): ?>
       
 
    <div class="card bg-light" ><div class="card-body">
    <a href="/p2p/mark_payment_as_paid/<?php echo e($po->id); ?>" type="submit" class="btn btn-primary mb-2">Mark payment as paid </a>
    </div>  </div>
      <br >  <br >
      
      
      
      <?php endif; ?>
      
      <?php endif; ?>
      
      
      
      
 <?php if( $po->trade->user_id ==  Auth::user()->id): ?>
       
 
               
  <?php if( $po->status <>  "Success"     ): ?>
       
      <?php echo e($po->status); ?>

       <div class="card bg-light" ><div class="card-body">
    <a href="/p2p/release_coin/<?php echo e($po->id); ?>" type="submit" class="btn btn-primary mb-2">Release coin</a>
    </div>  </div>
      <br >  <br >
      
    
      

       <?php endif; ?>
       <?php endif; ?>
       
      
       
     
     
       
    </div>
     
  </div>
</div>


<?php $__env->stopSection(); ?>


<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/Localbitcoins/process_trade_buy.blade.php ENDPATH**/ ?>