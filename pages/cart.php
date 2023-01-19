<?php

if(Authentication::isEditor()||Authentication::isAdmin())
 {
  header('Location: /dashboard');
  exit;
 }

 if(Authentication::isLoggedIn()){
 CSRF::generateToken('delete_cart_item');
 CSRF::generateToken('increase_cart_item');
 CSRF::generateToken('decrease_cart_item');
 CSRF::generateToken('checkout_form');

 if($_SERVER['REQUEST_METHOD']=='POST')
 {
      if(isset($_POST['action']))
      {
          switch ($_POST['action']){

              case 'delete' :
                $_SESSION['error']=FormValidation::validation(
                  $_POST,
                  [
                    'productid'=>'required',
                    'name'=>'required',
                    'csrf_token'=>'delete_cart_token'
                  ]
                );
                if(empty($_SESSION['error']))
                  {
                    Cart::updateCart($_POST['action'],$_POST['productid']);

                    CSRF::removeToken('delete_cart_item');

                    $_SESSION['message'] = 'Successfully remove Product "'.$_POST['name'].'" from your cart !';
                    header('Location: /cart');
                    exit;
                  }
                  break;
              case 'increase' :
                $_SESSION['error']=FormValidation::validation(
                  $_POST,
                  [
                    'productid'=>'required',
                    'csrf_token'=>'increase_cart_token'
                  ]
                );
                if(empty($_SESSION['error']))
                  {
                    Cart::updateCart($_POST['action'],$_POST['productid']);

                    CSRF::removeToken('increase_cart_item');

                    header('Location: /cart');
                    exit;
                  }
                  break;
              case 'decrease' :
                $_SESSION['error']=FormValidation::validation(
                  $_POST,
                  [
                    'productid'=>'required',
                    'csrf_token'=>'decrease_cart_token'
                  ]
                );
                if(empty($_SESSION['error']))
                  {
                    Cart::updateCart($_POST['action'],$_POST['productid']);

                    CSRF::removeToken('decrease_cart_item');

                    header('Location: /cart');
                    exit;
                  }
                  break;
                break;
              } //end - switch

      } 
      else{

          if(isset($_POST['productid'])){

            $_SESSION['error']=FormValidation::validation(
              $_POST,
              [
                'csrf_token'=>'add_cart_token'
              ]
            );

            if(empty($_SESSION['error']))
            {
              Cart::addToCart($_POST['productid']);

              CSRF::removeToken('add_cart_item');

              $_SESSION['message'] = 'Successfully added Product "'.$_POST['name'].'" to cart !';
              header('Location: /products');
              exit;
              
            }
            } //end - if isset $_POST['productid']

      } // end - else (if isset $_POST['action'])

 }
} // end - if isLoggedIn()
require dirname(__DIR__)."/parts/header.php"; 

?>
<body class="bglight">
  
<?php require dirname(__DIR__)."/parts/error_box.php"; ?>

<div class="container my-5">
        <a href="/" class="colordark text-decoration-none"><?= $_SESSION['left-arrow']?> Home</a>
        <h2 class="colordark my-4">My Cart</h2>

      <?php if(!Authentication::isLoggedIn()) :?>
                <div class="d-flex align-items-center justify-content-end">
                <a href="/products" class="colordark me-3">Continue Shopping</a>
                </div>
        <div 
        class="d-flex flex-column justify-content-center align-items-center" 
        style="height:60vh;">
        <img 
        src="./assets/img/empty-cart.png" 
        alt="empty order" 
        class="d-block mx-auto">
                      <h5 class="colordark mb-5">Seems like you haven't logged in yet....</h5>
                      <a href="/login" class="darkbtn colorlight btn px-4" style="width:fit-content;">Login</a>
                      <a href="/signup" class="colordark d-block mt-2">Don't have an account? Signup now</a>
                  </div>
                  
      <?php else:?>
        <div class="d-flex align-items-center justify-content-end">
                <a href="/orders" class="colordark me-3">My order</a>
                <a 
                href="/logout" 
                class="colordark">
                Log Out
                </a>
            </div>

     <?php if(empty(Cart::getProductsInCart())) :?>

        <div>
            <img src="./assets/img/empty-cart.png" alt="empty order" class="d-block mx-auto">
            <div class="text-center">
                <h1 class="colordark">Your cart is empty...</h1>
                <p class="colordark">Looks like you have not made your choice yet...</p>
                <a href="/product" class="darkbtn colorlight btn">Go Shopping</a>
            </div>
        </div>

        <?php else :?>

         <div class="row">      
            <div class="col-lg-6">
              <h5 class="colordark">Your Items</h5>
              <div 
              class="row border-bottom pb-5" 
              style="max-height: 400px;overflow-y:scroll;">
                <!-- foreach -->
                <?php foreach(Cart::getProductsInCart() as $product): ?>
                <div class="col-sm-5 mb-2">
                  <div style="max-width:150px">
                    <img src="./assets/uploads/<?=$product['image']?>" alt="" class="img-fluid">
                  </div>
                </div> <!--col-sm-5-->
                <div class="col-sm-7 mb-2">

                <!-- delete from cart -->
                <?php modalButton('delete',$product['id'],'ms-auto d-block','<i class="bi bi-x-lg"></i>') ?>
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                <!--deletemodal--> 
                <?php modalHeader('delete',$product['id'],' item "'.$product['name'].'"'); ?>

                <h4 class="fw-light">Are you confirm to remove Item "<?=$product['name'];?>" from your cart ?</h4>              
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="productid" value="<?=$product['id']?>">
                <input type="hidden" name="name" value="<?=$product['name']?>">
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_cart_item')?>">

                <?php modalFooter('delete'); ?>
                <!--end deletemodal-->
                </form>
                    
                
                  <h6><?=$product['name']?></h6>
                  <p class="text-muted">RM <?=$product['price']?></p>
                  <label for="quantity">Quantity :</label>
                  <div class="quantitywrap d-flex align-items-center mt-2">

                  <!-- decrease -->
                  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <button type="submit" class="btn"><i class="bi bi-dash-lg"></i></button>
                    <input type="hidden" name="action" value="decrease">
                    <input type="hidden" name="productid" value="<?=$product['id']?>">
                    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('decrease_cart_item')?>">
                  </form>
                  
                  <p><?=$product['quantity']?></p>

                  <!-- increase -->
                  <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <button type="submit" class="btn"><i class="bi bi-plus-lg"></i></button>
                    <input type="hidden" name="action" value="increase">
                    <input type="hidden" name="productid" value="<?=$product['id']?>">
                    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('increase_cart_item')?>">
                  </form>
                  </div> <!--quantitywrap-->

                  <p class="text-end fw-semibold">Total : RM<?=$product['total']?></p>
                </div> <!--col-sm-7-->
                  <?php endforeach; ?>
                <!-- endforeach -->

              </div> <!--row inside col-lg-6-->
                <div class="d-flex justify-content-between mt-4 px-1">
                    <p>Shipping :</p>
                    <p>Free Shipping</p>
                </div>
                <div class="d-flex justify-content-between bg-light px-1">
                    <p class="pt-2">Total Amount :</p>
                    <p class="pt-2 fw-semibold">RM <?=Cart::totalAmountOfCart()?></p>
                </div>
            </div> <!--col-lg-6-->


            <div class="col-lg-6">
                  <div 
                    class="card rounded-0 shadow-sm mx-auto border-0 bglight mt-3" 
                    style="max-width: 500px;">
                      <div class="card-body">
                        <h5 class="card-title text-center mb-3 py-3 border-bottom colordark">
                          Shipping Details
                        </h5>

                        <form 
                        action="/checkout" 
                        method="POST">
                          <div class="mb-3">
                            <label 
                            for="name" 
                            class="form-label">
                            Name
                        </label>
                            <input
                              type="text"
                              class="form-control input"
                              id="name"
                              name="name"
                              placeholder="Name"
                            />
                          </div>
                          <div class="mb-3">
                            <label 
                            for="phonenumber" 
                            class="form-label">
                                Phone Number
                            </label>
                            <input
                              type="text"
                              class="form-control input"
                              id="phonenumber"
                              name="phonenumber"
                              placeholder="Phone Number"
                            />
                          </div>
                          <div class="mb-3">
                            <label 
                            for="address" 
                            class="form-label">
                                Address
                            </label>
                            <input
                              type="text"
                              class="form-control input"
                              id="address"
                              name="address"
                              placeholder="Address"
                            />
                          </div>
                          <div class="mb-3 col-6">
                            <label 
                            for="postcode" 
                            class="form-label">
                                Postcode
                            </label>
                            <input
                              type="text"
                              class="form-control input"
                              id="postcode"
                              name="postcode"
                              placeholder="Postcode"
                            />
                          </div>
                          <div class="row">
                          <div class="mb-3 col-6">
                            <label 
                            for="state" 
                            class="form-label">
                                State
                            </label>
                            <input
                              type="text"
                              class="form-control input"
                              id="state"
                              name="state"
                              placeholder="State"
                            />
                          </div>
                          <div class="mb-3 col-6">
                            <label 
                            for="city" 
                            class="form-label">
                                City
                            </label>
                            <input
                              type="text"
                              class="form-control input"
                              id="city"
                              name="city"
                              placeholder="City"
                            />
                          </div>
                          </div> <!--row-->
                          <div class="d-flex justify-content-between align-items-center my-3">
                          <a href="/products" class="colordark">Continue Shopping</a>
                <button class="btn neutralbtn colordark">Checkout</button>
            <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('checkout_form')?>">
               </div>
              </form>
             </div>
           </div>
            </div>
             <!--col-lg-6-->
      </div>  <!--row-->

      <?php endif?> <!-- end -if(empty(Cart::getProductsInCart())) -->

      <?php endif;?>  
  </div><!--container-->

<?php require dirname(__DIR__)."/parts/footer.php"; 