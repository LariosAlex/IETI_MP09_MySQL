<?php
 session_start();
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
            <legend>Dades de <?php $_SESSION['username']?></legend>
            <input type="text" name="username" id="username" placeholder="username"><br><br>
            <input type="password" name="password" id="password" placeholder="password"><br><br>
            <input type="email" name="email" id="email" placeholder="your_email@ieti.cat">
        </fieldset>
        <br><input type="submit" value="Modificar dades" name="modificar">
        <input type="submit" value="Torna al menu" name="menu">
    </form>
    <?php
    function connToDB(){
        try {
            $hostname = "localhost";
            $dbname = "MP09";
            $username = "admin";
            $pw = "admin123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
            } catch (PDOException $e) {
                echo "Failed to get DB handle: " . $e->getMessage() . "\n";
                exit;
            }
            return $pdo;
    }
    if(isset($_POST['modificar'])){
        $changeProfile = '';
        if(isset($_POST['username'])){
            $changeProfile.= " users.username = '".$_POST['username']."'";
        }
        /* if(isset($_POST['password'])){
            if($changeProfile != ''){
                $changeProfile.= ',';
            }
            $changeProfile.= " users.password = SHA2('".$_POST['password']."', 512)";
        } */
        if($changeProfile != ''){
            $startSession = connToDB()->prepare("UPDATE users SET".$changeProfile." WHERE users.username = :username;");
            $startSession->bindParam(':username', $_SESSION['username']);
            $startSession->execute();
            header("Location: ./protectedLogin.php");
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