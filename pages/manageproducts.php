<?php 

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('delete_product');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(!isset($_POST['search'])){
    $_SESSION['error'] = FormValidation::validation
    ( 
      $_POST,
      [
          'productid'=>'required',
          'csrf_token'=>'delete_product_token'
      ] 
  );

      if(empty($_SESSION['error']))
      {
          unlink("./assets/uploads/".$_POST['image']);
          Products::deleteProduct($_POST['productid']);

          CSRF::removeToken('delete_product');

          $_SESSION['message']='Successfully delete Product "'.$_POST['product'].'" !';
          header('Location: /manageproducts');
          exit;
      }//end - empty($_SESSION['error'])

    } //if(!isset($_POST['search']))
}

require dirname(__DIR__)."/parts/adminheader.php";
?>

<div class="row justify-content-center">  

   <div class="d-flex justify-content-between">
   <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 
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

    <div class="col-12 mb-4">
        <h1 class="colorxtradark text-center">Products</h1>
    </div> <!--col-12-->

    <div class="col-lg-10 text-end">
        <a href="/manageproducts-add" class="btn bgdark colorlight mb-3">Add Product</a>
    </div>
    

    <?php if(isset($_POST['search'])&&!empty($_POST['search'])):?>
        <div class="col-md-10">
        <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
    <h6 class="colorxtradark"><i class="bi bi-fire"></i>= Trending</h6>
    <table class="table table-bordered table-responsive bglight">
  <thead>
    <tr>
        <th scope="col">No.</th>
        <th scope="col">Product</th>
        <th scope="col">Price (RM)</th>
        <th scope="col">Image</th>
        <th scope="col" class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach(Products::search($_POST['search']) as $index=> $product) : ?>

        <?php require dirname(__DIR__)."/parts/foreach_tablerow_product.php";?>
        
    <?php endforeach; ?>
    </tbody>
    </table>
</div> <!--col-md-9-->
    <?php elseif(!isset($_POST['search'])&&!empty(Products::listAllProducts())) :?>
    <div class="col-md-10">
    <h6 class="colorxtradark"><i class="bi bi-fire"></i>= Trending</h6>
    <table class="table table-bordered table-responsive bglight">
  <thead>
    <tr>
        <th scope="col">No.</th>
        <th scope="col">Product</th>
        <th scope="col">Price (RM)</th>
        <th scope="col">Image</th>
        <th scope="col" class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach(Products::listAllProducts() as $index=> $product) : ?>
        <?php require dirname(__DIR__)."/parts/foreach_tablerow_product.php";?>
    <?php endforeach; ?>
    </tbody>
    </table>
</div> <!--col-md-9-->

<?php else :?>
    <h3 class="colorxtradark">No record found</h3>
<?php endif;?> <!--end if(empty(Products::listAllProducts()))-->
</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";