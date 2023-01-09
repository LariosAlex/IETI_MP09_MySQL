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
    <h1>REGISTRE D'USUARIS</h1>  
    <form action="login.php" method="post">
        <input type="text" name="username" id="username" placeholder="Username"><br>
        <input type="text" name="password" id="password" placeholder="Password"><br><br>
        <button type="submit">Iniciar sessió</button><br><br>
    </form>

    <?php
        if(isset($_POST['username'])){
            $startSession = connToDB()->prepare("SELECT * FROM `users` WHERE users.username = '".$_POST['username']."' AND users.password = SHA2('".$_POST['password']."', 512);");
            $startSession->execute();
            if($startSession->rowCount() != 1){
                echo 'Login incorrecte';
            }else{
                foreach($startSession as $user){
                    echo 'Benvingut '.$user['username']. "<br>\n";
                }
            }
        }
    ?>
</body>
</html>