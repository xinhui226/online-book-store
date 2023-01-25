<?php

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('edit_product');

$product = Products::getProductById($_GET['id']);

$categoryid =[];
foreach(PivotCatPro::getCategoryByProduct($product['id']) as $index => $pivot )
{
    $categoryid[]=$pivot['id'];
}

if($_SERVER['REQUEST_METHOD']=='POST')
{  
    $name=$_POST['bookname'];
    $price=$_POST['price'];
    $author=$_POST['authorname'];
    $description=$_POST['description'];

 $_SESSION['error'] = FormValidation::validation(
   $_POST,
       [
           'bookname'=>'text',
           'price'=>'numeric',
           'authorname'=>'required',
           'description'=>'required',
           'csrf_token'=>'edit_product_token'
       ]
  );

 $updateNewImage = !empty($_FILES['new_image']['name']);

 if($updateNewImage){

     if(FormValidation::checkImageValid($_FILES['new_image']))
     {
         $_SESSION['error'] .= FormValidation::checkImageValid($_FILES['new_image']);
        }// end - FormValidation check

 }// end - if $updateNewImage

 if(empty($_SESSION['error'])){

   if($updateNewImage){
        unlink("./assets/uploads/".$product['image']);
   } // end - if $updateNewImage

        Products::updateProduct(
        $product['id'],
        $name,
        $price,
        $author,
        $description,
        ($updateNewImage? Products::imageUpload($_FILES['new_image']):null),
        (!empty($_POST['trending'])? 1:0)
    );

    $newcat =[];
    if(empty($_POST['newcategory']))
    {
        $newcat[]=false;
    }else{
        foreach($_POST['newcategory'] as $newcategory){
            $newcat[] =$newcategory;
        }
    }

    if($newcat!=$categoryid){
        foreach($categoryid as $category)
            {
                if(!in_array($category,$newcat))
                {
                    PivotCatPro::delete(
                        $product['id'],
                        $category
                    );
                }// end - if(!in_array($category,$newcat))
            }// end -   foreach($categoryid as $category)
    }//end - if($newcat!=$categoryid)
    
    if(!empty($_POST['newcategory']))
    {
        foreach($newcat as $newcategory)
        {
        if(!in_array($newcategory,$categoryid))
            {
            PivotCatPro::insert(
                $product['id'],
                $newcategory
            );
            }// end - if(!in_array($newcategory,$categoryid))
        }// end - foreach $_POST['newcategory']
    }// end - if(!empty($_POST['newcategory']))

    CSRF::removeToken('edit_product');

    $_SESSION['message']='Successfully update Product "'.$_POST['bookname'].'" !';
    header('Location: /manageproducts');
    exit;
 } // end - if (empty($_SESSION['error']))

}
require dirname(__DIR__)."/parts/adminheader.php";
?>

<a href="/manageproducts" class="colorlight mb-5"><?= $_SESSION['left-arrow']; ?> Back</a> 
<h1 class="colorxtradark text-center mb-4">Edit Product "<?=$product['name']?>"</h1>

<form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST" enctype="multipart/form-data">

        <div class="mb-3 col-md-6">
            <label for="productname" class="form-label">Book Name</label>
            <input type="text" class="form-control" id="productname" name="bookname" value="<?=$product['name']?>">
        </div>
        <div class="row">
            <div class="mb-3 col-md-3">
                <label for="productprice" class="form-label">Price</label>
                <input type="text" class="form-control" id="productprice" name="price" value="<?=$product['price']?>">
            </div>
       
        <div class="col-md-4 d-flex align-items-center">
        <label for="trending" class="form-label">Trending</label>
        <input type="checkbox" id="trending" name="trending" <?=($product['trending']==1?'checked':'')?>>
        </div>

    </div> <!--row-->
    
    <div class="row">

        <div class="mb-3 col-md-3">
            <label for="authorname" class="form-label">Author</label>
            <select class="form-select" id="authorname" name="authorname">
            <?php if(empty(Authors::listAllAuthor())) :?>
                    <option disabled>No record found</option>
                    <?php else : ?>
                    <option hidden selected value="<?=$product['authorid']?>"><?=$product['authorname']?></option>
                    <?php foreach (Authors::listAllAuthor() as $author): ?>
                    <option value="<?=$author['id']?>"><?=$author['name']?></option>
                    <?php endforeach; ?> <!--end - foreach listAllAuthor-->
            <?php endif;?> <!--end endif (empty author)-->
            </select>
        </div> <!-- mb-3 col-md-3 -->

        <div class="mb-3 col-md-4">
            <label for="category" class="form-label">Category</label>
            <select class="category-multipleselect form-control" name="newcategory[]" id="category" multiple="multiple">
            <?php if(empty(Category::listAllCategory())) :?>
                    <option disabled>No record found</option>
                    <?php else : ?>
                    <?php foreach (Category::listAllCategory() as $category): ?>
                    <option value="<?=$category['id']?>" <?=(in_array($category['id'],$categoryid)?'selected':'')?>><?=$category['name']?></option>
                    <?php endforeach; ?> <!--end - foreach listAllCategory-->
            <?php endif;?> <!--end endif (empty category)-->
            </select>
        </div> <!--mb-3 col-md-4-->

 </div> <!--row-->

        <div class="mb-3 col-md-6">
            <label for="productdesc" class="form-label">Description</label>
            <textarea class="form-control" id="productdesc" rows="3" name="description"><?=nl2br($product['description'])?></textarea>
        </div>
        <div class="mb-3 col-md-6">
        <label 
            for="newimage" 
            class="form-label">
            Upload Image
        </label>
        <input 
            class="form-control" 
            type="file" 
            id="newimage"
            name="new_image">
        </div>
                <h6>Current Image :</h6>
                <img
                src="./assets/uploads/<?=$product['image']?>"
                style="max-width:320px;"
                alt="<?=$product['name'];?>" 
                />
                <br>
    <button type="submit" class="btn bgdark mt-2">Update</button>
    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('edit_product')?>">
</form>
<?php

require dirname(__DIR__)."/parts/footer.php";