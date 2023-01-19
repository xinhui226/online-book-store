<nav class="navbar navbar-expand-md sticky-top bg-white">
    <div class="container">
        <a href="/" class="navbar-brand text-secondary text-decoration-none">BOOK STORE</a>
        <button 
          class="navbar-toggler" 
          type="button" 
          data-bs-toggle="collapse" 
          data-bs-target="#navbarToggler" 
          aria-controls="navbarToggler" 
          aria-expanded="false" 
          aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div 
          class="collapse navbar-collapse justify-content-end" 
          id="navbarToggler">
            <ul class="navbar-nav mb-2 mb-lg-0">
              <!-- if not yet log in -->
              <?php if(Authentication::isLoggedIn()) : ?>
                <li class="nav-item">
          <a class="nav-link disabled" href="">Hi, <?=$_SESSION['user']['username']?></a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
            <a class="nav-link" href="/products">Products</a>
            </li>
        <li class="nav-item">
            <a class="nav-link" href="/cart">Cart</a>
            </li>
            <li class="nav-item">
            <a class="nav-link" href="/orders">Order</a>
                </li>
                <?php if(Authentication::isLoggedIn()):?>
                <li class="nav-item">
          <a class="nav-link" href="/logout">Log out</a>
        </li>
                <?php else: ?>
        <li class="nav-item">
          <a class="nav-link" href="/signup">Sign Up</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/login">Log In</a>
        </li>
        <?php endif; ?>

      </ul>
    </div> <!--navbar-collapse-->
  </div> <!--container-->
</nav> <!-- navbar -->
