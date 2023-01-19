<!-- <if(isset($error)&&!empty($error)) :?>
<div class="alert alert-danger" role="alert"  style="width:fit-content;"><?=$error?></div>
<elseif(isset($message)&&!empty($message)) : ?>
<div class="alert alert-success" role="alert" style="width:fit-content;"><?=$message?></div>
<endif; ?> -->


<?php if(isset($_SESSION['message'])&&!empty($_SESSION['message'])):?>

<div class="toast fade position-fixed align-items-center text-bg-success border-0" id="myToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="2000">
<div class="d-flex">
<div class="toast-body">
<?=$_SESSION['message']?>
</div>
<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
</div>
<?php unset($_SESSION['message']);?>
<?php elseif(isset($_SESSION['error'])&&!empty($_SESSION['error'])):?>

<div class="toast fade position-fixed align-items-center text-bg-danger border-0" id="myToast" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="3000">
<div class="d-flex">
<div class="toast-body">
<?=$_SESSION['error']?>
</div>
<button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
</div>
</div>
<?php unset($_SESSION['error']);?>
<?php endif; ?>