<?php

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('add_category');
 CSRF::generateToken('delete_category');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['action']))
    {
        switch($_POST['action']){
            
            ///// add /////
             case 'add' :
                  $name = $_POST['category'];

                  //// error check //////
                  $_SESSION['error'] = FormValidation::validation
                  ( 
                    $_POST,
                    [
                        'category'=>'text',
                        'csrf_token'=>'add_category_token'
                    ] 
                );

                    if(FormValidation::isCategoryExist($name))
                    {
                        $_SESSION['error']=FormValidation::isCategoryExist($name);
                    } // end - if(FormValidation::isCategoryExist($name))

                    /////// trigger add function ////////
                    if(empty($_SESSION['error']))
                    {
                        Category::addCategory($name);

                        CSRF::removeToken('add_category');

                        $_SESSION['message']='Successfully add Category "'.$name.'" !';
                        header('Location: /managecategory');
                        exit;
                    }//end - !$_SESSION['error']
                    break;

            /////delete///////
             case 'delete' :

                ////error check//////
                $_SESSION['error'] = FormValidation::validation
                  ( 
                    $_POST,
                    [
                        'categoryid'=>'required',
                        'csrf_token'=>'delete_category_token'
                    ] 
                );

                /////trigger delete function/////
                if(empty($_SESSION['error']))
                    {
                        Category::deleteCategory($_POST['categoryid']);

                        CSRF::removeToken('delete_category');

                        $_SESSION['message']='Successfully delete Category "'.$_POST['category'].'" !';
                        header('Location: /managecategory');
                        exit;
                    }//end - empty($_SESSION['error'])
                   break;

        }  //end - switch
          
     }  //end - if (isset($_POST['action'])) 
 } 
            
require dirname(__DIR__)."/parts/adminheader.php";
?>

<div class="row"> 
 <?php require dirname(__DIR__)."/parts/error_box.php" ?>   
<div class="col-12 d-flex justify-content-between">
    <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 
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
                <option value="date-asc">Date, New to Old</option>
                <option value="date-desc">Date, Old to New</option>
            </select>
        </div> <!--d-inline-block-->
    </div> <!--col-12 -->

    <div class="col-12">
        <h1 class="colorxtradark text-center">Category</h1>
    </div> <!--col-12-->

    <div class="col-md-4 mb-2">
        <label for="addcategory">
            <h4 class="colorxtradark">Add Category</h4>
        </label>
        <form 
        action="<?=$_SERVER['REQUEST_URI']?>" 
        method="POST" 
        class="d-flex mb-3">
            <input 
            type="text" 
            name="category" 
            class="form-control rounded-4" 
            id="addcategory">
            <input 
            type="hidden" 
            name="action" 
            value="add">
            <button 
            type="submit" 
            class="btn bglight m-1 rounded-2 text-end" 
            id="show">
            Add
        </button>
        <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_category')?>">
    </form>
    
        </div> <!--col-md-4 mb-5-->

   <?php if(empty(Category::listAllCategory())) :?>
    <?='<h3 class="colorxtradark">No record found</h3>'; ?>
   <?php else:?>
    <div class="col-md-9 mx-auto">
    <table class="table table-bordered table-responsive bglight">
  <thead>
    <tr>
        <th scope="col">No.</th>
        <th scope="col">Category</th>
        <th scope="col">Created_at</th>
        <th scope="col" class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach(Category::listAllCategory() as $index=> $category) : ?>
    <tr>
        <td><?=$index+1?></td>
        <td><?=$category['name']?></td>
        <td><?=$category['created_at']?></td>
        <td class="d-flex align-items-center justify-content-end">
        <a
                href="/managecategory-edit?id=<?=$category['id']?>"
                class="btn btn-sm"
                ><i class="bi bi-pencil-square"></i
              ></a>

            <?php modalButton('delete',$category['id'],'btn-sm') ?>
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                <!--deletemodal-->
                <?php modalHeader('delete',$category['id'],'Category "'.$category['name'].'"'); ?>

                <h4 class="fw-light">Are you confirm to delete Category "<?=$category['name'];?>" ? (ID : <?=$category['id']?>)</h4>
                <input type="hidden" name="categoryid" value="<?=$category['id']?>">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="category" value="<?=$category['name']?>">
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_category')?>">

                <?php modalFooter('delete'); ?>
                <!--end deletemodal-->
                </form>

        </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div> <!--col-md-9-->
<?php endif;?> <!--end if(empty(Category::listAllCategory()))-->
</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";