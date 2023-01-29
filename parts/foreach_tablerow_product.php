   <tr>
        <td><?=$index+1?></td>
        <td><?=$product['name'].($product['trending']==1?'<i class="bi bi-fire colorxtradark"></i>':'').($product['available']==1?'<p class="colorxtradark">(In Stock)</p>':'')?></td>
        <td><?=$product['price']?></td>
        <td><img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="d-block mx-auto" style="max-width:150px;max-height:180px;"></td>
        <td class="d-flex align-items-center justify-content-end">

            <?php modalButton('view',$product['id'],'btn-sm') ?>
            <!-- viewmodal-->
            <?php modalHeader('view',$product['id'],$product['name'].' (ID :'.$product['id'].')','modal-xl'); ?>
            <input type="hidden" name="productid" value="<?=$product['id']?>">

            <?php require dirname(__DIR__)."/parts/view_product.php"; ?>
                
            <?php modalFooter('view'); ?>
            <!--end viewmodal-->
            
            <!-- edit product -->
            <a href="/manageproducts-edit?id=<?=$product['id']?>" class="btn btn-sm">
            <i class="bi bi-pencil-square"></i>
            </a>

            <!--deletemodal-->
            <?php if(!isset($_GET['id'])) modalButton('delete',$product['id'],'btn-sm') ?>
                <form 
                action="<?= $_SERVER['REQUEST_URI'];?>" 
                method="POST">
                <?php modalHeader('delete',$product['id'],$product['name'].' ( ID : '.$product['id'].' )'); ?>
                <h4 class="fw-light">Are you confirm to delete product "<?=$product['name'];?>" ?</h4>
                <input type="hidden" name="productid" value="<?=$product['id']?>">
                <input type="hidden" name="image" value="<?=$product['image']?>">
                <input type="hidden" name="product" value="<?=$product['name']?>">
                <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('delete_product')?>">
                <div class="card border-0">
                    <img
                    src="./assets/uploads/<?=$product['image']?>"
                    class="d-block mx-auto mt-4"
                    style="max-width:200px"
                    alt="<?=$product['name'];?>" 
                    />
                <div class="card-body text-center">
                  <p class="text-secondary"><?=$product['authorname'];?></p>
                   <h5 class="card-title"><?=$product['name'];?></h5>
                   <p class="card-text">RM <?=$product['price'];?></p>
              </div> <!--card-body-->
            </div> <!--card-->
                <?php modalFooter('delete'); ?>
            </form>
            <!--end deletemodal-->

        </td>
        </tr>