<div class="container-fluid" style="overflow-wrap:anywhere;">
        <div class="row">
          <div class="col-lg-6">
              <div class="imgwrap">
                  <img src="./assets/uploads/<?=$product['image']?>" alt="<?=$product['name']?>" class="img-fluid">
                </div>
                <p class="fw-semibold">Category:</p>
                    <?php if(!empty(PivotCatPro::getCategoryByProduct($product['id']))):?>
                    <?php foreach(PivotCatPro::getCategoryByProduct($product['id']) as $index=> $category):?>
                        <span class="badge bg-secondary fs-6 px-3 py-2 fw-light"><?=$category['name']?></span>
                    <?php endforeach; ?>
                    <?php else :?>
                        <span class="text-muted fs-6">---</span>
                    <?php endif; ?> <!--end - if !empty(PivotCatPro::getCategoryByProduct())-->
              </div> <!--col-lg-6-->
              <div class="col-lg-6">
                <h5 class="my-3 fw-semibold">Book Name : <?=$product['name'].($product['trending']==1?'<i class="bi bi-fire colorxtradark"></i>':'')?></h5>
                <h6><span class="fw-semibold">Author : </span><?=$product['authorname']?></h6>
                <p><span class="fw-semibold">Price :</span> Rm<?=$product['price'];?></p>
                <p><span class="fw-semibold">Uploaded on :</span> <?=tzFormat($product['created_at']);?></p>
                <h4 class="mt-5 fw-semibold">Description :</h4>
                <p><?=nl2br($product['description']);?></p>
              </div> <!--col-lg-6-->
          </div> <!--row-->
        </div> <!--container-fluid-->