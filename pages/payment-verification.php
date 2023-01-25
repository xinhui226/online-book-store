<?php

if(isset($_GET['billplz'])){

    $billplz = $_GET['billplz'];
    
    $string = 'billplzid'.$billplz['id'].'|billplzpaid_at'.$billplz['paid_at'].'|billplzpaid'.$billplz['paid'];

    $signature = hash_hmac('sha256', $string, BILLPLZ_X_SIGNATURE);

    if($signature == $billplz['x_signature']){

        Order::updatePayment($billplz['id'],$billplz['paid'] == 'true' ?  'Completed' : 'Failed');

        header('Location: /orders');
        exit;

    }else{
        $_SESSION['error'] = 'Invalid signature';
    } // end - if($signature == $billplz['x_signature'])

}
else{
    $_SESSION['error'] = "No billplz data found";
} // end - if (isset($_GET['billplz']))

require dirname(__DIR__)."/parts/header.php"; 
?>