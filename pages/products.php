<?php 

if(Authentication::whoCanAccess('editor'))
{   
    header('Location: /dashboard');
    exit;
}

CSRF::generateToken('add_cart_item');

require dirname(__DIR__)."/parts/header.php";
require dirname(__DIR__)."/parts/usernavbar.php"
?>
<body>
<?php require dirname(__DIR__)."/parts/error_box.php" ?>
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
              <div class="d-flex flex-column align-items-end">
              <form class="d-flex" method="GET" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
          <input class="form-control rounded-5" type="search" placeholder="Search" aria-label="Search">
          <button class="btn colordark searchbtn ms-1 position-relative" type="submit"><i class="bi bi-search position-absolute translate-middle"></i></button>
        </form>
        <select class="form-select colordark mt-2 border-0" style="width:fit-content;">
  <option selected>Sort By</option>
  <option value="alpha-asc">Alphabetically A-Z</option>
  <option value="alpha-desc">Alphabetically Z-A</option>
  <option value="price-asc">Lowest Price</option>
  <option value="price-desc">Highest Price</option>
  <option value="date-asc">Date, New to Old</option>
  <option value="date-desc">Date, Old to New</option>
</select>
      </div>
  </div>

<section class="py-5">
  <div class="container">
    <div class="row justify-content-center">

    <!-- category -->
      <div class="col-lg-3">
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
               name="category" 
               value="" 
               id="checkbox<?=$category['id']?>">
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

           <?php if(empty(Products::listAllProducts())) :?>
          <?='<h3 class="colorxtradark">No record found</h3>'; ?>
          <?php else:?>
            <p class="colordark"><i class="bi bi-fire"></i>= Trending</p>
            <div class="row">
          <?php foreach(Products::listAllProducts() as $product) : ?>

          <div class="col-lg-6 mb-4 h-auto">
            <div class="row g-0 bg-light h-100">
            <div class="col-xl-5 col-lg-12 col-sm-5 d-flex flex-column justify-content-center p-xl-2">
                    <img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="img-fluid object-fit-cover">
                  </div> <!--col-xl-5 col-lg-12 col-sm-5-->
                  <div class="col-xl-7 col-lg-12 col-sm-7 d-flex flex-column justify-content-between">
                  <div class="pt-3">
                       <h5><?=$product['name']?><?=($product['trending']==1?'<i class="bi bi-fire colordark"></i>':'')?></h5>
                        <p class="text-muted mb-0" style="font-size:14px">RM <?=$product['price']?></p>
                        <p class="pe-3 mt-3 fw-normal" style="overflow-wrap:anywhere;font-size:16px"><?=substr($product['description'],0,50)?>...</p>
                  </div>
                    <div class="pe-3 pb-3 d-flex justify-content-end">
                      <form 
                          action="/cart" 
                          method="POST">
                          <button class="btn darkbtn text-white me-1">Add to cart</button>
                          <input 
                          type="hidden" 
                          name="productid" 
                          value="<?=$product['id'];?>">
                          <input type="hidden" name="name" value="<?=$product['name']?>">
                          <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_cart_item')?>">
                    </form>

                    <?php modalButton('view',$product['id'],'neutralbtn text-white','View') ?>
                </div>
                  </div> <!--col-xl-7 col-lg-12 col-sm-7-->
              </div> <!-- <div class="row">-->
          </div><!--<div class="col-lg-6">-->

          <!-- viewmodal-->
          <?php modalHeader('view',$product['id'],$product['name'],'modal-xl'); ?>
        <form 
          action="/cart" 
          method="POST">
        <input type="hidden" name="productid" value="<?=$product['id']?>">
        <input type="hidden" name="name" value="<?=$product['name']?>">
        <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_cart_item')?>">
        <div class="container-fluid" style="overflow-wrap:anywhere;">
        <div class="row">
          <div class="col-lg-6">
              <div class="imgwrap">
                  <img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="img-fluid">
                </div>
              </div> <!--col-lg-6-->
              <div class="col-lg-6">
                <h3 class="my-3 fw-semibold">Title :<?=$product['name'];?></h3>
                <h6><span class="fw-semibold">Author :</span><?=$product['authorname']?></h6>
                <p class=" fw-semibold">Category:</p>
                        <?php if(!empty(PivotCatPro::getCategoryByProduct($product['id']))):?>
                        <?php foreach(PivotCatPro::getCategoryByProduct($product['id']) as $index=> $category):?>
                            <span class="badge bg-secondary fs-6 px-3 py-2 fw-light"><?=Category::getCategoryById($category['category_id'])['name']?></span>
                        <?php endforeach; ?>
                        <?php else :?>
                            <span class="text-muted fs-6">---</span>
                        <?php endif; ?>
                <p><span class="fw-semibold">Price :</span> Rm<?=$product['price'];?></p>
                <p><span class="fw-semibold">Uploaded on :</span> <?=$product['created_at'];?></p>
                <h4 class="mt-5 fw-semibold">Description :</h4>
                <p><?=nl2br($product['description']);?></p>
            
            </div> <!--col-lg-6-->
            </div> <!--row-->
            </div> <!--container-fluid-->
                          <?php modalFooter('view','<button type="submit" class="btn bgdark">Add to Cart</button>'); ?>
                        </form>
      <!--end viewmodal-->
      <?php endforeach; ?> <!-- endforeach Products::listAllProducts() as $product) -->  
  
            </div> <!--col-lg-9-->
            <?php endif; ?> <!-- endif Products::listAllProducts() not empty -->
         
            
          </div> <!--row-->
          <div class="col-12 text-center pt-4">
            <p class="text-muted fst-italic">Stay tuned for many exciting new products...</p>
          </div>  
    </div> <!--container-->
</section> <!--section-->


<?php
require dirname(__DIR__)."/parts/footer.php";