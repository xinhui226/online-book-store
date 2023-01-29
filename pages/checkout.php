<?php

if(!Authentication::isLoggedIn())
{
    header('Location: /');
    exit;
}elseif(Authentication::isEditor()||Authentication::isAdmin())
{
 header('Location: /dashboard');
 exit;
} //end if !Authentication::isloggedIn()

if($_SERVER['REQUEST_METHOD']=='POST'){

 var_dump($_SESSION['checkout_form_csrf_token']);
 var_dump(CSRF::getToken('checkout_form'));
 
    // var_dump(CSRF::getToken('checkout_form'));
    $_SESSION['error']=FormValidation::validation(
        $_POST,
        [
          'name'=>'required',
          'address'=>'required',
          'state'=>'required',
          'city'=>'required',
          'postcode'=>'numeric',
          'phoneno'=>'phone',
          'phonenumber'=>'numeric',
          'csrf_token'=>'checkout_form_csrf_token'
          ]
        );
    
    if(!empty($_SESSION['error']))
    {
        header('Location: /cart');
        exit;
    }else{

        CSRF::removeToken('checkout_form');

        $orderid = Order::createNewOrder($_SESSION['user']['id'],Cart::totalAmountOfCart());
   
        Shipment::insert(
            $_POST['name'],
            $_POST['phoneno'].'-'.$_POST['phonenumber'],
            $_POST['address'],
            $_POST['postcode'],
            $_POST['state'],
            $_POST['city'],
            $orderid
        );

        foreach(Cart::getProductsInCart() as $product)
        {
            PivotOrderPro::insert($product['id'],$orderid,$product['quantity']);
        }
        
        $api = Checkout::proceedPayment($orderid,Cart::totalAmountOfCart());
        
        Cart::clearCart();

        

        if($api!='API not working')
        {
            if(isset($api->id))
            {
                Checkout::updateTransactionId($api->id,$orderid);
            }
            if(isset($api->url)){
                header('Location: '.$api->url);
                exit;
            }else{
                $_SESSION['error']= 'missing bill url';
            }//end - if isset($api->url)
        }
        else{
            $_SESSION['error']=$api;
        }//end-if($api)
    } //end - if !empty($_SESSION['error'])
    
}

require dirname(__DIR__)."/parts/header.php"; 

?>
<body class="bglight">