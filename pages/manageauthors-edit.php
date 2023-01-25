<?php

if(!Authentication::whoCanAccess('editor'))
 {
      header('Location: /');
      exit;
 }

 CSRF::generateToken('edit_author');

$author = Authors::getAuthorById($_GET['id']);

if($_SERVER['REQUEST_METHOD']=='POST'){

  if($_POST['author']!=$author['name'])
  {

      $_SESSION['error'] = FormValidation::validation
      ( 
        $_POST,
        [
        'author'=>'text',
        'csrf_token'=>'edit_author_token'
        ] 
      );

     if(empty($_SESSION['error']))
     {
         Authors::updateAuthor($_POST['authorid'],$_POST['author']);

         CSRF::removeToken('edit_author');

         $_SESSION['message'] = 'Successfully update Author "'.$author['name'].'" to Author "'.$_POST['author'].'"' ;
         header('Location: /manageauthors');
         exit;
      }//end - !$_SESSION['error']

  }// end - if($_POST['author']!=$author['name'])

}

require dirname(__DIR__)."/parts/adminheader.php";
?>
<a href="/manageauthors" class="colorlight mt-5"><?= $_SESSION['left-arrow']; ?> Back</a> 
<div class="row py-5 text-center justify-content-center align-items-center h-75">
  <h1 class="colorxtradark">Edit Author "<?=$author['name'];?>"</h1>
  <div class="col-sm-4">
  <form action="<?=$_SERVER['REQUEST_URI'];?>" method="POST">
    <input type="text" name="author" value="<?=$author['name'];?>" class="form-control">
    <input type="hidden" name="authorid" value="<?=$author['id'];?>" class="form-control">
    <button type="submit" class="btn bgdark mt-3">Update</button>
    <input type="hidden" name="csrf_token" value="<?=CSRF::getToken('edit_author')?>">
  <form>
</div>
</div>
<?php

require dirname(__DIR__)."/parts/footer.php";