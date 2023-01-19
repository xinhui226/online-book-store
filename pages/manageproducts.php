<?php 

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('delete_product');

if($_SERVER['REQUEST_METHOD']=='POST'){

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

}

require dirname(__DIR__)."/parts/adminheader.php";
?>

<div class="row justify-content-center"> 
   <?php require dirname(__DIR__)."/parts/error_box.php" ?>   
<div class="col-12 d-flex justify-content-between"><a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 
        <div class="d-inline-block">
            <form 
            class="d-flex" 
            method="GET" 
            action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input 
                class="form-control rounded-5" 
                type="search" 
                placeholder="Search" 
                aria-label="Search">
                <button 
                class="border-0 colordark searchbtn ms-1 position-relative" 
                type="submit">
                    <i class="bi bi-search position-absolute translate-middle"></i>
                </button>
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
        </div> <!--d-inline-block-->
    </div> <!--col-12 text-end-->

    <div class="col-12 mb-4">
        <h1 class="colorxtradark text-center">Products</h1>
    </div> <!--col-12-->

    <div class="col-lg-10 text-end">
        <a href="/manageproducts-add" class="btn bgdark colorlight mb-3">Add Product</a>
    </div>
    

    <?php if(empty(Products::listAllProducts())) :?>
    <?='<h3 class="colorxtradark">No record found</h3>'; ?>
   <?php else:?>
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
    <tr>
        <td><?=$index+1?></td>
        <td><?=$product['name']?><?=($product['trending']==1?'<i class="bi bi-fire colorxtradark"></i>':'')?></td>
        <td><?=$product['price']?></td>
        <td><img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="d-block mx-auto" style="max-width:150px;max-height:180px;"></td>
        <td class="d-flex align-items-center justify-content-end">

            <?php modalButton('view',$product['id'],'btn-sm') ?>
            <!-- viewmodal-->
            <?php modalHeader('view',$product['id'],$product['name'].' (ID :'.$product['id'].')','modal-xl'); ?>
            <input type="hidden" name="productid" value="<?=$product['id']?>">
            <div class="container-fluid" style="overflow-wrap:anywhere;">
          <div class="row">
              <div class="col-lg-6">
                  <div class="imgwrap">
                      <img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="img-fluid">
                    </div>
                    <h3 class="my-3">Title :<?=$product['name'];?></h3>
                    <h6>Author : <?=$product['authorname']?></h6>
                    <h6>Product ID : <?=$product['id']?></h6>
                    <h6>Category:</h6>
                        <?php if(!empty(PivotCatPro::getCategoryByProduct($product['id']))):?>
                        <?php foreach(PivotCatPro::getCategoryByProduct($product['id']) as $index=> $category):?>
                            <span class="badge bg-secondary fs-6 px-3 py-2 fw-light"><?=Category::getCategoryById($category['category_id'])['name']?></span>
                        <?php endforeach; ?>
                        <?php else :?>
                            <span class="text-muted fs-6">No record found</span>
                        <?php endif; ?>
                </div> <!--col-lg-6-->
                <div class="col-lg-6">
                    <h4>Description :</h4>
                <p><?=nl2br($product['description']);?></p>
                <p>Price : Rm<?=$product['price'];?></p>
                <p>Uploaded on : <?=$product['created_at'];?></p>
              </div> <!--col-lg-6-->
          </div> <!--row-->
        </div> <!--container-fluid-->
            <?php modalFooter('view'); ?>
            <!--end viewmodal-->
            
            <a href="/manageproducts-edit?id=<?=$product['id']?>" class="btn btn-sm">
            <i class="bi bi-pencil-square"></i>
            </a>

            <!--deletemodal-->
            <?php modalButton('delete',$product['id'],'btn-sm') ?>
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                <?php modalHeader('delete',$product['id'],$product['name'].' ( ID : '.$product['id'].' )'); ?>
                <h4 class="fw-light">Are you confirm to delete product "<?=$product['name'];?>" ?</h4>
                <input type="hidden" name="productid" value="<?=$product['id']?>">
                <input type="hidden" name="image" value="<?=$product['image']?>">
                <input type="hidden" name="product" value="<?=$product['name']?>">
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_product')?>">
                <div class="card border-0">
                <div class="imgwrap">
                    <img
                    src="./assets/uploads/<?=$product['image']?>"
                    class="d-block mx-auto mt-4"
                    style="max-width:400px;"
                    alt="<?=$product['name'];?>" 
                    />
                </div>
                <div class="card-body text-center">
                  <p class="text-secondary"><?=$product['authorname'];?></p>
                   <h5 class="card-title"><?=$product['name'];?></h5>
                   <p class="card-text">RM <?=$product['price'];?></p>
              </div> <!--card-body-->
            </div> <!--card-->
                <?php modalFooter('delete'); ?>
            </form>
            <!--end deletemodal-->

        </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div> <!--col-md-9-->
<?php endif;?> <!--end if(empty(Products::listAllProducts()))-->
</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";