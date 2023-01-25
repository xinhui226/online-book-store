<?php 

if(Authentication::whoCanAccess('editor'))
{   
    header('Location: /dashboard');
    exit;
}

CSRF::generateToken('add_cart_item');

$checkcategory=[];
if(isset($_GET['category']))
{
  foreach($_GET['category']as $categoryid){
    $checkcategory[]=$categoryid;
  }
}

require dirname(__DIR__)."/parts/header.php";
require dirname(__DIR__)."/parts/usernavbar.php"
?>
<body>
<!-- header -->
<header class="position-relative bgimg" id="product">
  <div class="overlay"></div>
    <div 
      class="d-flex flex-column justify-content-center align-items-sm-center h-100 overlayyy">
        <h1 class="fw-semibold text-white align-self-center fst-italic">Open your mind to endless possibilities</h1>
    </div>
  </header>

    <div class="d-flex align-items-center justify-content-between my-4 px-4">
    <a href="/" class="colordark"><?= $_SESSION['left-arrow']; ?> Home</a>
    <form 
            class="d-flex" 
            method="POST" 
            action="<?=$_SERVER['REQUEST_URI']; ?>">
                <input 
                class="form-control rounded-5"
                type="search"
                name="search"
                placeholder="Search" 
                aria-label="Search">
                <button 
                class="border-0 colordark searchbtn ms-1 position-relative" 
                type="submit">
                <i class="bi bi-search position-absolute translate-middle"></i>
                </button>
            </form>
        
      </div> <!--d-flex justify-content-between-->

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">

    <!-- category -->
      <div class="col-lg-3 col-sm-6">
        <div class="position-sticky border p-3">
        <h4 class="fw-semibold colordark">Categories</h4>
        <ul class="list-group">
          <form 
          action="<?= $_SERVER['REQUEST_URI']; ?>" 
          method="GET">
          <?php foreach(Category::listAllCategory() as $category) : ?>
             <li class="list-group-item border-0">
               <input 
               class="form-check-input me-1" 
               type="checkbox" 
               name="category[]" 
               value="<?=$category['id']?>" 
               id="checkbox<?=$category['id']?>" 
               <?php if(in_array($category['id'],$checkcategory)) echo 'checked'?>
               >
                <label 
                class="form-check-label stretched-link colordark" 
                for="checkbox<?=$category['id']?>">
                  <?=$category['name']?>
                </label>
             </li>
             <?php endforeach; ?>
             <button type="submit" class="btn lightbtn mt-2 rounded-4 d-block mx-auto">Search</button>
        </form>
</ul>
        </div>
      </div> <!--col-lg-3-->

         <!-- product -->
         <div class="col-lg-9">
          <h3 class="fw-semibold colordark mb-3">Product</h3>

          <?php if(isset($_POST['search'])&&!empty($_POST['search'])):?>
            <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
            <p class="colordark"><i class="bi bi-fire"></i>= Trending</p>
            <div class="row">
                        <?php if(!empty(Products::search($_POST['search']))) :?>
                        <?php foreach(Products::search($_POST['search']) as $product) : ?>
                        <?php require dirname(__DIR__)."/parts/productpage_display.php"; ?>
                        <?php endforeach; ?> <!-- endforeach Products::search() as $product) -->  
                        <?php else:?>
                          <h3 class="colordark">No record found</h3>
                        <?php endif?>

          <?php elseif(!isset($_POST['search'])&&!empty(Products::listAllProducts())) :?>
            <p class="colordark"><i class="bi bi-fire"></i>= Trending</p>
            <div class="row">
                    <?php if(isset($_GET['category'])):?>
                        <?php foreach($checkcategory as $categoryid) :?>
                         <h4 class="colorneutral"><?=ucfirst(Category::getCategoryById($categoryid)['name']) ?> :</h4>
                        <?php if(!empty(PivotCatPro::getProductByCategory($categoryid))) :?>
                        <?php foreach(PivotCatPro::getProductByCategory($categoryid) as $product) :?>
                        <?php require dirname(__DIR__)."/parts/productpage_display.php"; ?>
                        <?php endforeach;?>
                        <?php else:?>
                        <h6 class="colordark">No record found</h6>
                        <?php endif;?>
                        <?php endforeach;?>
                         <!--end - foreach(PivotCatPro::getProductByCategory($checkcategory))-->
                    <?php else:?>
                        <?php foreach(Products::listAllProducts() as $product) : ?>
                        <?php require dirname(__DIR__)."/parts/productpage_display.php"; ?>
                        <?php endforeach; ?> <!-- endforeach Products::listAllProducts() as $product) -->  
                    <?php endif;?>

          <?php else:?>
              <h3 class="colordark">No record found</h3>

          <?php endif; ?> <!-- endif isset($_POST['search'])&& !empty(Products::search()) -->
         
            
          </div> <!--row-->
          <div class="col-12 text-center pt-4">
            <p class="text-muted fst-italic">Stay tuned for many exciting new products...</p>
          </div>  
      </div> <!--col-lg-9-->
    </div> <!--container-->
</section> <!--section-->


<?php
require dirname(__DIR__)."/parts/footer.php";