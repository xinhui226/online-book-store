<?php

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('add_product');

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
           'csrf_token'=>'add_product_token'
       ]
  );

 if(FormValidation::checkImageValid($_FILES['image']))
    {
      $_SESSION['error'] .= FormValidation::checkImageValid($_FILES['image']);
    }

 if(empty($_SESSION['error'])){

        $id = Products::addProduct($name,$price,$author,$description,Products::imageUpload($_FILES['image']),!empty($_POST['trending'])?'1':null);

        if(!empty($_POST['category']))
        {
            
            foreach($_POST['category'] as $category){
                PivotCatPro::insert(
                    $id,
                    $category
                );
            } //end - foreach
        } // end - if !empty $_POST['category']

        CSRF::removeToken('add_product');

        $_SESSION['message'] = 'Successfully upload Product "'.$name.'" !';
        header('Location: /manageproducts');
        exit;

    } // end - if empty($_SESSION['error'])
}

require dirname(__DIR__)."/parts/adminheader.php";

?>
<a href="/manageproducts" class="colorlight mb-4"><?= $_SESSION['left-arrow']; ?> Back</a> 
<h1 class="colorxtradark text-center mb-4">Add New Product</h1>

     <?php require dirname(__DIR__)."/parts/error_box.php" ?> 

<form action="<?=$_SERVER['REQUEST_URI']?>" method="POST" enctype="multipart/form-data">
    <div class="mb-3 col-md-8">
        <label for="bookname" class="form-label">Book Name</label>
        <input type="text" class="form-control" id="bookname" name="bookname">
    </div>
    <div class="row">
        <div class="mb-3 col-md-3">
            <label for="productprice" class="form-label">Price (RM)</label>
            <input type="text" class="form-control" id="productprice" name="price">
        </div>

        <div class="col-md-4 d-flex align-items-center">
        <label for="trending" class="form-label">Trending</label>
        <input type="checkbox" id="trending" name="trending">
        </div>
   
        <div class="mb-3 col-md-3">
            <label for="authorname" class="form-label">Author</label>
            <select class="form-select" id="authorname" name="authorname">
                <?php if(empty(Authors::listAllAuthor())) :?>
                    <option disabled>No record found</option>
                <?php else : ?>
                    <option value="" selected>--Select--</option>
                <?php foreach (Authors::listAllAuthor() as $author): ?>
                <option value="<?=$author['id']?>"><?=$author['name']?></option>
                <?php endforeach; ?> <!--end - foreach listAllAuthor-->
                <?php endif; ?> <!--end -if empty -->
            </select>
    </div><!--mb-3 col-md-3-->

        <div class="mb-3 col-md-5">
            <label for="category" class="form-label">Category</label>
            <select class="category-multipleselect form-control" name="category[]" id="category" multiple="multiple">
            <?php if(empty(Category::listAllCategory())) :?>
                    <option disabled>No record found</option>
                    <?php else : ?>
                    <?php foreach (Category::listAllCategory() as $category): ?>
                    <option value="<?=$category['id']?>"><?=$category['name']?></option>
                    <?php endforeach; ?> <!--end - foreach listAllCategory-->
            <?php endif;?> <!--end endif (empty category)-->
            </select>
        </div> <!--mb-3 col-md-5-->

 </div> <!--row-->
 

    <div class="mb-3 col-md-8">
        <label for="productdesc" class="form-label">Description</label>
        <textarea class="form-control" id="productdesc" rows="3" name="description"></textarea>
    </div>
    <div class="mb-3 col-md-6">
        <label 
        for="formFile" 
        class="form-label">
        Upload Image
    </label>
    <input 
    class="form-control" 
    type="file" 
    id="formFile"
    name="image">
</div>
<button type="submit" class="btn bgdark">Add</button>
<input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_product')?>">
    </form><!-- form file -->
  
<?php

require dirname(__DIR__)."/parts/footer.php";