<?php
if(isset($_SESSION)){
    session_destroy();
}
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
    <form action="main.php" method="post">
        <fieldset>
            <legend>Login</legend>
            <input type="text" name="username" id="username" placeholder="Username"><br><br>
            <input type="password" name="password" id="password" placeholder="Password">
        </fieldset>
        <br><button type="submit">Iniciar sessió</button><br><br>
    </form>
</body>
</html>