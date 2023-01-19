<?php

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('edit_category');

$category = Category::getCategoryById($_GET['id']);

if($_SERVER['REQUEST_METHOD']=='POST'){

  $newcategory = trim($_POST['category']);

  if($newcategory!=$category['name']){

        $_SESSION['error'] = FormValidation::validation
        ( 
          $_POST, 
          [
            'category'=>'text',
            'csrf_token'=>'edit_category_token'
          ] 
      );

        if(FormValidation::isCategoryExist($newcategory))
        {
            $_SESSION['error'].=FormValidation::isCategoryExist($newcategory);
        } // end - if(FormValidation::isCategoryExist($newcategory))

        if(empty($_SESSION['error']))
        {
          Category::updateCategory($_POST['categoryid'],$newcategory);

          CSRF::removeToken('edit_category');

          $_SESSION['message']='Successfully update Category "'.$category['name'].'" to "'.$newcategory.'" !';
          header('Location: /managecategory');
          exit;
        }//end - empty($_SESSION['error'])
 } //end - if($newcategory!=$category['name'])

}

require dirname(__DIR__)."/parts/adminheader.php";
?>

<?php require dirname(__DIR__)."/parts/error_box.php" ?>
<a href="/managecategory" class="colorlight mt-5"><?= $_SESSION['left-arrow']; ?> Back</a> 
<div class="row py-5 text-center justify-content-center align-items-center h-75">
  <h1 class="colorxtradark">Edit Category "<?=$category['name'];?>"</h1>
  <div class="col-sm-4">
  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST">
    <input type="text" name="category" value="<?=$category['name'];?>" class="form-control">
    <input type="hidden" name="categoryid" value="<?=$category['id'];?>" class="form-control">
    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('edit_category')?>">
    <button type="submit" class="btn bgdark mt-3">Update</button>
  <form>
</div>
</div>

<?php
require dirname(__DIR__)."/parts/footer.php";