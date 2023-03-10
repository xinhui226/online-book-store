<?php

if(!Authentication::whoCanAccess('editor'))
{
     header('Location: /');
     exit;
}

$category = $_GET['id'];

require dirname(__DIR__)."/parts/adminheader.php"
?>

<a href="/managecategory" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 

<div class="row my-4">
<div class="col-sm-4 colorxtradark">
    <h4>Category : <?=Category::getCategoryById($category)['name']?></h4>
</div>
<div class="col-md-10 colorxtradark mt-3">
    <h4>Product :</h4>
    <h6 ><i class="bi bi-fire"></i>= Trending</h6>

    <?php if(!empty(PivotCatPro::getProductByCategory($category))) :?>
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
    <?php foreach(PivotCatPro::getProductByCategory($category) as $index=> $product) : ?>
    
    <?php require dirname(__DIR__)."/parts/foreach_tablerow_product.php"?>

    <?php endforeach;?> <!--PivotCatPro::getProductByCategory($category)-->    
    </tbody>
</table>    

<?php else:?>
    <h3 class="colorxtradark">No record found</h3>
<?php endif;?>    
</div><!--row-->


<?php require dirname(__DIR__)."/parts/footer.php";

