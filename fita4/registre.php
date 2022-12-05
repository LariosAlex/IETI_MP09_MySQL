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
    <form action="protectedLogin.php" method="post">
        <input type="text" name="username" id="username" placeholder="Username"><br>
        <input type="password" name="password" id="password" placeholder="Password"><br><br>
        <input type="password" name="password2" id="password2" placeholder="Repeat Password"><br><br>
        <button type="submit">Iniciar sessió</button><br><br>
    </form>

    <?php
</body>
</html>