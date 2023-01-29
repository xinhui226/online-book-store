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
                </div> <!--card-body-->
                
                <?php modalButton('view',$message['id'],'btn-md bglight colorxtradark','View') ?>
                <!--viewmodal-->
                <?php modalHeader('view',$message['id'],'Message #id :'.$message['id']); ?>
                
                <p>Name : <?=$message['name']?></p>
                <p>Email : <?=$message['email']?></p>
                <p>Message : <?=$message['content']?></p>
                <p>Date : <?=$message['created_at']?></p>
                
                <?php modalFooter('view'); ?>
                <!--end viewmodal-->
            </div> <!--card-->
            </div> <!--col-md-3-->