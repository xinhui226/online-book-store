<?php

if(!Authentication::isLoggedIn())
{
    header('Location: /');
    exit;
}elseif(Authentication::isEditor()||Authentication::isAdmin())
{
 header('Location: /dashboard');
 exit;
}


if($_SERVER['REQUEST_METHOD']=='POST'){

    $_SESSION['error']=FormValidation::validation(
        $_POST,
        [
          'name'=>'required',
          'address'=>'required',
          'state'=>'required',
          'city'=>'required',
          'postcode'=>'numeric',
          'phonenumber'=>'numeric',
          'csrf_token'=>'checkout_form_token'
        ]
      );

    if(!empty($_SESSION['error']))
    {
        header('Location: /cart');
        exit;
    }else{
       
    }
    
}

require dirname(__DIR__)."/parts/header.php"; 

?>
<body class="bglight">
<?php require dirname(__DIR__)."/parts/error_box.php"; ?>