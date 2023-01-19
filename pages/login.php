<?php

  if(Authentication::whoCanAccess('editor'))
  {
      header('Location: /dashboard');
      exit;
  }elseif(Authentication::isUser())
  {
      header('Location: /');
      exit;
  }

  CSRF::generateToken('login_form');

if($_SERVER['REQUEST_METHOD']=='POST'){
    
    $email = $_POST['email'];
    $password = $_POST['password'];

   $_SESSION['error'] = FormValidation::validation(
    $_POST,
    [
      'email'=>'required',
      'password'=>'required',
      'csrf_token'=>'login_form_token'
    ]
    );

  if(empty($_SESSION['error']))
  {
   $userid= Authentication::login(
      $email,$password
   );

   if(!$userid)
   {
    $_SESSION['error'] = 'Invalid email or password';
   }else{

    Authentication::setSession($userid);

    CSRF::removeToken('login_form');

    $_SESSION['message'] = 'Welcome Back, '.$_SESSION['user']['username'].' !';;
    if(Authentication::isUser())
    {
        
        header('Location: /');
        exit;
      }elseif(Authentication::whoCanAccess('editor')){
        header('Location: /dashboard');
        exit;
      }
   }//end - else 

  }// end - if !$error
};

require dirname(__DIR__)."/parts/header.php";

?>
<body class="bglight">
    <div 
    class="container-fluid pe-0 d-flex flex-column align-items-center" 
    style="padding-top:100px;">
 <?php require "parts/error_box.php"; ?>
    <div class="row justify-content-end g-0 mb-1">
      <div class="col-md-4 bg-white d-flex flex-column justify-content-center">

         <!-- log in form -->
         <div 
        class="card rounded-0 shadow-md border-0 px-3" 
        style="max-width: 500px;">
          <div class="card-body">
            <h5 class="card-title text-center text-secondary mb-3 py-3 border-bottom">
              Welcome Back
            </h5>

             <form 
             action="<?php echo $_SERVER['REQUEST_URI']; ?>" 
             method="POST">
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
                  required
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
                  required
                  />
                  <i class="bi bi-eye-slash eyeicon" id="icon"></i>
                </div>
              </div>
              <div class="d-grid">
                <button 
                type="submit" 
                class="btn lightbtn colordark mt-2">
                  Login
                </button>
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('login_form')?>">
              </div>
            </form>
        </div>

        <!-- links -->
        <div
          class="d-flex justify-content-between align-items-center gap-3 mx-3 mb-3 pt-3"
          style="max-width: 500px;"
        >
        <a href="/" class="text-secondary small"><?= $_SESSION['left-arrow']; ?> Back to Homepage</a>
          <a 
          href="/signup" 
          class="text-secondary small text-end"
            >Don't have an account? Sign up here
            </a>
        </div>
        </div>

      </div> <!--col-md-4-->
      
      <div class="col-md-6 d-none d-md-block">
    <img src="../assets/img/login signup.jpg" class="img-fluid h-100" alt="">
</div> <!--col-md-6-->

    </div>   <!--row-->
 

      </div> <!--container-->

<?php require dirname(__DIR__)."/parts/footer.php";