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
    <?php
        function selectRol(){
            $startSession = connToDB()->prepare("SELECT * FROM `tipus_usuari`;");
            $startSession->execute();
            echo '<select id="rol"name="rol">';
            foreach($startSession as $rol){
                echo '<option value="'.$rol['roleID'].'">'.$rol['roleName'].'</option>';
            }
            echo '</select>';
        }
    ?>
        <form action="" method="post">
            <fieldset>
                <legend>User registration</legend>
                <input type="text" name="newUsername" id="newUsername" placeholder="Username"><?php echo selectRol()?><br><br>
                <input type="password" name="newPassword" id="newPassword" placeholder="Password"><br><br>
                <input type="password" name="password2" id="password2" placeholder="Repeat Password"><br><br>
                <input type="text" name="email" id="email" placeholder="Email">
            </fieldset>
            <br><button type="submit">Create user</button>
        </form>

    <?php

        if(isset($_POST['newPassword'])){
            if(hash('sha512', $_POST['newPassword']) != hash('sha512', $_POST['password2'])){
                echo "Les contrasenyes han de ser iguals\n";
            }else{
                $startSession = connToDB()->prepare("INSERT INTO users(users.username, users.password, users.email, users.role) VALUES(:username, SHA2(:pw, 512), :email, :rol);");
                $startSession->bindParam(':username', $_POST['newUsername']);
                $startSession->bindParam(':pw', $_POST['newPassword']);
                $startSession->bindParam(':email', $_POST['email']);
                $startSession->bindParam(':rol', $_POST['rol']);
                try {
                    $startSession->execute();
                } catch (PDOException $e) {
                    if($e->getCode() == 23000){
                        echo "Aquest nom d'usuari no es troba disponible\n";
                    }
                    exit;
                }
                echo "Usuari registrat correctament";
                header("Location: ./login.php");
            }  
        }
    ?>
</body>
</html>