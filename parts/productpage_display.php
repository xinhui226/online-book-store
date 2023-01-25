
          <div class="col-lg-6 mb-4 h-auto">
            <div class="row g-0 bg-light h-100">
            <div class="col-xl-5 col-lg-12 col-sm-5 d-flex flex-column justify-content-center p-xl-2">
                    <img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="img-fluid object-fit-cover">
                  </div> <!--col-xl-5 col-lg-12 col-sm-5-->
                  <div class="col-xl-7 col-lg-12 col-sm-7 d-flex flex-column justify-content-between">
                  <div class="pt-3">
                       <h5><?=$product['name']?><?=($product['trending']==1?'<i class="bi bi-fire colordark"></i>':'')?></h5>
                        <p class="text-muted mb-0" style="font-size:14px">RM <?=$product['price']?></p>
                        <p class="pe-3 mt-3 fw-normal" style="overflow-wrap:anywhere;font-size:16px"><?=substr($product['description'],0,50)?>...</p>
                  </div>
                    <div class="pe-3 pb-3 d-flex justify-content-end">
                      <form 
                          action="/cart" 
                          method="POST">
                          <button class="btn darkbtn text-white me-1">Add to cart</button>
                          <input 
                          type="hidden" 
                          name="productid" 
                          value="<?=$product['id'];?>">
                          <input type="hidden" name="name" value="<?=$product['name']?>">
                          <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_cart_item')?>">
                    </form>

                    <?php modalButton('view',$product['id'],'neutralbtn text-white','View') ?>
                </div>
                  </div> <!--col-xl-7 col-lg-12 col-sm-7-->
              </div> <!-- <div class="row">-->

          <!-- viewmodal-->
          <form 
          action="/cart" 
          method="POST">
          <input type="hidden" name="productid" value="<?=$product['id']?>">
          <input type="hidden" name="name" value="<?=$product['name']?>">
          <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('add_cart_item')?>">
          <?php modalHeader('view',$product['id'],$product['name'],'modal-xl'); ?>
          
            <?php require dirname(__DIR__)."/parts/view_product.php"; ?>

            <?php modalFooter('view','<button type="submit" class="btn bgdark">Add to Cart</button>'); ?>
          </form>
      <!--end viewmodal-->
    </div><!--<div class="col-lg-6">-->