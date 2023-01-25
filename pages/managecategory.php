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
</div><!--d-flex justify-content-between-->        

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

        <?php if(isset($_POST['search']) && !empty($_POST['search'])) :?>

            <div class="col-md-9 mx-auto">
            <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
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
            <?php foreach(Category::search($_POST['search']) as $index=> $category) : ?>
            <tr>
                <td><?=$index+1?></td>
                <td><a class="colorxtradark text-decoration-none" href="/category_product?id=<?=$category['id']?>"><?=$category['name']?></a></td>
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

   <?php elseif(!isset($_POST['search'])&&!empty(Category::listAllCategory())):?>
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
        <td><a class="colorxtradark text-decoration-none" href="/category_product?id=<?=$category['id']?>"><?=$category['name']?></a></td>
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

<?php else :?>
    <h3 class="colorxtradark">No record found</h3>
<?php endif;?> <!--end if(isset($_POST['search']&&!empty(Category::search())))-->
</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";