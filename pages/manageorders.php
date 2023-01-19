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

require dirname(__DIR__)."/parts/adminheader.php";
?>

<div class="row justify-content-center"> 
    
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
                <option>Sort By</option>
                <option value="date-asc">Date, New to Old</option>
                <option value="date-desc">Date, Old to New</option>
            </select>
        </div> <!--d-inline-block-->
    </div> <!--col-12-->

    <div class="col-12">
        <h1 class="colorxtradark text-center">Orders</h1>
    </div> <!--col-12-->
    
            <div class="mb-4">
                    <label for="status" class="colorxtradark">Status</label>
                    <select class="form-select colordark" style="width:fit-content;" id="status">
                        <option>All</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
            </div> <!--mb-4-->

            <?php require dirname(__DIR__)."/parts/error_box.php" ?>

        </div> <!--row-->


<div class="row">
    <!--if empty-->
        <!--foreach-->
        <div class="col-md-3 h-auto mb-3">
        <div class="card rounded border-0 colordark h-100">
            <div class="card-title border-bottom py-2 text-end pe-1">
            
            <!-- modalButton('delete',$message['id'],'btn-sm') ?> -->
            <!--form-->
               <h4 class="text-center">Order #(id)</h4>
            </div> <!--card-title-->
            <div class="card-body">
                <h5>User :user id</h5>
                <h5>Amount :amount</h5>
                <h5>Placed on :Date</h5>
                <h5>Payment Status :status</h5>
                <h5>Delivery Status :select</h5>
            </div> <!--card-->
            <button class="btn btn-md bgdark colorlight">View</button> <!--product-->
        </div> <!--col-md-3-->
        <!--endforeach-->
        </div> <!--row-->

</div> <!--row -->

<?php
require dirname(__DIR__)."/parts/footer.php";