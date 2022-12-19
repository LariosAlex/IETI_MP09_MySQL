<!DOCTYPE html>
<html>
<body>

<form action="image.php" method="post" enctype="multipart/form-data">
  Image de perfil:
  <br><input type="file" name="profileImage" id="profileImage"><br>
  <br><input type="submit" value="Actualizar foto de perfil" name="submit">
</form>
<?php
if(isset($_POST['submit'])){ 
    $filepath = "./imgProfile/" . $_FILES["profileImage"]["name"];
    if(move_uploaded_file($_FILES["profileImage"]["tmp_name"], $filepath)) {
        echo "<img src='".$filepath."'/>";
    } 
    else{
        echo "Error !!";
    }
} 
?>
</body>
</html>