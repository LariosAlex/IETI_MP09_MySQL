<?php
    session_start();
    include 'common.php';
    $infoUser = infoUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DASHBOARD</title>
</head>
<body>
<?php
        if(isset($_POST['username'])){
            $startSession = connToDB()->prepare("SELECT * FROM `users` WHERE users.username = :username AND users.password = SHA2(:pw, 512);");
            $startSession->bindParam(':username', $_POST['username']);
            $startSession->bindParam(':pw', $_POST['password']);
            $startSession->execute();
            if($startSession->rowCount() != 1){
                header("Location: ./login.php");
                exit();
            }else{
                foreach($startSession as $user){
                    $_SESSION['ID'] = $user['ID'];
                    $infoUser = infoUser();
                }
            }
        }else{
            if(!isset($_SESSION['ID'])){
                header("Location: ./login.php");
                exit();
            }
        }

        if(isset($_SESSION['ID'])){
            echo '<h1>Welcome '.$infoUser['username'].'</h1>';
            ?>
            <ul>
            <li><a href="./profile.php">My profile</a></li><br>
            <?php  
            if($infoUser['role'] == 1){
                echo '<li><a href="./admin_users.php">Users Management</a></li><br>';
            }
            ?>
            <li><a href="./login.php">Sign Off</a></li>
            <li><a href="./email.php">Send Email</a></li><br>
            </ul>
            <?php
        }
    ?>
</body>
</html>