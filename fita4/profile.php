<?php
 session_start();
 include 'common.php';
 $user = infoUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="profile.php" method="post">
    <fieldset>
        <legend>Information of <?php echo $user['username']?></legend>
        <input type="text" name="username" id="username" value="<?php echo $user['username']?>" placeholder="username"><br><br>
        <input type="email" name="email" id="email" value="<?php echo $user['email']?>" placeholder="your_email@ieti.cat">
    </fieldset>
    <br><input type="submit" value="MODIFY INFORMATION" name="modificar" style="background-color:LightSteelBlue">
    <input type="submit" value="MENU" name="menu">
</form>
<?php
    infoUser();
    if(isset($_POST['modificar'])){
        $changeProfile = '';
        if(isset($_POST['username'])){
            $changeProfile.= " users.username = '".$_POST['username']."'";
        }
        if(isset($_POST['email'])){
            if($changeProfile != ''){
                $changeProfile.= ',';
            }
            $changeProfile.= " users.email = '".$_POST['email']."'";
        }
        if($changeProfile != ''){
            $startSession = connToDB()->prepare("UPDATE users SET".$changeProfile." WHERE users.ID = :id;");
            $startSession->bindParam(':id', $_SESSION['ID']);
            $startSession->execute();
            header("Location: ./login.php");
            exit();
        }
    }
    if(isset($_POST['menu'])){
        header("Location: ./main.php");
        $_POST['username'] = $_SESSION['username'];
        exit;
    }
?>
</body>
</html>