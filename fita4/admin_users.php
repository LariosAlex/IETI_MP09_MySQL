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
    <h1>ADMINISTRACIÓ D'USUARIS</h1>
    <?php  
        echo '<h2>USER: '.$_SESSION['username'].'</h2>';
        echo '<h2>ID: '.$_SESSION['role'].'</h2>';
    ?>
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

        function deleteUser($userID){
            $startSession = connToDB()->prepare("DELETE FROM users WHERE users.ID = :id;");
            $startSession->bindParam(':id', $userID);
            $startSession->execute();
            header("Location: ./admin_users.php");
            exit();
        }

        echo "\n".'<form action="./admin_users.php" method="post">';
        echo '<table><tr><th>ID</th><th>NOM</th><th>EMAIL</th><th>ROL</th><th>ESBORRAR USUARI</th></tr>';
        if(isset($_SESSION['username'])){
            $startSession = connToDB()->prepare("SELECT * FROM `users`;");
            $startSession->execute();            
            foreach($startSession as $user){
                if($user['ID'] != $_SESSION['ID']){
                    echo "\n".'<tr>';
                    echo "\n".'<td>'.$user['ID'].'</td>';
                    echo "\n".'<td><input type="text" id="username" name="username'.$user['ID'].'" value="'.$user['username'].'"></td>';
                    echo "\n".'<td><input type="text" id="email" name="email'.$user['ID'].'" value="'.$user['email'].'"></td>';
                    echo "\n".'<td><select name="select'.$user['ID'].'">';
                    if($user['role'] == 1){
                        echo '<option value="1" selected>Admin user</option>';
                        echo '</select></td>';
                    }else{
                        echo '<option value="1">Admin user</option><option value="2" selected>Default user</option>';
                        echo '</select></td>';
                    }
                    echo "\n".'<td><button style="background-color:red" onclick="deleteUser('.$user['ID'].')">Esborrar usuari</button></td>';
                    echo '</tr>';
                }
            }
        }
        echo '</table><br>';
    ?>
    <input type="submit" value="Acualitzar usuaris" name="updateUsers">
    <input type="submit" value="Torna al menu" name="menu">
    </form>
    <?php  
        //ESBORRAR USUARIS
        if(isset($_POST['deleteUser'])){
            deleteUser($userID);
        }
        //ACTUALITZAR USUARIS
        if(isset($_POST['updateUsers'])){    
            $startSession = connToDB()->prepare("SELECT * FROM `users`;");
            $startSession->execute();    
            foreach($startSession as $user){
                if(($_POST['select'.$user['ID']] !=  $user['role']) || ($_POST['username'.$user['ID']] !=  $user['username']) || ($_POST['email'.$user['ID']] !=  $user['email'])){
                    $startSession = connToDB()->prepare("UPDATE users SET users.username = :username, users.email  = :email, users.role = :rol WHERE users.ID = :id;");
                    $startSession->bindParam(':id', $user['ID']);
                    $startSession->bindParam(':username', $_POST['username'.$user['ID']]);
                    $startSession->bindParam(':email', $_POST['email'.$user['ID']]);
                    $startSession->bindParam(':rol', $_POST['select'.$user['ID']]);
                    $startSession->execute();
                    if($user['ID'] == $_SESSION['ID']){
                        $_SESSION['username'] = $_POST['username'.$user['ID']];
                        $_SESSION['role'] = $_POST['role'.$user['ID']];
                    }
                    header("Location: ./admin_users.php");
                    exit();
                }
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