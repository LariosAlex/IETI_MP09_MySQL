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
        echo '<table><tr><th>ID</th><th>NOM</th><th>EMAIL</th><th>ROL</th></tr>';
        if(isset($_SESSION['username'])){
            $startSession = connToDB()->prepare("SELECT * FROM `users`;");
            $startSession->execute();            
            foreach($startSession as $user){
                echo '<tr>';
                echo '<td>'.$user['ID'].'</td>';
                echo '<td><input type="text" id="username" name="username" value="'.$user['username'].'"></td>';
                echo '<td><input type="text" id="email" name="email" value="'.$user['email'].'"></td>';
                echo '<td><select name="select">';
                if($user['role'] == 1){
                    echo '<option value="1" selected>Admin user</option>
                    <option value="2">Default user</option>';
                }else{
                    echo '<option value="1">Admin user</option>
                    <option value="2" selected>Default user</option>';
                }
                echo '</select></td>';
                echo '</tr>';
            }
        }
        echo '</table>';
    ?>
</body>
</html>