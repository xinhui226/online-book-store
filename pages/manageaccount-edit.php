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

 CSRF::generateToken('edit_account');

 $user = Users::getUserById($_GET['id']);

if($_SERVER['REQUEST_METHOD']=='POST')
{

  $password_changed =
  (
  isset($_POST['password'])&&!empty($_POST['password'])||
  isset($_POST['confirm_password'])&&!empty($_POST['comfirm_password'])
  ? true : false
  );

    $rules = [
      'username'=>'required',
      'email'=>'email_check',
      'role'=>'required',
      'csrf_token' =>'edit_account_token'
    ];

    if($password_changed){
      $rules['password']='password_check';
      $rules['confirm_password']= 'is_password_match';
    }

    $_SESSION['error'] = FormValidation::validation(
      $_POST,
      $rules
    );

    if($user['email']!==$_POST['email']){
      $_SESSION['error'].=FormValidation::isEmailExist($_POST['email']);
    }//end - $user['email] != $_POST['email]

    if(empty($_SESSION['error']))
    {
        Users::update(
          $user['id'],
          $_POST['username'],
          $_POST['email'],
          $_POST['role'],
          ($password_changed? $_POST['password']:null)
        );

        CSRF::removeToken('edit_account');

        $_SESSION['message']='Successfully update User "'.$_POST['username'].'" !';
        header('Location: /manageaccount');
        exit;
    }//end- empty($_SESSION['error'])

}//end - if request-method is post
 
require dirname(__DIR__)."/parts/adminheader.php";
?>
<a href="/manageaccount" class="colorlight mb-4"><?= $_SESSION['left-arrow']; ?> Back</a>
<h1 class="colorxtradark text-center">Edit Account</h1>

        <form action="<?= $_SERVER['REQUEST_URI']?>" method="POST">
          <div class="col-sm-4 mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="username" value="<?=$user['username']?>"/>
            </div>

              <div class="col-sm-4 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?=$user['email']?>"/>
            </div>
            
          <div class="row mb-3">
              <div class="col-sm-4">
                <label for="password" class="form-label">Password</label>
                <div class="passwrap">
                <input
                  type="password"
                  class="form-control input"
                  id="password"
                  name="password"/>
                    <i class="bi bi-eye-slash eyeicon" id="icon"></i>
                    </div>
              </div>
              <div class="col-sm-4">
                <label for="confirm_password" class="form-label"
                  >Confirm Password</label
                >
                <div class="passwrap">
                <input
                  type="password"
                  class="form-control input"
                  id="confirm_password"
                  name="confirm_password"/>
                    <i class="bi bi-eye-slash eyeicon" id="icon2"></i>
                    </div>
              </div>
          </div>

          <div class="col-sm-3 mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select form-select-md form-control mb-3" id="role" name="role" aria-label=".form-select-lg example">
              <option value="user" <?=($user['role']=='user' ? 'selected' : '') ?>>User</option>
              <option value="editor" <?=($user['role']=='editor' ? 'selected' : '') ?>>Editor</option>
              <option value="admin" <?=($user['role']=='admin' ? 'selected' : '') ?>>Admin</option>
            </select>
          </div>
            <button type="submit" class="btn bgdark mt-2">Update</button>
            <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('edit_account')?>">
        </form>


<?php

require dirname(__DIR__)."/parts/footer.php";