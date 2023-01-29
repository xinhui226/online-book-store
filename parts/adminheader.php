<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" 
    content="width=device-width, initial-scale=1"
    >
    <title>Online Book Store</title>
    <link rel="stylesheet" 
    href="./assets/css/admin.css?v=<?=time();?>"
    >
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.0.5/css/boxicons.min.css" 
    rel="stylesheet" />
    <link rel="preconnect" 
    href="https://fonts.googleapis.com">
    <link rel="preconnect" 
    href="https://fonts.gstatic.com" 
    crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Questrial&display=swap" 
    rel="stylesheet">
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css"
      />
    <link 
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" 
    integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
    crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style> @import url('https://fonts.googleapis.com/css2?family=Questrial&display=swap'); </style>
  </head>
  <?php require dirname(__DIR__)."/parts/error_box.php"; ?>
  <body id="adminbg">
    <div class="overlay"></div>
  <div class="container-fluid overlayyy p-0">
  <div class="row g-0">
    <div class="col-lg-2 p-0">

    <!-- navbar -->
    <nav class="navbar navbar-expand-lg bglight overflow-y-scroll">
  <div class="container-fluid d-lg-block navcontainer">
    <div class="brandcontainer mt-lg-4 ps-lg-3">
      <a class="text-decoration-none" href="/dashboard"><h2 class="colorxtradark">Book Store</h2></a>
      <h5 class="colorxtradark">Hi, <?=$_SESSION['user']['username']?> ! <span class="fs-6">(<?=$_SESSION['user']['role']?>)</span></h5>
      <a href="/" class="btn bgdark rounded">View as Guest</a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
      <!-- editor and admin -->
  <ul class="navbar-nav justify-content-end flex-grow-1 mt-lg-5 d-lg-block">
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="/dashboard"><i class="bi bi-house-door-fill"></i> Dashboard</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/managecategory"><i class="bi bi-tag-fill"></i> Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/manageauthors"><i class="bi bi-pen-fill"></i> Authors</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/manageproducts"><i class="bi bi-book-fill"></i> Products</a>
          </li>
          <!-- admin only -->
          <?php if(Authentication::whoCanAccess('admin')):?>
          <li class="nav-item">
            <a class="nav-link" href="/managemessages"><i class="bi bi-envelope-fill"></i> Messages</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/manageaccount"><i class="bi bi-people-fill"></i> Manage Account</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/manageorders"><i class="bi bi-bag-fill"></i> Orders</a>
            </li>
            <?php endif;?>
          <li class="nav-item mt-5 d-flex justify-content-center">
            <a href="/logout" class="btn bgdark colorlight fs-6">Log Out</a>
          </li>
        </ul>
      </div>
  </div>
</nav>
    </div>

    <div class="col-lg-10 px-4 py-5">
      <div class="container transbg rounded-2 p-4 content overflow-auto" style="height:85vh;">
