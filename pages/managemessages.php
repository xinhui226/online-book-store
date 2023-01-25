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

CSRF::generateToken('edit_message');
CSRF::generateToken('delete_message');

if($_SERVER['REQUEST_METHOD']=='POST'){

    if(isset($_POST['action'])){
        switch($_POST['action']){
            case 'delete' :

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
                break;

            case 'update' :

                $_SESSION['error'] = FormValidation::validation
                ( 
                  $_POST,
                  [
                      'messageid'=>'required',
                      'csrf_token'=>'edit_message_token'
                  ] 
              );

                  if(empty($_SESSION['error']))
                  {
                      Messages::updateMessage($_POST['messageid'],$_POST['messagestatus']);
                    
                      CSRF::removeToken('edit_message');

                      $_SESSION['message'] = 'Successfully update status of Message '.$_POST['messageid'].' to "'.$_POST['messagestatus'].'"';
                      header('Location: /managemessages');
                      exit;
                  }//end - empty($_SESSION['error'])
                break;
        } //end - switch
    } //end -isset action
} //end - method POST

require dirname(__DIR__)."/parts/adminheader.php";
?>
<div class="row"> 
    
<div class="d-flex justify-content-between">
    <a href="/dashboard" class="colorlight"><?= $_SESSION['left-arrow']; ?> Back</a> 
    <form 
            class="d-flex" 
            method="POST" 
            action="<?=$_SERVER['REQUEST_URI']; ?>">
                <input 
                class="form-control rounded-5"
                type="search"
                name="search"
                placeholder="Search" 
                aria-label="Search">
                <button 
                class="border-0 colordark searchbtn ms-1 position-relative" 
                type="submit">
                <i class="bi bi-search position-absolute translate-middle"></i>
                </button>
            </form>
</div><!--d-flex justify-content-between-->

        <h1 class="colorxtradark text-center mb-3">Messages</h1>

            <div class="mb-4">
                    <label for="status" class="colorxtradark">Status</label>
                    <select class="form-select colordark mb-2" style="width:fit-content;" id="status">
                        <option>All</option>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                    
           </div> <!--mb-4-->

      
        <?php if(isset($_POST['search'])&&!empty($_POST['search'])) :?>
            <p class="lead text-muted">Result "<?=$_POST['search']?>" :</p>
            <?php foreach(Messages::search($_POST['search']) as $message) : ?>
        <div class="col-lg-3 col-sm-6 h-auto mb-3">
        <div class="card rounded border-0 colordark h-100">
            <div class="card-title border-bottom py-2 text-end pe-1">
            <?php modalButton('delete',$message['id'],'btn-sm') ?>
                    <form 
                    action="<?= $_SERVER['REQUEST_URI'];?>" 
                    method="POST">
                    <!--deletemodal-->
                    <?php modalHeader('delete',$message['id'],'Message #id :"'.$message['id'].'"'); ?>

                    <h6 class="fw-light text-start">Are you confirm to delete message from "<?=$message['name'];?>" ?</h6>
                    <h5 class="text-start">Message : <?=$message['content']?></h5>
                    <input type="hidden" name="messageid" value="<?=$message['id']?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="name" value="<?=$message['name'];?>">
                    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_message')?>">
                    <?php modalFooter('delete'); ?>
                    <!--end deletemodal-->
                    </form>
            <h5 class="text-center">Message #id :<?=$message['id']?></h5>
            </div> <!--card-tittle-->
            <div class="card-body">
                <p>Name : <?=$message['name']?></p>
                <p>Email : <?=$message['email']?></p>
                <p>Date : <?=$message['created_at']?></p>
                <label 
                for="replied<?=$message['id']?>" 
                class="form-label">
                Replied :
                </label>
                    <div class="text-center">
                    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <select class="form-select form-select-md colordark" id="replied<?=$message['id']?>" name="messagestatus">
                        <option selected value="<?=$message['replied']?>"><?=$message['replied']?></option>
                        <option value="<?= ($message['replied']=='Pending'? 'Completed' : 'Pending') ?>">
                            <?= ($message['replied']=='Pending'? 'Completed' : 'Pending') ?>
                        </option>
                    </select>
                        <input type="hidden" name="messageid" value="<?=$message['id']?>">
                        <input type="hidden" name="action" value="update">
                        <button type="submit" class="btn btn-sm bgneutral colorxtradark mt-2" name="action" value="update">Save</button>
                        <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('edit_message')?>">
                    </form>
            </div> <!--card-body-->
        </div> <!--card-->

        <?php modalButton('view',$message['id'],'btn-md bglight colorxtradark','View') ?>
                <!--viewmodal-->
                <?php modalHeader('view',$message['id'],'Message #id :'.$message['id']); ?>

                <p>Name : <?=$message['name']?></p>
                <p>Email : <?=$message['email']?></p>
                <p>Message : <?=$message['content']?></p>
                <p>Status : <?=$message['replied']?></p>
                <p>Date : <?=$message['created_at']?></p>

                <?php modalFooter('view'); ?>
                <!--end viewmodal-->
        </div> <!--col-md-3-->
                        </div>
        <?php endforeach; ?>

        <?php elseif(!isset($_POST['search'])&&!empty(Messages::listAllMessage())) : ?>
        <?php foreach(Messages::listAllMessage() as $message) : ?>
        <div class="col-lg-3 col-sm-6 h-auto mb-3">
        <div class="card rounded border-0 colordark h-100">
            <div class="card-title border-bottom py-2 text-end pe-1">
            <?php modalButton('delete',$message['id'],'btn-sm') ?>
                    <form 
                    action="<?= $_SERVER['REQUEST_URI'];?>" 
                    method="POST">
                    <!--deletemodal-->
                    <?php modalHeader('delete',$message['id'],'Message #id :"'.$message['id'].'"'); ?>

                    <h6 class="fw-light text-start">Are you confirm to delete message from "<?=$message['name'];?>" ?</h6>
                    <h5 class="text-start">Message : <?=$message['content']?></h5>
                    <input type="hidden" name="messageid" value="<?=$message['id']?>">
                    <input type="hidden" name="action" value="delete">
                    <input type="hidden" name="name" value="<?=$message['name'];?>">
                    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_message')?>">
                    <?php modalFooter('delete'); ?>
                    <!--end deletemodal-->
                    </form>
            <h5 class="text-center">Message #id :<?=$message['id']?></h5>
            </div> <!--card-tittle-->
            <div class="card-body">
                <p>Name : <?=$message['name']?></p>
                <p>Email : <?=$message['email']?></p>
                <p>Date : <?=$message['created_at']?></p>
                <label 
                for="replied<?=$message['id']?>" 
                class="form-label">
                Replied :
                </label>
                    <div class="text-center">
                    <form action="<?=$_SERVER['REQUEST_URI']?>" method="POST">
                    <select class="form-select form-select-md colordark" id="replied<?=$message['id']?>" name="messagestatus">
                        <option selected value="<?=$message['replied']?>"><?=$message['replied']?></option>
                        <option value="<?= ($message['replied']=='Pending'? 'Completed' : 'Pending') ?>">
                            <?= ($message['replied']=='Pending'? 'Completed' : 'Pending') ?>
                        </option>
                    </select>
                        <input type="hidden" name="messageid" value="<?=$message['id']?>">
                        <input type="hidden" name="action" value="update">
                        <button type="submit" class="btn btn-sm bgneutral colorxtradark mt-2" name="action" value="update">Save</button>
                        <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('edit_message')?>">
                    </form>
            </div> <!--card-body-->
        </div> <!--card-->

        <?php modalButton('view',$message['id'],'btn-md bglight colorxtradark','View') ?>
                <!--viewmodal-->
                <?php modalHeader('view',$message['id'],'Message #id :'.$message['id']); ?>

                <p>Name : <?=$message['name']?></p>
                <p>Email : <?=$message['email']?></p>
                <p>Message : <?=$message['content']?></p>
                <p>Status : <?=$message['replied']?></p>
                <p>Date : <?=$message['created_at']?></p>

                <?php modalFooter('view'); ?>
                <!--end viewmodal-->
        </div> <!--col-md-3-->
                        </div>
        <?php endforeach; ?>
        
<?php else :?>
    <h3 class="colorxtradark">No record found</h3>
        <?php endif; ?> <!--end if(empty(Messages::listAllMessage()))-->

</div> <!--row-->

<?php
require dirname(__DIR__)."/parts/footer.php";