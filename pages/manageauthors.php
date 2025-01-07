<?php 

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('add_author');
 CSRF::generateToken('delete_author');

if($_SERVER['REQUEST_METHOD']=='POST'){
  
    if(isset($_POST['action']))
    {
        switch($_POST['action']){
            case 'add' :
                 $_SESSION['error'] = FormValidation::validation
                 ( 
                    $_POST,
                    [
                        'author'=>'text',
                        'csrf_token' => 'add_author_token'
                    ] 
                );
                   if(empty($_SESSION['error']))
                   {
                 Authors::addAuthor($_POST['author']);
                 
                 CSRF::removeToken('add_author');
                 
                 $_SESSION['message']='Successfully add Author "'.$_POST['author'].'" !';
                 header('Location: /manageauthors');
                 exit;
                }//end - !$_SESSION['error']
                 break;

            case 'delete' :
                $_SESSION['error'] = FormValidation::validation
                 ( 
                    $_POST,
                    [
                        'authorid'=>'required',
                        'csrf_token' => 'delete_author_token'
                    ] 
                );
                   if(!$_SESSION['error'])
                   {

                        if(empty(Products::getProductByAuthor($_POST['authorid']))){
                            Authors::deleteAuthor($_POST['authorid']);
                            
                            CSRF::removeToken('delete_author');
                            
                            $_SESSION['message']='Successfully delete Author "'.$_POST['author'].'" !';
                            header('Location: /manageauthors');
                            exit;
                        }else
                        {
                            $_SESSION['error'] = 'Author is not allowed to be deleted !';
                        }// end - if empty(Products::getProductByAuthor())

                    }//end - !$_SESSION['error']
                  break;
       }  //end - switch
    } //end - isset($_POST['action'])
}
            
require dirname(__DIR__)."/parts/adminheader.php";
?>
<div class="row"> 
    
<div class="col-12 d-flex justify-content-between">
    <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 
            <?php require dirname(__DIR__)."/parts/searchbox.php"?>
    </div> <!--col-12 -->

    <div class="col-12">
        <h1 class="colorxtradark text-center">Authors</h1>
    </div> <!--col-12-->

    <div class="col-md-4 mb-2">
        <label for="addauthor">
            <h4 class="colorxtradark">Add Author</h4>
        </label>
        <form 
        action="<?=$_SERVER['REQUEST_URI']?>" 
        method="POST" 
        class="d-flex mb-3">
            <input 
            type="text" 
            name="author" 
            class="form-control rounded-4" 
            id="addauthor">
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
        <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_author')?>">
        </form>
        
   </div> <!--col-md-4 mb-5-->

        
   <?php if(isset($_POST['search']) && !empty($_POST['search'])) :?>
        
    <div class="col-md-9 mx-auto">
    <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
        <?php if(!empty(Authors::search($_POST['search']))):?>
        <table class="table table-bordered table-responsive bglight">
        <thead>
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Name</th>
                <th scope="col">Added On</th>
                <th scope="col" class="text-end">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach(Authors::search($_POST['search']) as $index=>$author):?>
                <tr>
                    <td><?=$index+1?></td>
                    <td><a class="colorxtradark text-decoration-none" href="/author_product?id=<?=$author['id']?>"><?=$author['name']?></a></td>
                    <td><?=tzFormat($author['created_at'])?></td>
                    <td class="d-flex align-items-center justify-content-end">
                        <a
                            href="/manageauthors-edit?id=<?=$author['id']?>"
                            class="btn btn-sm"
                            ><i class="bi bi-pencil-square"></i
                        ></a>

                        <?php modalButton('delete',$author['id'],'btn-sm') ?>
                            <form 
                            action="<?= $_SERVER['REQUEST_URI'];?>" 
                            method="POST">
                            
                            <!--deletemodal-->
                            <?php modalHeader('delete',$author['id'],'Author "'.$author['name'].'"'); ?>
                            <h4 class="fw-light">Are you confirm to delete Author "<?=$author['name'];?>" ? (ID : <?=$author['id']?>)</h4>
                                <input type="hidden" name="authorid" value="<?=$author['id']?>">
                                <input type="hidden" name="author" value="<?=$author['name']?>">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_author')?>">
                            <?php modalFooter('delete'); ?>
                            <!--end deletemodal-->
                            </form>
                    </td>
                </tr>
                <?php endforeach; ?>
        </tbody>
        </table>
      <?php else:?>
      <h3 class="colorxtradark">No record found</h3>
    <?php endif?> <!--if(!empty(Authors::search()))-->
</div> <!--col-md-9-->

<?php elseif(!empty(Authors::listAllAuthor())):?>

    <div class="col-md-9 mx-auto">
    <table class="table table-bordered table-responsive bglight">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Name</th>
            <th scope="col">Added On</th>
            <th scope="col" class="text-end">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach(Authors::listAllAuthor() as $index=> $author) : ?>
    <tr>
        <td><?=$index+1?></td>
        <td><a class="colorxtradark" href="/author_product?id=<?=$author['id']?>"><?=$author['name']?></a></td>
        <td><?=tzFormat($author['created_at'])?></td>
        <td class="d-flex align-items-center justify-content-end">
            <a
                href="/manageauthors-edit?id=<?=$author['id']?>"
                class="btn btn-sm"
                ><i class="bi bi-pencil-square"></i
              ></a>

            <?php modalButton('delete',$author['id'],'btn-sm') ?>
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                
                <!--deletemodal-->
                <?php modalHeader('delete',$author['id'],'Author "'.$author['name'].'"'); ?>
                <h4 class="fw-light">Are you confirm to delete Author "<?=$author['name'];?>" ? (ID : <?=$author['id']?>)</h4>
                    <input type="hidden" name="authorid" value="<?=$author['id']?>">
                    <input type="hidden" name="author" value="<?=$author['name']?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_author')?>">
                <?php modalFooter('delete'); ?>
                <!--end deletemodal-->
                </form>

        </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
</div> <!--col-md-9-->

<?php endif;?> <!--end if(isset($_POST['search'])&&!empty()) -->

</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";