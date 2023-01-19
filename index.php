<?php

session_start();
$_SESSION['left-arrow'] = '<i class="bi bi-chevron-left"></i> ';

require "config.php";
require "includes/functions.php";
require "includes/class-db.php";
require "includes/class-authors.php";
require "includes/class-products.php";
require "includes/class-messages.php";
require "includes/class-category.php";
require "includes/class-category-product.php";
require "includes/class-form-validation.php";
require "includes/class-authentication.php";
require "includes/class-csrf.php";
require "includes/class-users.php";
require "includes/class-cart.php";
require "includes/class-shippingdetails.php";


$path = trim ($_SERVER['REQUEST_URI'],'/');
$path = parse_url($path, PHP_URL_PATH);

switch($path){
    case 'login':
        require "pages/login.php";
        break;
    case 'signup':
        require "pages/signup.php";
        break;
    case 'logout':
        require "pages/logout.php";
        break;
    case 'orders':
    case 'order':
        require "pages/orders.php";
        break;
    case 'cart':
        require "pages/cart.php";
        break;
    case 'checkout':
        require "pages/checkout.php";
        break;
    case 'payment-verification':
        require "pages/payment-verification.php";
        break;
    case 'products':
    case 'product' :
        require "pages/products.php";
        break;
    case 'dashboard':
        require "pages/dashboard.php";
        break;
    case 'managecategory' :
        require "pages/managecategory.php";
        break;
    case 'managecategory-edit' :
        require "pages/managecategory-edit.php";
        break;
    case 'manageproducts':
        require "pages/manageproducts.php";
        break;
    case 'manageproducts-add':
        require "pages/manageproducts-add.php";
        break;
    case 'manageproducts-edit':
        require "pages/manageproducts-edit.php";
        break;
    case 'managemessages':
        require "pages/managemessages.php";
        break;
    case 'manageorders':
        require "pages/manageorders.php";
        break;
    case 'manageaccount':
        require "pages/manageaccount.php";
        break;
    case 'manageaccount-add':
        require "pages/manageaccount-add.php";
        break;
    case 'manageaccount-edit':
        require "pages/manageaccount-edit.php";
        break;
    case 'manageauthors' :
        require "pages/manageauthors.php";
        break;
    case 'manageauthors-edit' :
        require "pages/manageauthors-edit.php";
        break;
    
        default:
        require "pages/home.php";
        break;
}
