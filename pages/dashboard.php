<?php 

if(!Authentication::whoCanAccess('editor'))
 {
  header('Location: /');
  exit;
 }


require dirname(__DIR__)."/parts/adminheader.php";
?>

 
<div class="row justify-content-evenly"> 
    <div class="col-12 text-end">
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
        </div> <!--d-inline-block-->
    </div> <!--col-12 text-end-->
<?php require "parts/error_box.php"; ?>
    <div class="col-12">
        <h1 class="colorxtradark text-center my-5">Dashboard</h1>
    </div> <!--col-12-->
    
    <div class="col-lg-3 col-md-3 bg-light btn rounded-4 p-4 mb-3 position-relative">
        <a href="/managecategory" class="text-decoration-none colordark">
        <i class="bi bi-tag-fill dash"></i>
            <h4>Categories<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Category::totalCategories()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->
    
    <div class="col-lg-3 col-md-3 bg-light btn rounded-4 p-4 mb-3 position-relative">
        <a href="/manageauthors" class="text-decoration-none colordark">
        <i class="bi bi-pen-fill dash"></i>
            <h4>Total Authors<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Authors::totalAuthors()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->
    
    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-3 position-relative">
        <a href="/manageproducts" class="text-decoration-none colordark">
        <i class="bi bi-book-fill dash"></i>
                <h4>Total Products<i class="bi bi-chevron-right fs-6"></i></h4>
                <h4>(<?=Products::totalProducts()['quantity']?>)</h4>
            </a>
    </div> <!--col-lg-3 col-md-3-->

</div> <!--row justify-content-evenly-->

<?php if(Authentication::whoCanAccess('admin')):?>

<div class="row justify-content-evenly mt-3">

    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-3 position-relative">
        <a href="/managemessages" class="text-decoration-none colordark">
            <i class="bi bi-envelope-fill dash"></i>
            <h4>New Messages<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(Pending) (<?=Messages::newMessage()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->

    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-3 position-relative">
        <a href="/manageorders" class="text-decoration-none colordark">
            <i class="bi bi-bag-fill dash"></i>
            <h4>Total Orders<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(...)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->

    <div class="col-lg-3 col-md-3 btn bg-light rounded-4 p-4 mb-3 position-relative">
        <a href="/manageaccount" class="text-decoration-none colordark">
            <i class="bi bi-people-fill dash"></i>
            <h4>Total Users Account<i class="bi bi-chevron-right fs-6"></i></h4>
            <h4>(<?=Users::totalUserAccount()['quantity']?>)</h4>
        </a>
    </div> <!--col-lg-3 col-md-3-->
    
    <div class="col-lg-7 bg-light rounded-4 p-4 my-5 table-responsive">
        
            <h4 class="colordark">Recent Orders</h4>
            <table class="table table-borderless colorxtradark">
  <thead>
    <tr>
      <th scope="col">No. </th>
      <th scope="col">Products</th>
      <th scope="col">Amount</th>
      <th scope="col">Placed Order On</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th scope="row">1</th>
      <td>Mark</td>
      <td>Otto</td>
      <td>Otto</td>
      <td>@mdo</td>
    </tr>
  </tbody>
</table>
        <a href="/manageorders" class="text-decoration-none colorxtradark d-block text-end">See All</a>
    </div> <!--col-lg-8-->

    <div class="col-lg-4 col-md-6 bg-light rounded-4 p-4 my-5">
    
            <h4 class="colordark">New Account</h4>
            <ul class="list-group list-group-flush">
                <?php foreach(Users::getAllUsers(10) as $index=> $user):?>
                <li class="list-group-item colordark"><?=$index.'. '.$user['username'].' ( '.$user['role'].' ) '?></li>
                <?php endforeach; ?>
            </ul>
        <a href="/manageaccount" class="text-decoration-none colorxtradark d-block text-end">See All</a>
    </div>

<?php endif; ?>
<?php
require dirname(__DIR__)."/parts/footer.php";