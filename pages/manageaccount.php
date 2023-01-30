<?php 

if(!Authentication::whoCanAccess('admin'))
{
   if(Authentication::isEditor())
   {
       header('Location: /dashboard');
       exit;
   } // end if user is editor
   else{
       header('Location: /');
       exit;
   }// end else
}

CSRF::generateToken('delete_account');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(!isset($_POST['search']))
    {
    $_SESSION['error'] = FormValidation::validation
    ( 
      $_POST,
      [
          'userid'=>'required',
          'csrf_token'=>'delete_account_token'
      ] 
  );

      if(empty($_SESSION['error']))
      {
          Users::delete($_POST['userid']);

          CSRF::removeToken('delete_account');

          $_SESSION['message']='Successfully delete User "'.$_POST['user'].'" !';
          header('Location: /manageaccount');
          exit;
      }//end - empty($_SESSION['error'])
    }//end-if(!isset($_POST['search']))
}

require dirname(__DIR__)."/parts/adminheader.php";
?>

<div class="row justify-content-center"> 

   <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 

   <h1 class="colorxtradark text-center">Manage Account</h1>
   
    <?php require dirname(__DIR__)."/parts/searchbox.php"?>
        
        <div class="col-10 mt-3 text-end">
        <a href="/manageaccount-add" class="btn bgdark colorlight">Add New Account</a>
    </div>

    <?php if(isset($_POST['search']) && !empty($_POST['search'])) :?>
    <div class="col-md-10 mt-3">
    <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
    <?php if(!empty(Users::search($_POST['search']))):?>
    <table class="table table-bordered table-responsive bglight">
    <thead>
        <tr>
            <th scope="col">No.</th>
            <th scope="col">Username</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col" class="text-end">Action</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach(Users::search($_POST['search']) as $index => $user) : ?>
        <tr>
            <td><?=$index+1?></td>
            <td><?=$user['username'].($user['id']==$_SESSION['user']['id']?' <i class="bi bi-person-circle"></i>':'')?></td>
            <td><?=$user['email']?></td>
            <td><?=$user['role']?></td>
            <td class="d-flex align-items-center justify-content-end">

                <!-- viewmodal-->
                <?php modalButton('view',$user['id'],'btn-sm') ?>
                <?php modalHeader('view',$user['id'],'User "'.$user['username'].'"'); ?>

                    <p>ID : <?=$user['id'];?></p>
                    <p>Username : <?=$user['username'];?></p>
                    <p>Email : <?=$user['email'];?></p>
                    <p>Role : <?=$user['role'];?></p>

                <?php modalFooter('view'); ?>
                <!--end viewmodal-->
                <?php if($user['role']!=='admin'):?>

                <a href="/manageaccount-edit?id=<?=$user['id']?>" class="btn btn-sm">
                <i class="bi bi-pencil-square"></i>
                </a>
                
                <!--deletemodal-->
                <?php modalButton('delete',$user['id'],'btn-sm') ?>
                <?php endif; ?><!-- end - if($user['role']!='admin)-->
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                    <?php modalHeader('delete',$user['id'],$user['username']); ?>
                    <h4 class="fw-light my-2">Are you confirm to delete user "<?=$user['username'];?>" ?</h4>
                    <input type="hidden" name="userid" value="<?=$user['id']?>">
                    <input type="hidden" name="user" value="<?=$user['username']?>">
                    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_account')?>">
                    
                    <p>ID : <?=$user['id'];?></p>
                    <p>Username : <?=$user['username'];?></p>
                    <p>Email : <?=$user['email'];?></p>
                    <p>Role : <?=$user['role'];?></p>
                
                    <?php modalFooter('delete'); ?>
                </form>
                <!--end deletemodal-->

            </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
    <?php else:?>
    <h3 class="colorxtradark">No record found</h3>
    <?php endif ?> <!--end - if(!empty(Users::search()))-->
</div> <!--col-md-10-->

    <?php elseif(!empty(Users::getAllUsers())) :?>
    <div class="col-md-10 mt-3">
    <table class="table table-bordered table-responsive bglight">
  <thead>
    <tr>
        <th scope="col">No.</th>
        <th scope="col">Username</th>
        <th scope="col">Email</th>
        <th scope="col">Role</th>
        <th scope="col" class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach(Users::getAllUsers() as $index => $user) : ?>
    <tr>
        <td><?=$index+1?></td>
        <td><?=$user['username'].($user['id']==$_SESSION['user']['id']?' <i class="bi bi-person-circle"></i>':'')?></td>
        <td><?=$user['email']?></td>
        <td><?=$user['role']?></td>
        <td class="d-flex align-items-center justify-content-end">

            <!-- viewmodal-->
            <?php modalButton('view',$user['id'],'btn-sm') ?>
            <?php modalHeader('view',$user['id'],'User "'.$user['username'].'"'); ?>

                <p>ID : <?=$user['id'];?></p>
                <p>Username : <?=$user['username'];?></p>
                <p>Email : <?=$user['email'];?></p>
                <p>Role : <?=$user['role'];?></p>

            <?php modalFooter('view'); ?>
            <!--end viewmodal-->

            
            <a href="/manageaccount-edit?id=<?=$user['id']?>" class="btn btn-sm">
                <i class="bi bi-pencil-square"></i>
            </a>
            
            <!--deletemodal-->
            <?php if($user['id']!==$_SESSION['user']['id']):?>
            <?php modalButton('delete',$user['id'],'btn-sm') ?>
            <?php endif; ?> <!-- end - if($user['id']!==$_SESSION['user']['id'])-->
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                <?php modalHeader('delete',$user['id'],$user['username']); ?>
                <h4 class="fw-light my-2">Are you confirm to delete user "<?=$user['username'];?>" ?</h4>
                <input type="hidden" name="userid" value="<?=$user['id']?>">
                <input type="hidden" name="user" value="<?=$user['username']?>">
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_account')?>">
                
                <p>ID : <?=$user['id'];?></p>
                <p>Username : <?=$user['username'];?></p>
                <p>Email : <?=$user['email'];?></p>
                <p>Role : <?=$user['role'];?></p>
              
                <?php modalFooter('delete'); ?>
            </form>
            <!--end deletemodal-->

        </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
    </table>
</div> <!--col-md-10-->
<?php endif;?> <!--end if(empty(Users::getAllUsers()))-->



</div> <!--row -->

<?php
require dirname(__DIR__)."/parts/footer.php";