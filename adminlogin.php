<?php 
require dirname(__DIR__)."/parts/adminlogsignheader.php";

?>
    <div class="container-fluid">
        <!-- log in form -->
        <div class="row justify-content-center">
          <div class="col-md-6 col-lg-4 d-inline-grid align-self-center">

          <div class="card rounded-0 shadow-sm border my-3 my-md-0">
          <div class="card-body">
            <h5 class="card-title text-center mb-3 py-3 border-bottom colordark">
              Hi, Welcome Back !
            </h5>

             <form 
             action="<?php echo $_SERVER['REQUEST_URI']; ?>" 
             method="POST">
              <div class="mb-3">
                <label 
                for="email" 
                class="form-label colordark">
                Email address

            </label>
                <input
                  type="email"
                  class="form-control  "
                  id="email"
                  name="email"
                />
              </div>
              <div class="mb-3">
                <label 
                for="password" 
                class="form-label colordark">
                    Password

                </label>
                <div class="passwrap">
                  <input
                  type="password"
                  class="form-control"
                  id="password"
                  name="password"
                  />
                  <i class="bi bi-eye-slash eyeicon" id="icon"></i>
                </div>
                </div>
              <div class="d-grid">
                <button 
                type="submit" 
                class="btn colorlight bgdark mt-2">
                  Login
                </button>
              </div>
            </form>
        </div>

        <!-- links -->
        <div
          class="d-flex justify-content-between align-items-center gap-3 mx-3 mb-3 pt-3"
          style="max-width: 500px;"
        >
        <a href="/" class="colordark small"><?= $_SESSION['left-arrow']?> Back to Homepage</a>
        </div>
        </div>
          </div>

          <div class="col-lg-4 col-md-5 text-end d-md-block d-none">
            <img src="../assets/img/login signup admin.jpg" class="img-fluid" style="height:100vh;width:450px" alt="">
          </div>
        </div>
      </div>
          

<?php
require dirname(__DIR__)."/parts/footer.php";