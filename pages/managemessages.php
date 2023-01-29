<?php 

if(!Authentication::whoCanAccess('admin'))
{
   if(Authentication::isEditor())
   {
       header('Location: /dashboard');
       exit;
   } 
   else{
       header('Location: /');
       exit;
   }
}

CSRF::generateToken('delete_message');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(!isset($_POST['search'])){

                $_SESSION['error'] = FormValidation::validation
                ( 
                  $_POST,
                  [
                      'messageid'=>'required',
                      'csrf_token'=>'delete_message_token'
                  ] 
              );

                  if(empty($_SESSION['error']))
                  {
                      Messages::deleteMessage($_POST['messageid']);

                      CSRF::removeToken('delete_message');

                      $_SESSION['message'] = 'Successfully delete Message # id :'.$_POST['messageid'];
                      header('Location: /managemessages');
                      exit;
                  }//end - empty($_SESSION['error'])

    } //end -!isset($_POST['search'])
} //end - method POST

require dirname(__DIR__)."/parts/adminheader.php";
?>
<div class="row"> 
    
<div class="d-flex justify-content-between">
    <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 
    <?php require dirname(__DIR__)."/parts/searchbox.php"?>
</div><!--d-flex justify-content-between-->

        <h1 class="colorxtradark text-center mb-5">Messages</h1>
      
        <?php if(isset($_POST['search'])&&!empty($_POST['search'])) {?>
            <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
                <?php if(!empty(Messages::search($_POST['search']))){
                    foreach(Messages::search($_POST['search']) as $message){

                        require dirname(__DIR__)."/parts/message_card.php";

                     }} else{ ?>
                <h3 class="colorxtradark">No record found</h3>
                <?php }?> <!--end -if(!empty(Messages::search())):?>-->

        <?php }
        elseif(!empty(Messages::listAllMessage())) { ?>
        <?php foreach(Messages::listAllMessage() as $message) { 

            require dirname(__DIR__)."/parts/message_card.php";

         }}?> <!--end if(empty(Messages::listAllMessage()))-->

</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";