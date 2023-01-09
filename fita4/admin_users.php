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
    <title>Document</title>
</head>
<body>
    <h1>USERS MANAGEMENT</h1>
    <?php  
        function selectRol($userID, $userRole){
            $startSession = connToDB()->prepare("SELECT * FROM `tipus_usuari`;");
            $startSession->execute();
            echo '<select id="select'.$userID.'"name="select'.$userID.'">';
            foreach($startSession as $rol){
                if($rol['roleID'] == $userRole){
                    echo '<option value="'.$rol['roleID'].'" selected>'.$rol['roleName'].'</option>';
                }else{
                    echo '<option value="'.$rol['roleID'].'">'.$rol['roleName'].'</option>';
                }

            }
            echo '</select>';
        }
        echo "\n".'<form action="admin_users.php" method="post">';
        echo '<table><tr><th>ID</th><th>NAME</th><th>EMAIL</th><th>ROLE</th><th></th></tr>';
        if(isset($_SESSION['username'])){
            $startSession = connToDB()->prepare("SELECT * FROM `users`;");
            $startSession->execute();            
            foreach($startSession as $user){
                if($user['ID'] != $_SESSION['ID'] && $infoUser['role'] == 1){
                    echo "\n".'<tr>';
                    echo "\n".'<td>'.$user['ID'].'</td>';
                    echo "\n".'<td><input type="text" id="username'.$user['ID'].'" name="username'.$user['ID'].'" value="'.$user['username'].'"></td>';
                    echo "\n".'<td><input type="text" id="email'.$user['ID'].'" name="email'.$user['ID'].'" value="'.$user['email'].'"></td>';
                    echo "\n".'<td>';
                    echo selectRol($user['ID'], $user['role']).'</td>';
                    echo "\n".'<td><button type="submit" style="background-color:IndianRed" name="deleteUser" value="'.$user['ID'].'">Delete user</button></td>';
                    echo "\n".'<td><button type="submit" style="background-color:LightSteelBlue" name="updateUser" value="'.$user['ID'].'">Update user data</button></td>';
                    echo '</tr>';
                }else{
                    echo "\n".'<tr>';
                    echo "\n".'<td>'.$user['ID'].'</td>';
                    echo "\n".'<td><input type="text" id="username'.$user['ID'].'" name="username'.$user['ID'].'" value="'.$user['username'].'" readonly></td>';
                    echo "\n".'<td><input type="text" id="email'.$user['ID'].'" name="email'.$user['ID'].'" value="'.$user['email'].'" readonly></td>';
                    echo "\n".'<td>';
                    echo selectRol($user['ID'], $user['role']).'</td>';
                    echo '</tr>';
                }
            }
        }
        echo '</table><br>';
    ?>
    <input type="submit" value="USER MENU" name="menu">
    </form>
    <?php  
        if(isset($_POST['updateUser'])){    
            $startSession = connToDB()->prepare("UPDATE users SET users.username = :username, users.email  = :email, users.role = :rol WHERE users.ID = :id;");
            $startSession->bindParam(':id', $_POST['updateUser']);
            $startSession->bindParam(':username', $_POST['username'.$user['ID']]);
            $startSession->bindParam(':email', $_POST['email'.$user['ID']]);
            $startSession->bindParam(':rol', $_POST['select'.$user['ID']]);
            $startSession->execute();
            header("Location: admin_users.php");
        }

        if(isset($_POST['deleteUser'])){
            $_SESSION['deleteUser'] = $_POST['deleteUser'];
            header("Location: ./deleteUser.php");
            exit();
        }

        if(isset($_POST['menu'])){
            header("Location: ./main.php");
            exit;
        }
    ?>

</body>
</html>