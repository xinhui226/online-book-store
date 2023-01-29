<?php 

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
    <?php require dirname(__DIR__)."/parts/searchbox.php"?>
        
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
               <?=in_array($category['id'],$checkcategory)?'checked':''?>
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


          <!-- if(isset($_GET['category'])) -->
            <?php if(isset($_GET['category'])): ?>

                                  <?php if(isset($_POST['search'])&&!empty($_POST['search'])) :?>
                                  <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
                                  <small class="colordark"><i class="bi bi-fire"></i>= Trending</small>
                                  <div class="row">

                                                        <?php foreach($checkcategory as $categoryid) {?>
                                                        <h4 class="colorneutral"><?=ucfirst(Category::getCategoryById($categoryid)['name']) ?> :</h4>
                                                        <?php
                                                              foreach(Products::userSearch($_POST['search']) as $product){
                                                              foreach(PivotCatPro::getProductByCategory($categoryid) as $categoryproduct) 
                                                                {
                                                                  if($product['id']==$categoryproduct['id']) require dirname(__DIR__)."/parts/productpage_display.php";
                                                                }
                                                              } 

                                                        } // end - foreach($checkcategory as $categoryid)
                                                        ?>

                                  <?php  else :?>
                                  <small class="colordark"><i class="bi bi-fire"></i>= Trending</small>
                                  <div class="row">

                                                        <?php foreach($checkcategory as $categoryid) {?>
                                                        <h4 class="colorneutral"><?=ucfirst(Category::getCategoryById($categoryid)['name']) ?> :</h4>

                                                        <?php if(!empty(PivotCatPro::inStockProductByCategory($categoryid))) {
                                                                  foreach(PivotCatPro::inStockProductByCategory($categoryid) as $product) 
                                                                  {
                                                                    require dirname(__DIR__)."/parts/productpage_display.php";
                                                                  }
                                                              } else
                                                                  { 
                                                                    echo '<h6 class="colordark">No record found</h6>';
                                                                  }
                                                        } // end - foreach($checkcategory as $categoryid)

                                  endif ?> <!--end - if(isset($_POST['search'])&&!empty($_POST['search']))-->


            <!-- else : - if(isset($_GET['category']))-->              
            <?php else :?> 

                              <?php if(isset($_POST['search'])&&!empty($_POST['search'])) :?>
                              <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
                              <small class="colordark"><i class="bi bi-fire"></i>= Trending</small>
                              <div class="row">

                                                <?php if(!empty(Products::userSearch($_POST['search']))) 
                                                {
                                                  foreach(Products::userSearch($_POST['search']) as $product){ 
                                                    require dirname(__DIR__)."/parts/productpage_display.php";
                                                  } 
                                                } 
                                                else{ 
                                                  echo '<h3 class="colordark">No record found</h3>';
                                                }?> 
                                                <!--end -if (!empty(Products::userSearch()))-->

                              
                              <?php  elseif(!empty(Products::listInStockProducts())) :?>
                              <small class="colordark"><i class="bi bi-fire"></i>= Trending</small>
                              <div class="row">

                                                  <?php foreach(Products::listInStockProducts() as $product) { 
                                                  require dirname(__DIR__)."/parts/productpage_display.php"; 
                                                  } ?>
                              
                              <?php endif ?> <!--end - if(isset($_POST['search'])&&!empty($_POST['search']))-->
            

            <!-- end - if(isset($_GET['category']))-->
            <?php endif; ?> 

          </div> <!--row-->

          <div class="col-12 text-center pt-4">
            <p class="text-muted fst-italic">Stay tuned for many exciting new products...</p>
          </div>  
      </div> <!--col-lg-9-->
    </div> <!--container-->
</section> <!--section-->


<?php
require dirname(__DIR__)."/parts/footer.php";