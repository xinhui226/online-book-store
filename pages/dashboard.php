<?php 

if(!Authentication::whoCanAccess('editor'))
 {
  header('Location: /');
  exit;
 }


require dirname(__DIR__)."/parts/adminheader.php";
?>

 
<div class="row justify-content-evenly"> 
    <div class="col-12">
        <h1 class="colorxtradark text-center my-5">Dashboard</h1>
    </div> <!--col-12-->
    
    <div class="col-lg-3 col-md-3 bg-light btn rounded-4 p-4 mb-4 position-relative">
        <a href="/managecategory" class="text-decoration-none colordark">
        <i class="bi bi-tag-fill dash"></i>
            <h4>Categories<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Category::totalCategories()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->
    
    <div class="col-lg-3 col-md-3 bg-light btn rounded-4 p-4 mb-4 position-relative">
        <a href="/manageauthors" class="text-decoration-none colordark">
        <i class="bi bi-pen-fill dash"></i>
            <h4>Authors<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Authors::totalAuthors()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->
    
    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-4 position-relative">
        <a href="/manageproducts" class="text-decoration-none colordark">
        <i class="bi bi-book-fill dash"></i>
                <h4>Products<i class="bi bi-chevron-right fs-6"></i></h4>
                <h4>(<?=Products::totalProducts()['quantity']?>)</h4>
            </a>
    </div> <!--col-lg-3 col-md-3-->

</div> <!--row justify-content-evenly-->

<?php if(Authentication::whoCanAccess('admin')):?>

<div class="row justify-content-evenly mt-3">

    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-4 position-relative">
        <a href="/managemessages" class="text-decoration-none colordark">
            <i class="bi bi-envelope-fill dash"></i>
            <h4>Messages<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Messages::allMessage()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->

    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-4 position-relative">
        <a href="/manageaccount" class="text-decoration-none colordark">
            <i class="bi bi-people-fill dash"></i>
            <h4>Users Account<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Users::totalUserAccount()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->
    
    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-4 position-relative">
        <a href="/manageorders" class="text-decoration-none colordark">
            <i class="bi bi-receipt-cutoff dash"></i>
            <h4>Sales<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>RM (<?=Order::countSales()['sales']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->


    <div class="col-lg-7 bg-light rounded-4 p-4 my-5 table-responsive" style="height:fit-content;">
            <h4 class="colordark">Recent Orders</h4>

            <?php if(empty(Order::listAllOrder())) :?>
                <h3 class="colorxtradark">No record found</h3>
            <?php else: ?>
            <table class="table table-borderless colorxtradark">
                <thead>
                    <tr>
                    <th scope="col">No. </th>
                    <th scope="col">User</th>
                    <th scope="col">Amount</th>
                    <th scope="col">Placed Order On</th>
                    <th scope="col">Payment Status</th>
                    <th scope="col">Order Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach(Order::listAllOrder(10) as $index=> $order) :?>
                        <tr>
                        <th scope="row"><?=$index+1?></th>
                        <td><?=Users::getUserById($order['user_id'])['username']?></td>
                        <td>RM <?=$order['total_amount']?></td>
                        <td><?=$order['created_at']?></td>
                        <td><?=$order['payment_status']?></td>
                        <td><?=($order['payment_status']=='Failed'?'---':$order['order_status'])?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        <a href="/manageorders" class="text-decoration-none colorxtradark d-block text-end">See All</a>
        <?php endif;?> <!--end - if(empty(Order::listAllOrder()))-->
    </div> <!--col-lg-7-->

    <div class="col-lg-4 col-md-6 bg-light rounded-4 p-4 my-5">
    
            <h4 class="colordark">New Account</h4>
            <?php if(empty(Users::getAllUsers())) :?>
                <h3 class="colorxtradark">No record found</h3>
            <?php else :?>
            <ul class="list-group list-group-flush">
                <?php foreach(Users::getAllUsers(10) as $index=> $user):?>
                <li class="list-group-item colordark">
                    <div><?=($index+1).'. '.$user['username'].' ( '.$user['role'].' ) '?></div>
                    <small class="d-block text-end colorneutral">ceated at :<?=$user['created_at']?></small>
                </li>
                <?php endforeach; ?>
            </ul>
        <a href="/manageaccount" class="text-decoration-none colorxtradark d-block text-end">See All</a>
        <?php endif ?> <!--end - if empty(Users::getAllUsers());-->
    </div>

<?php 

endif; //end - if(Authentication::whoCanAccess(Admin))

require dirname(__DIR__)."/parts/footer.php";