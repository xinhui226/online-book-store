<?php

  if(Authentication::whoCanAccess('editor'))
  {
    header('Location: /dashboard');
    exit;
  }
  elseif(Authentication::isUser())
  {
    header('Location: /');
    exit;
  }

  CSRF::generateToken('signup_form');

if($_SERVER['REQUEST_METHOD']=='POST'){
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $_SESSION['error'] = FormValidation::validation(
      $_POST,
      [
        'username'=>'required',
        'email'=>'email_check',
        'password'=>'password_check',
        'confirm_password'=>'is_password_match',
        'csrf_token'=>'signup_form_token'
      ]
      );

    if(FormValidation::isEmailExist($email))
    {
      $_SESSION['error'].=FormValidation::isEmailExist($email);
    }// end -if FormValidation::isEmailExist

    if(empty($_SESSION['error']))
    {
     $userid = Authentication::signup(
                $username,
                $email,
                $password
                );

      Authentication::setSession($userid);

      CSRF::removeToken('signup_form');

      $_SESSION['message']='Welcome, '.$_SESSION['user']['username'].' !';
      if(Authentication::isUser())
      {
        header('Location: /');
        exit;
      }elseif(Authentication::isEditor()||Authentication::isAdmin()){
        header('Location: /dashboard');
        exit;
      }
      
    }// end - if empty($_SESSION['error'])
};

require dirname(__DIR__)."/parts/header.php";

?>
<body class="bglight">
<?php require "parts/error_box.php"; ?>
    <div 
    class="container-fluid pe-0 d-flex flex-column align-items-center" 
    style="padding-top:100px;">
    <div class="row justify-content-end g-0 mb-1">
      <div class="col-md-4 bg-white d-flex flex-column justify-content-center">
        <!-- sign up form -->
        <div 
        class="card rounded-0 shadow-md border-0 px-3" 
        style="max-width: 500px;">
        <div class="card-body">
            <h5 class="card-title text-center text-secondary py-2 border-bottom">
              Start Your Journey with Us
            </h5>
            
            <form 
            action="<?php echo $_SERVER['REQUEST_URI']; ?>" 
            method="POST">
            <div class="mb-3">
              <label 
              for="username" 
              class="form-label text-secondary">
              Username
            </label>
            <input
            type="text"
            class="form-control input"
            id="username"
            name="username"
            />
          </div>
          <div class="mb-3">
            <label 
            for="email" 
            class="form-label text-secondary">
            Email address
            
          </label>
          <input
          type="email"
          class="form-control input"
          id="email"
          name="email"
          />
        </div>
        <div class="mb-3">
          <label 
          for="password" 
          class="form-label text-secondary">
          Password
        </label>
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
      <div class="mb-3">
        <label 
        for="confirm_password" 
        class="form-label text-secondary"
        >Confirm Password</label
        >
        <div class="passwrap">
          <input
          type="password"
          class="form-control input"
          id="confirm_password"
          name="confirm_password"
          />
          <i class="bi bi-eye-slash eyeicon" id="icon2"></i>
        </div>
      </div>
      <div class="d-grid">
        <button 
        type="submit" 
        class="btn lightbtn colordark mt-2">
        Sign Up
      </button>
      <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('signup_form')?>">
    </div>
  </form>
</div>

<!-- links -->
<div
          class="d-flex justify-content-between align-items-center gap-3 mx-3 mb-3"
          style="max-width: 500px;"
          >
          <a href="/" class="text-secondary small"><?= $_SESSION['left-arrow']; ?> Back to Homepage</a>
          <a 
          href="/login" 
          class="text-secondary small text-end"
          >Already have an account? Login here</a>
        </div>
      </div>
      
    </div> <!--col-md-4-->
    
    <div class="col-md-6 d-none d-md-block">
      <img src="../assets/img/login signup.jpg" class="img-fluid h-100" alt="">
    </div> <!--col-md-6-->
    
  </div>   <!--row-->
  

      </div> <!-- container-->

<?php require dirname(__DIR__)."/parts/footer.php";