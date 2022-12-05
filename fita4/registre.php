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
    ?>   
    <form action="" method="post">
        <fieldset>
            <legend>Registre d'usuaris</legend>
            <input type="text" name="username" id="username" placeholder="Username"><br><br>
            <input type="password" name="password" id="password" placeholder="Password"><br><br>
            <input type="password" name="password2" id="password2" placeholder="Repeat Password">
        </fieldset>
        <br><button type="submit">Crear usuari</button>
    </form>
    <br>

    <?php
        if(isset($_POST['password'])){
            if(hash('sha512', $_POST['password']) != hash('sha512', $_POST['password2'])){
                echo "Les contrasenyes han de ser iguals\n";
            }else{
                $startSession = connToDB()->prepare("INSERT INTO users(users.username, users.password) VALUES(:username, SHA2(:pw, 512));");
                $startSession->bindParam(':username', $_POST['username']);
                $startSession->bindParam(':pw', $_POST['password']);
                try {
                    $startSession->execute();
                } catch (PDOException $e) {
                    if($e->getCode() == 23000){
                        echo "Aquest nom d'usuari no es troba disponible\n";
                    }
                    exit;
                }
                echo "Usuari registrat correctament";
            }  
        }
    ?>
</body>
</html>