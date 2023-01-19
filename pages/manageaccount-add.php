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

 CSRF::generateToken('add_account');

if($_SERVER['REQUEST_METHOD']=='POST')
{

    $_SESSION['error'] = FormValidation::validation(
      $_POST,
      [
        'username'=>'required',
        'email'=>'email_check',
        'password'=>'password_check',
        'confirm_password'=> 'is_password_match',
        'role'=>'required',
        'csrf_token' =>'add_account_token'
      ]
    );

    if(FormValidation::isEmailExist($_POST['email'])){
      $_SESSION['error'].=FormValidation::isEmailExist($_POST['email']);
    }//end - $user['email] != $_POST['email]

    if(empty($_SESSION['error']))
    {
        Users::add(
          $_POST['username'],
          $_POST['email'],
          $_POST['role'],
          $_POST['password']
        );

        CSRF::removeToken('add_account');

        $_SESSION['message']='Successfully add User "'.$_POST['username'].'" !';
        header('Location: /manageaccount');
        exit;
    }//end- empty($_SESSION['error'])

}//end - if request-method is post

require dirname(__DIR__)."/parts/adminheader.php";
?>
<a href="/manageaccount" class="colorlight mb-4"><?= $_SESSION['left-arrow']; ?> Back</a> 
<?php require dirname(__DIR__)."/parts/error_box.php";?>
<h1 class="colorxtradark text-center">Add New Account</h1>

<form action="<?= $_SERVER['REQUEST_URI']?>" method="POST">
          <div class="col-sm-4 mb-3">
                <label for="name" class="form-label">Username</label>
                <input type="text" class="form-control" id="name" name="username"/>
            </div>

              <div class="col-sm-4 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email"/>
            </div>
            
          <div class="row mb-3">
              <div class="col-sm-4">
                <label for="password" class="form-label">Password</label>
                <div class="passwrap">
                <input
                type="password"
                class="form-control input"
                id="password"
                name="password"
                />
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
              <option value="user">User</option>
              <option value="editor">Editor</option>
              <option value="admin">Admin</option>
            </select>
          </div>
            <button type="submit" class="btn bgdark mt-2">Add</button>
            <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_account')?>">
        </form>


<?php
require dirname(__DIR__)."/parts/footer.php";