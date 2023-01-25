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
        class="container mt-5 mb-2 mx-auto" 
        style="max-width: 900px;">
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

            <div class="d-flex align-items-center justify-content-end">
                <a href="/cart" class="colordark me-3">My Cart</a>
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
            <div class="col-sm-3 col-5 mb-4">
            <select class="form-select colordark bglight" aria-label="Default select example">
  <option selected>All</option>
  <option value="pending">Pending</option>
  <option value="completed">Completed</option>
</select>
            </div>
        </div>

                <div class="accordion" id="accordionOrder">
                    <?php foreach(Order::getOrderByUser($_SESSION['user']['id']) as $order) :?>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="heading<?=$order['id']?>">
                            <button class="accordion-button <?=$order['payment_status']=='Failed'?'paymentfail' :''?>" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$order['id']?>" aria-expanded="true" aria-controls="collapse<?=$order['id']?>">
                                Order ID #<?=$order['id']?><small class="ms-2 text-muted"> (created at :<?=$order['created_at']?>)</small>
                            </button>
                            </h2>
                            <div id="collapse<?=$order['id']?>" class="accordion-collapse collapse show" aria-labelledby="heading<?=$order['id']?>" data-bs-parent="#accordionOrder">
                            <div class="accordion-body <?=$order['payment_status']=='Failed'?'paymentfail' :''?>">
                                <?php foreach(PivotOrderPro::getProductByOrder($order['id'])as $products) : ?>
                                    <div class="row justify-content-center">
                                    <div class="col-md-3 mb-2">
                                            <div style="max-width:150px">
                                                <img src="./assets/uploads/<?=$products['product']['image']?>" alt="<?=$products['product']['name']?>" class="img-fluid">
                                            </div>
                                            </div> <!--col-md-3-->
                                            <div class="col-md-9 mb-2">

                                            <h6>Book Name :<?=$products['product']['name']?></h6>
                                            <small <?=$order['payment_status']=='Failed'?'' :'class="text-muted"'?>>RM <?=$products['product']['price']?></small>
                                            <div class="text-end">
                                                <p>X<?=$products['quantity']?></p>
                                                <p>RM<?=$products['product']['price']*$products['quantity']?></p>
                                            </div> <!--text-end-->
                                        </div> <!--col-md-9-->
                                    </div><!--row-->
                                        <?php endforeach ?> <!--end - foreach(PivotOrderPro::getProductByOrder())-->
                                        <div class="text-end">
                                            <p class="fw-semibold">Total Amount : RM<?=$order['total_amount']?></p>
                                                    <p>Payment status : <?=$order['payment_status']?></p>
                                                    <p>Order status : <?=$order['payment_status']=='Failed'?'----' :$order['order_status']?></p>
                                        </div> <!--text-end-->
                                        
                            </div>
                            </div>
                    <?php endforeach; ?> <!--endforeach Order::getOrderByUser()-->
                </div> <!--accordion-->
                <a href="/products" class="colordark">Shop Again</a>

        <?php endif;?> <!--end - if(empty(Order::getOrderByUser($_SESSION['user']['id'])))-->
                
        <?php endif; ?> <!--end - if (!Authentication::isLoggedOut())-->
    </div> <!--container-->
<?php require dirname(__DIR__)."/parts/footer.php"; 