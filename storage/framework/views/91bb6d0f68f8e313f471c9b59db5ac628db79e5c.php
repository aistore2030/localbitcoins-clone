 
<!DOCTYPE html>
<html lang="en">

<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Trade Plateform</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="/design/assets/images/favicon.png">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<style>
    html,
body {
  overflow-x: hidden; /* Prevent scroll on narrow devices */
}

body {
  padding-top: 150px;
}

@media (max-width: 991.98px) {
  .offcanvas-collapse {
    position: fixed;
    top: 56px; /* Height of navbar */
    bottom: 0;
    left: 100%;
    width: 100%;
    padding-right: 1rem;
    padding-left: 1rem;
    overflow-y: auto;
    visibility: hidden;
    background-color: #343a40;
    transition: visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out;
    transition: transform .3s ease-in-out, visibility .3s ease-in-out, -webkit-transform .3s ease-in-out;
  }
  .offcanvas-collapse.open {
    visibility: visible;
    -webkit-transform: translateX(-100%);
    transform: translateX(-100%);
  }
}

.nav-scroller {
  position: relative;
  z-index: 2;
  height: 2.75rem;
  overflow-y: hidden;
}

.nav-scroller .nav {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: nowrap;
  flex-wrap: nowrap;
  padding-bottom: 1rem;
  margin-top: -1px;
  overflow-x: auto;
  color: rgba(255, 255, 255, .75);
  text-align: center;
  white-space: nowrap;
  -webkit-overflow-scrolling: touch;
}

.nav-underline .nav-link {
  padding-top: .75rem;
  padding-bottom: .75rem;
  font-size: .875rem;
  color: #6c757d;
}

.nav-underline .nav-link:hover {
  color: #007bff;
}

.nav-underline .active {
  font-weight: 500;
  color: #343a40;
}

.text-white-50 { color: rgba(255, 255, 255, .5); }

.bg-purple { background-color: #6f42c1; }

.lh-100 { line-height: 1; }
.lh-125 { line-height: 1.25; }
.lh-150 { line-height: 1.5; }

</style>

</head>

<body ng-app="myApp">

 <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-primary">
     
     <a class="navbar-brand" href="#">
          <img src="/assets/images/logo/1.png" alt="">
        </a>
        
        
 
 
  <button class="navbar-toggler p-0 border-0" type="button" data-toggle="offcanvas">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="navbar-collapse offcanvas-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="/admin">Dashboard <span class="sr-only">(current)</span></a>
      </li>
      
      
      
         
       
       
       
       <li  class="nav-item">
       
       
       
    
    <li  class="nav-item">
        
        
    <a  class="nav-link" href="/admin/users">AllUsers</a>
    </li>
    
    
    
    
    <li class="nav-item dropdown">
       
       
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01"
        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Other menu</a>
        
        
        <div class="dropdown-menu" aria-labelledby="dropdown01">
        
             
    <a  class="dropdown-item"  href="/admin/deposits">Deposits</a>
    <a class="dropdown-item"  href="/admin/widthdraw">Widthdraw</a>  
    
     <a class="dropdown-item" href="/admin/transactions">Transactions</a>
     
     
     <a class="dropdown-item" href="/admin/g2f">Reset Google Auth</a>
     
         
        </div>
      </li>
    
     
    
    <li   class="nav-item"><a class="nav-link" href="/admin/logout">Logout</a> </li>
    
    </ul>
   
  </div>
</nav>

 





    
    
    
     
                                        
                                        
              
              
              
        <div class="content-body">



            <div class="container">
                


                <div class="row">
                    <div class="col">
                        
                        
                        <?php echo $__env->yieldContent('content'); ?>
                        
                        
                        
                    </div>
                </div>

    
            </div>
        </div>
       
        <div class="footer">
            <div class="copyright">
                
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
 
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    


<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>


<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>



<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>



</body><?php /**PATH /home/xpagg/public_html/resources/views/backend/index.blade.php ENDPATH**/ ?>