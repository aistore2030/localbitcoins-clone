 
<?php $__env->startSection('content'); ?>
<style>
    
    .sic
    {
        width:50px;
    }
</style>
<div class="container">
    
    <table class='table card table-b table-bordered '>
        <tr ><td colspan="4"><h3  class="headings"><center>Flexible Instant Crypto Credit Lines</center></h3></td></tr>
        <tr>
            <Td><b>
                
                <div class="icons">
                    
                    <img src="/assets/currencies/BTC.png" class="img-fluid   account-page-banner-icon sic" alt="BTC">
                    
                    <img src="/assets/currencies/ETH.png" class="img-fluid    account-page-banner-icon sic" alt="ETH">
					
					<img src="/assets/currencies/amerikoin.png" class="account-page-banner-icon  img-fluid sic " alt="amerikoin">
                     
                    <img src="/assets/currencies/XRP.png" class="account-page-banner-icon  img-fluid sic " alt="XRP">
					
					<img src="/assets/currencies/akbank.png" class="account-page-banner-icon  img-fluid sic " alt="akbank">
					                    
                    
                    </div> 
            
            1. Deposit Crypto Assets to Your Insured & Secure Account</b><br/><br/>
Your assets are secured and insured up to $100M by audited custodian Akbank Insurance* policy</Td>
            
           

<Td>   <b>   2. Receive a Credit Line Instantly. Automated and No Credit Checks.</b><br/><br/>

Your credit line limit is based on the value of your deposited crypto assets</Td>

<Td>  <b>3. Spend Money Instantly by Card or Withdraw to Bank Account</b>
<br/><br/>
Spend from the credit line at any time. From 8% per year APR on what you use</Td>

<td> <b>4. No Minimum Loan Repayments No Hidden Fees - Open - Neultral Borderless</b><br/><br/>
Interest is debited from your available limit. Make repayments at any time</td> 
</tr>
        
    </table>
   
   
   
   <div class="row pad20 block3c">
   
   <div class="col-md-4">
    		      <div class="card">
                 
                     <div class="card-body text-center">
                         
                          <div class="row ">
   
   <div class="col-md-2 block3ci "> <i class=" fa fa-university"></i>    </div>
                      
              <div class="col-md-10 block3cw">          
                      <h6>
                <b> Withdraw from Credit Line</b> </h6>
		       <p>By Local Bank Transfer </p>
                      </div>  </div>
               
            </div>
            </div>
              </div>
			  
			  
			  
			  <div class="col-md-4">
    		      <div class="card">
                
                     <div class="card-body ">
                         
                             <div class="row ">
   
   <div class="col-md-2 block3ci "> <i class=" fa fa-undo"></i>    </div>
                      
              <div class="col-md-10 block3cw">          
                      <h6>
                         <b> Repay Credit Line </b></h6>
		       <p>By Bank Transfer or Crypto </p>
                      </div>  </div>
               
               
               
                
                 
                    
            </div>     
            </div>
              </div>
			  
			  
			  <div class="col-md-4">
    		      <div class="card">
                
                     <div class="card-body ">
                         
                         
                         
                             <div class="row ">
   
   <div class="col-md-2 block3ci "> <i class=" fa fa-undo"></i>    </div>
                      
              <div class="col-md-10 block3cw">          
                      <h6>
                       <b>  Buy   Coinpagg</b></h6>
		       <p>Earn 30% (Y) Dividends</p>
                      </div>  </div>
               
               
               
                
                    
              
            </div>
            </div>
              </div>
			  
     </div>
   

<div class="card" >
    <table class='table    table-bordered '>
    
    <tbody>
        
         <tr>
            <th>
             
             
            </th>
            <th class="align-right">Balance</th>
            <th class="align-right  ">Market Value</th>
            <th class="align-right ">Credit Line</th>
            <th class="align-center  "> ..</th>
    
            
         

        </tr>
       <?php
$sum=0;
?>  
        
<?php $__currentLoopData = $coins; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
    
    <tr>
    <td><?php echo e($coin['name']); ?>  
    
 
 <?php
 
 try {
           
$sum=$sum+$coin['BalanceUSD'];
    } catch (\Exception $e) {
        
    }
    

?>
 


</td>
    <td> <?php echo e($coin['Symbol']); ?>  <?php echo e($coin['Balance']); ?>   </td> 
       
    <td>$ <?php echo e(number_format($coin['BalanceUSD'], 2)); ?></td>  
    <td><?php echo e($coin['Symbol']); ?>   <?php echo e($coin['Credit Line']); ?></td>  
    <td class="clrbg"><button type="button" data-toggle="modal" data-target="#exampleModal" data-whatever="<?php echo e($coin['Symbol']); ?>"  data-deposit="<?php echo e($coin['deposit']); ?>"    class="btn btn-info">Deposito</button></td> 
    
    
      
    <td><button type="button"  data-toggle="modal" data-target="#exampleModalWidthdraw" data-whatever="<?php echo e($coin['Symbol']); ?>" data-whatever="<?php echo e($coin['Credit Line']); ?>"     class="btn btn-light">Saque</button></td> 
 
    
   
    
    
        
        </tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


       
        
    </tbody>
</table>







<table  class="table table-bordered" >
<thead>
<tr><th>Method</th><th>Deposit method</th><th>Currencies accepted</th><th>Deposit limit</th><th>Deposit time</th><th>Fees<sup>*</sup></th><th></th></tr>
</thead>
<tbody>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/mockup/psps/visa.png"></td>
<td>Visa, Mastercard and major credit/debit cards</td>
<td>USD, EUR, GBP, AUD</td>
<td>varies</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/swift.png"></td>
<td>Wire Transfer</td>
<td>USD, EUR, GBP,&nbsp;<span>AUD</span></td>
<td>unlimited</td>
<td>2-5 working days</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/skrill.png"></td>
<td>Skrill/Moneybookers</td>
<td>USD</td>
<td><span>unlimited</span></td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/cashu.png"></td>
<td>CashU</td>
<td>USD, EUR</td>
<td>unlimited</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/chinaunionpay.png"></td>
<td>China Union Pay</td>
<td>USD</td>
<td>unlimited</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/moneta.png"></td>
<td>Moneta</td>
<td>USD, EUR, GBP</td>
<td>min. 22 USD per transaction max. 4300 USD per day</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/yandex.png"></td>
<td>Yandex Money</td>
<td>USD</td>
<td>100 USD</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/paysafe.png"></td>
<td>Paysafe Card</td>
<td>USD</td>
<td>min. 100 USD, max. 1000 USD</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/alipay.png"></td>
<td>Ali Pay</td>
<td>USD</td>
<td>unlimited</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
<tr>
<td><img src="https://static-trade12-info-cdn.gnuhost.eu/themes/trade12.com/assets/img/en/accounts/payments/webmoney.png"></td>
<td>WebMoney</td>
<td>USD</td>
<td>100 USD</td>
<td>instant</td>
<td>0</td>
<td><a href="/deposit"><i></i> FUND HERE</a></td>
</tr>
</tbody>
</table>



 



<center>
<h3>Total Value of Crypto Assets: $ <?php echo e(number_format($sum, 2)); ?></h3>

<p>
If the total value of your crypto assets reaches $ <?php echo e(number_format($sum, 2)); ?>, small partial loan repayments might be initiated automatically</p>

</center>

</div>
 
</div>

















<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Deposit </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <p>Send payment to following address</p>
       
       <form method="post" action="/system/deposits"> <?php echo e(csrf_field()); ?>

       
         <input type="hidden"   name="coin"  id="coin" >
        
         
         
  <div class="form-group">
    <label for="exampleInputEmail1">Amount</label>
    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="Amount" name="amount" placeholder="Amount">
     
  </div>
      <div class="form-group"><button type="submit" class="btn btn-primary">Deposit</button>
  </div>
</form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="exampleModalWidthdraw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Widthdraw </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
          
     <form method="post" action="/system/widthdraw"> <?php echo e(csrf_field()); ?>

       
     
         
  <div class="form-group">
    <label for="exampleInputEmail1">Widthdraw Amount</label>
    <input type="number" step="any"  class="form-control"  name="amount"   id="amount" aria-describedby="emailHelp" placeholder="Widthdraw amount">
    <div id="max"></div>
  </div>
    
    
     <div class="form-group">
    <label for="exampleInputEmail1">Widthdraw Address</label>
    <input type="text" class="form-control"  name="widthdraw_address"   id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Widthdraw Address">
    
  </div>
  
         <input type="hidden"   name="coin"  id="coin" >
         
    <div class="form-group"><button type="submit" class="btn btn-primary">Submit Widthdraw</button>
  </div>
  
</form>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      
      </div>
    </div>
  </div>
</div>




<script>
    
    
    $('#exampleModalWidthdraw').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  
 // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input#coin').val(recipient)
})




    $('#exampleModal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var recipient = button.data('whatever') // Extract info from data-* attributes
  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
  var modal = $(this)
  
 // modal.find('.modal-title').text('New message to ' + recipient)
  modal.find('.modal-body input#coin').val(recipient)
})


</script>


<?php $__env->stopSection(); ?>

 


<?php echo $__env->make('design1layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/xpagg/public_html/resources/views/system/index.blade.php ENDPATH**/ ?>