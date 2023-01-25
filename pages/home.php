<?php

if(Authentication::whoCanAccess('editor'))
 {
  header('Location: /dashboard');
  exit;
 }

 CSRF::generateToken('contact_form');

if($_SERVER['REQUEST_METHOD']=='POST'){

$name=$_POST['name'];
$email=$_POST['email'];
$text=$_POST['content'];

    $_SESSION['error']=FormValidation::validation(
        $_POST,
        [
            'name'=>'required',
            'email'=>'email_check',
            'content'=>'required',
            'csrf_token'=>'contact_form_token'
        ]
        );

    if(empty($_SESSION['error']))
    {
        Messages::sendMessage($name,$email,$text);

        CSRF::removeToken('contact_form');

        $_SESSION['message'] = 'We will get right back to you, '.$name.' !';
        header('Location: /');
        exit;
    }

}
require dirname(__DIR__)."/parts/header.php";
?>

<body>
<?php require dirname(__DIR__)."/parts/usernavbar.php"; ?>
<header class="py-4">
    <div class="container py-5">
        <div class="row position-relative justify-content-md-end">
                <div 
                class="title col-md-6 d-flex flex-column justify-content-center align-items-start">
                <h1 class="fw-semibold colordark fst-italic">Welcome to Book Store</h1>
                <h6 class="colordark">With us, you can shop online & help save your high street at the same time</h6>
                <a href="/products" class="btn neutralbtn colordark py-2 mb-4 rounded-pill">Explore Book <i class="bi bi-arrow-right"></i></a>
            </div>
            <div class="col-md-5 col-sm-8">
                <img src="../assets/img/contact.jpg" class="img-fluid" alt="">
            </div>
            <div class="col-1"></div>
    </div>
</div>
</header>

<!-- trending section -->
<section id="trending" class="text-center">
    
<?php if(!empty(Products::trendingProducts())) :?>
    <h5 class="fw-semibold d-inline-block line position-relative colordark mb-5">Trending</h5>
    <div class="container py-5 text-center d-flex justify-content-center">
        <div class="col-8">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php foreach(Products::trendingProducts() as $index=> $product) : ?>
                <div class="carousel-item <?=($index==0?'active':'')?>">
                    <img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="d-block mx-auto">
                    <p class="text-center fst-italic">Title :<?=$product['name']?></p>
                </div>
                <?php endforeach; ?>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
            <i class="bi bi-chevron-left colordark" aria-hidden="true"></i>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
            <i class="bi bi-chevron-right colordark" aria-hidden="true"></i>
            <span class="visually-hidden">Next</span>
        </button>
        </div>
        </div>
        
    <a href="/products" class="text-decoration-none colordark d-block text-end">All Product <i class="bi bi-chevron-right"></i></a>
</div> <!--container-->
<?php endif; ?>


</section> 

<!-- contact section -->
<section class="position-relative py-5 bglight">
    <div class="container text-center">
        <h5 class="fw-semibold d-inline-block line position-relative colordark mb-5">Send Us A Message</h5>
        <div class="row justify-content-center mb-4">
            <div class="col-lg-4 col-md-8 d-flex flex-column align-items-center">
            <div class="mb-2">
                <form 
                   action="<?=$_SERVER['REQUEST_URI']?>" 
                   method="POST"
                   >
                        <input
                        type="text" 
                        name="name"
                        placeholder="Enter your name" 
                        class="form-control input mb-3 rounded-4"
                        
                        >
                        <input 
                        type="email" 
                        name="email"
                        placeholder="Enter your email" 
                        class="form-control input mb-3 rounded-4"
                        
                        >
                        <textarea 
                        name="content" 
                        placeholder="Leave your message here" 
                        class="form-control input mb-2 rounded-4" 
                        cols="30" 
                        rows="5"
                        
                        ></textarea>
                <button 
                type="submit" 
                name="submit"
                class="btn darkbtn my-2 rounded-4">
                Submit
                </button>
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('contact_form')?>">
                </form>
            </div> <!-- form -->
            </div> <!--col-lg-7-->
           

        </div> <!--row-->
    </div> <!--container-->
</section> <!--contact section-->


 <?php
require dirname(__DIR__)."/parts/footer.php";
