<?php

//modal button
function modalButton($action,$target,$class='',$keyword='')
{
  if(empty($keyword))
  switch ($action){
    case 'delete' :
      $button='<i class="bi bi-trash3-fill"></i>';
      break;
    case 'view' :
      $button='<i class="bi bi-eye-fill"></i>';
      break;
  }

  echo '<button 
  type="button" 
  class="btn '.$class.'" 
  data-bs-toggle="modal" 
  data-bs-target="#'.$action.$target.'">'.(!empty($keyword) ? $keyword : $button).'</button>';
}

//modal header
function modalHeader($action,$target,$modaltitle,$class=""){

  echo '<div class="modal fade '.$class.'" id="'.$action.$target.'" data-bs-backdrop="false" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen-md-down">
              <div class="modal-content">
              <div class="modal-header">
              <h1 class="modal-title fs-5">'.($action=='delete'?'Delete ':'').$modaltitle.'</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div> 
              <div class="modal-body border-top-0">';
}

//modal footer
function modalFooter($action,$additionalbtn=""){
    
             echo '</div> 
            <div class="modal-footer border-top-0">'
            .($action=='delete'?'<button type="submit" class="btn bgneutral colorlight">Delete</button>':'').
            $additionalbtn.
            '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div> 
            </div> 
            </div>
            </div>';
  }