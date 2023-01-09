<?php
 session_start();
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
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['ID'] = $user['ID'];
                }
            }
        }else{
            if(!isset($_SESSION['ID'])){
                header("Location: ./login.php");
                exit();
            }
        }
        if(isset($_SESSION['username'])){
            echo '<h1>'.$_SESSION['username'].'</h1>';
            ?>
            <ul>
            <li><a href="./profile.php">Profile</a></li><br>
            <?php  
            if($_SESSION['role'] == 1){
                echo '<li><a href="./admin_users.php">Users administration</a></li><br>';
            }
            ?>
            <li><a href="./login.php">LogOut</a></li>
            </ul>
            <?php
        }
    ?>
</body>
</html>