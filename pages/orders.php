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

        <!-- if empty -->
        <div>
            <img src="./assets/img/empty-box.png" alt="empty order" class="d-block mx-auto">
            <div class="text-center">
                <h1 class="colordark">No order found</h1>
                <p class="colordark">Start by exploring our products and great deals !</p>
                <a href="/products" class="darkbtn colorlight btn">Go Shopping</a>
            </div>
        </div>
        <!-- else -->
        <div class="row">
            <div class="col-sm-3 col-5 mb-4">
            <select class="form-select colordark bglight" aria-label="Default select example">
  <option selected>All</option>
  <option value="pending">Pending</option>
  <option value="completed">Completed</option>
</select>
            </div>
        </div>

    
                <!-- Order lists -->
                <table class="table mb-5 table-responsive">
                    <thead>
                        <tr class="borderbtm">
                            <th scope="col">Order ID</th>
                            <th scope="col">Items</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Status</th>
                            <th scope="col">Placed Order on</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!--foreach-->
                        <tr>
                            <td>Order ID</td>
                            <td>Items</td>
                            <td>Total Amount</td>
                            <td>Status</td>
                            <td>Placed Order on</td>
                            <td>Action
                                <!--modal  <i class="bi bi-x-lg"></i> -->
                            </td>
                            </tr>
                        <!--end foreach-->
                    </tbody>
                </table>

                <!-- endif -->
                <a href="/products" class="colordark">Continue Shopping</a>
                
        <?php endif; ?>
    </div> <!--container-->
<?php require dirname(__DIR__)."/parts/footer.php"; 