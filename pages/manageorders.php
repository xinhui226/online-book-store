<?php 

if(!Authentication::whoCanAccess('admin'))
{
   if(Authentication::isEditor())
   {
       header('Location: /dashboard');
       exit;
   } // end if user is editor
   else{
       header('Location: /');
       exit;
   }// end else
}

CSRF::generateToken('update_orderstatus');

if($_SERVER['REQUEST_METHOD']=='POST'){

    $_SESSION['error'] = FormValidation::validation
    ( 
      $_POST,
      [
          'orderid'=>'required',
          'csrf_token'=>'update_orderstatus_token'
      ] 
  );

      if(empty($_SESSION['error']))
      {
          Order::updateOrderStatus($_POST['orderid'],$_POST['orderstatus']);

          CSRF::removeToken('update_orderstatus');

          $_SESSION['message'] = 'Successfully update Order # id :'.$_POST['orderid'].' order status to "'.$_POST['orderstatus'].'"';
          header('Location: /manageorders');
          exit;
      }//end - empty($_SESSION['error'])
}

require dirname(__DIR__)."/parts/adminheader.php";
?>
    
<div class="d-flex justify-content-between">
    <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 

</div> <!--d-flex justify-content-between-->

        <h1 class="colorxtradark text-center mb-5">Orders</h1>

            <?php if(!empty(Order::listAllOrder())) :?>
            <div class="row g-2">
        <?php foreach(Order::listAllOrder() as $order) : ?>

        <div class="col-md-4 col-sm-6 mb-3">
        <div class="card rounded border-0 h-100 <?=$order['payment_status']=='Failed'?'paymentfail' :'colordark'?>">
            <div class="card-title border-bottom py-2 text-end pe-1">
               <h5 class="text-center">Order #id :<?=$order['id']?></h4>
            </div> <!--card-title-->

            <div class="card-body">
                <p>
                    Username : <?=Users::getUserById($order['user_id'])['username']?>
                    <?php modalButton('viewuser',$order['id'],'colordark','<i class="bi bi-eye"></i>') ?>
                </p>

                <!-- view user detail modal -->
                <?php modalHeader('viewuser',$order['id'],'User Details');
                 $details = Shipment::getShippingDetails($order['id']) ;?>
                
                <h6>Order id : <?=$order['id']?></h6>
                <p>User id : <?=$order['user_id']?></p>
                <p>Name : <?=$details['name']?></p>
                <p>Phone No. : <?=$details['phone']?></p>
                <p>Address : <?=$details['address'].'<br>'.$details['postcode'].'<br>'.$details['state'].'<br>'.$details['city']?></p>
                
                <?php modalFooter('view'); ?>
                <!--end - view user detail modal -->

                <p>Amount : RM<?=$order['total_amount']?></p>
                <p>Placed on : <?=tzFormat($order['created_at'])?></p>
                <p <?=$order['payment_status']=='Failed'?'class="fw-semibold"' :''?>>Payment Status : <?=$order['payment_status']?></p>
                <p>Payment Method : <?=Checkout::checkPaymentDetails($order['transaction_id'])->payment_channel?></p>
                <p>Paid at : <?=tzFormat(Checkout::checkPaymentDetails($order['transaction_id'])->completed_at, false)?></p>
                <label 
                for="deliver<?=$order['id']?>" 
                class="form-label">
                Order Status :
            </label>
            <?php if($order['payment_status']!='Failed') :?>
                    <div class="text-center">
                    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <select class="form-select form-select-md colordark" id="deliver<?=$order['id']?>" name="orderstatus">
                        <option value="Pending" <?=($order['order_status']=='Pending'?'selected' : '')?>>Paid</option>
                        <option value="Out of delivery" <?=($order['order_status']=='Out of delivery'?'selected' : '')?>>Out Of Delivery</option>
                        <option value="Delivered" <?=($order['order_status']=='Delivered'?'selected' : '')?>>Delivered</option>
                    </select>
                        <input type="hidden" name="orderid" value="<?=$order['id']?>">
                        <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('update_orderstatus')?>">
                        <button type="submit" class="btn btn-sm bgneutral colorxtradark mt-2">Save</button>
                    </form>
                    </div> <!--text-center-->

            <?php else: ?>
                <input class="form-control" disabled>
            <?php endif;?> <!--end - if($order['payment_status']!='Failed')-->
            </div> <!--card-body -->

        <?php modalButton('view',$order['id'],'btn-md bgdark colorlight','View') ?>

                <!--viewmodal-->
                <?php modalHeader('view',$order['id'],'Order #id :'.$order['id']); ?>

                <p>User : <?=$order['user_id']?></p>
                <p>Amount :RM <?=$order['total_amount']?></p>
                <p>Placed on : <?=tzFormat($order['created_at'])?></p>
                <p <?=$order['payment_status']=='Failed'?'class="fw-semibold"' :''?>>Payment Status : <?=$order['payment_status']?></p>
                <hr>
                <div class="row">
                <?php foreach(PivotOrderPro::getProductByOrder($order['id'])as $products) : ?>

                <div class="col-sm-4 mb-2">
                       <img src="./assets/uploads/<?=$products['product']['image']?>" alt="<?=$products['product']['name']?>" class="img-fluid" style="max-width:100px">
                </div> <!--col-sm-4-->
                <div class="col-sm-8 mb-2">
                <h6>Book Name :<?=$products['product']['name']?></h6>
                     <small>RM <?=$products['product']['price']?></small>
                     <div class="text-end">
                         <p>X<?=$products['quantity']?></p>
                         <p>Total : RM<?=$products['product']['price']*$products['quantity']?></p>
                        </div>
                    
                </div> <!--col-sm-8-->

                <?php endforeach; ?> <!--end -foreach(PivotOrderPro::getProductByOrder())-->
                </div> <!--row-->

                <?php modalFooter('view'); ?>
                <!--end viewmodal-->
                </div><!--card-->
            </div> <!--col-md-4 col-sm-6 -->
        <?php endforeach; ?>
        <?php else : ?>
        <h3 class="colorxtradark">No record found</h3>
        <?php endif; ?> <!--end if(empty(Order::listAllOrder()))-->

                </div><!--row-->
       
<?php
require dirname(__DIR__)."/parts/footer.php";