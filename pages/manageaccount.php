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

}

require dirname(__DIR__)."/parts/adminheader.php";
?>

<div class="row justify-content-center"> 
<?php require dirname(__DIR__)."/parts/error_box.php";?>

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
                <option value="date-asc">Date, New to Old</option>
                <option value="date-desc">Date, Old to New</option>
            </select>
        </div> <!--d-inline-block-->
    </div> <!--col-12 text-end-->

        <h1 class="colorxtradark text-center">Manage Account</h1>

        <div class="col-lg-4 d-flex align-items-center">
            <label for="role">Role :</label>
        <select class="form-select colordark ms-3" style="width:fit-content;" id="role">
            <option selected>--Select--</option>
            <option value="admin">Admin</option> <!-- <=($user['role']=='...' ? 'selected' : '') -->
            <option value="editor">Editor</option> <!-- <=($user['role']=='...' ? 'selected' : '') -->
            <option value="user">User</option> <!-- <=($user['role']=='...' ? 'selected' : '') -->
        </select>
        </div>
        
        <div class="col-lg-6 text-end">
        <a href="/manageaccount-add" class="btn bgdark colorlight">Add New Account</a>
    </div>

    <?php if(empty(Users::getAllUsers())) :?>
    <?='<h3 class="colorxtradark">No record found</h3>'; ?>
   <?php else:?>
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
        <td><?=$user['username']?></td>
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
            <?php modalButton('delete',$user['id'],'btn-sm') ?>
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
</div> <!--col-md-9-->
<?php endif;?> <!--end if(empty(Users::getAllUsers()))-->



</div> <!--row -->

<?php
require dirname(__DIR__)."/parts/footer.php";