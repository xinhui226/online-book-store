<?php

if(Authentication::whoCanAccess('editor'))
 {
  header('Location: /dashboard');
  exit;
 }

require dirname(__DIR__)."/parts/header.php"; 

?>
<body class="bglight">
        <div 
        class="container mt-5 mb-2 mx-auto">
        <a href="/" class="colordark"><?= $_SESSION['left-arrow']; ?> Home</a>
        <h1 class="colordark mt-4">My Orders</h1>

        <?php if(!Authentication::isLoggedIn()) :?>
            
            <div class="d-flex align-items-center justify-content-end">
                <a href="/products" class="colordark me-3">Continue Shopping</a>
            </div>

        <div 
        class="d-flex flex-column justify-content-center align-items-center" 
        style="height:60vh;">
        <img 
        src="./assets/img/empty-box.png" 
        alt="empty order" 
        class="d-block mx-auto">
                      <h5 class="colordark mb-5">Seems like you haven't logged in yet....</h5>
                      <a href="/login" class="darkbtn colorlight btn px-4" style="width:fit-content;">Login</a>
                      <a href="/signup" class="colordark d-block mt-2">Don't have an account? Signup now</a>
                  </div>

        <?php else: ?>

            <?php !empty(Order::getOrderByUser($_SESSION['user']['id']))?'<a href="/products" class="colordark">Shop Again</a>':''?>
            <div class="d-flex align-items-center justify-content-end">
                <a 
                href="/cart" 
                class="colordark me-3">
                My Cart
                </a>
                <a 
                href="/logout" 
                class="colordark">
                Log Out
                </a>
            </div>

            <?php if(empty(Order::getOrderByUser($_SESSION['user']['id']))) :?>

            <div>
                <img src="./assets/img/empty-box.png" alt="empty order" class="d-block mx-auto">
                <div class="text-center">
                    <h1 class="colordark">No order found</h1>
                    <p class="colordark">Start by exploring our products and great deals !</p>
                    <a href="/products" class="darkbtn colorlight btn">Go Shopping</a>
                </div>
            </div>

            <?php else: ?>
     
            <div class="row">
            <?php foreach(Order::getOrderByUser($_SESSION['user']['id']) as $order) :?>
        <div class="col-lg-4 col-sm-6 mb-3">
        <div class="card rounded border-0 h-100 <?=$order['payment_status']=='Failed'?'paymentfail' :'colordark'?>">
            <div class="card-title border-bottom py-2 text-end pe-1">
               <h5 class="text-center">Order #id :<?=$order['id']?></h4>
            </div> <!--card-title-->

            <div class="card-body">

                <p>Amount : RM<?=$order['total_amount']?></p>
                <p>Placed on: <?= tzFormat($order['created_at']) ?></p>
                <p>Status: <?= $order['order_status'] ?></p>
                <p <?=$order['payment_status']=='Failed'?'class="fw-semibold"' :''?>>Payment Status : <?=$order['payment_status']?></p>
                <p>Payment Method : <?=Checkout::checkPaymentDetails($order['transaction_id'])->payment_channel?></p>
                <p>Paid at : <?=tzFormat(Checkout::checkPaymentDetails($order['transaction_id'])->completed_at, false)?></p>
                
            </div> <!--card-body -->

        <?php modalButton('view',$order['id'],'btn-md bgdark colorlight','View Details') ?>

                <!--viewmodal-->
                <?php modalHeader('view',$order['id'],'Order #id :'.$order['id']); ?>

                <div class="row">
                
                <h6>Items :</h6>
                <?php foreach(PivotOrderPro::getProductByOrder($order['id'])as $products) : ?>

                <div class="col-sm-4 mb-2">
                       <img src="./assets/uploads/<?=$products['product']['image']?>" alt="<?=$products['product']['name']?>" class="img-fluid" style="max-width:100px">
                </div> <!--col-sm-4-->
                <div class="col-sm-8 mb-2">
                <h6>Book Name :<?=$products['product']['name']?></h6>
                     <small>RM <?=$products['product']['price']?></small>
                     <div class="text-end">
                         <p>X<?=$products['quantity']?></p>
                         <p>RM<?=$products['product']['price']*$products['quantity']?></p>
                        </div>
                </div> <!--col-sm-8-->

                <?php endforeach; ?> <!--end -foreach(PivotOrderPro::getProductByOrder())-->
                </div> <!--row-->

                <div class="text-end">
                <p>Total Amount :RM <?=$order['total_amount']?></p>
                <p>Placed on : <?= tzFormat($order['created_at']) ?></p>
                <p>Status: <?= $order['order_status'] ?></p>
                <p>Payment Method : <?=Checkout::checkPaymentDetails($order['transaction_id'])->payment_channel?></p>
                </div> <!--text-end-->
                <hr>

                <?php $details = Shipment::getShippingDetails($order['id']) ;?>
                
                <p>Name : <?=$details['name']?></p>
                <p>Phone No. : <?=$details['phone']?></p>
                <p>Address : <?='<br>'.$details['address'].'<br>'.$details['postcode'].'<br>'.$details['state'].'<br>'.$details['city']?></p>

                <?php modalFooter('view'); ?>
                <!--end viewmodal-->
                </div><!--card-->
            </div> <!--col-md-4 col-sm-6 -->

                      <?php endforeach; ?> <!--endforeach Order::getOrderByUser()-->
                      </div> <!--row-->
           

        <?php endif;?> <!--end - if(empty(Order::getOrderByUser($_SESSION['user']['id'])))-->
                
        <?php endif; ?> <!--end - if (!Authentication::isLoggedOut())-->
    </div> <!--container-->
<?php require dirname(__DIR__)."/parts/footer.php"; 