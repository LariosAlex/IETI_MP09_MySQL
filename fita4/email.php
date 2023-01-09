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
    <form action="email.php" method="post">
        <fieldset>
            <legend>Send Email</legend>
            <input type="text" name="email" id="email" placeholder="username@email.com"><br><br>
            <input type="text" name="subject" id="subject" placeholder="Subject"><br><br>
            <input type="text" name="content" id="content" placeholder="Content">
        </fieldset>
        <br>
        <button type="submit" name="send">Send Email</button>
    </form>
    <?php
    if(isset($_POST['send'])){ 
        if(($_POST['email'] != '' || $_POST['email'] != null) && ($_POST['subject'] != '' || $_POST['subject'] != null) && ($_POST['content'] != '' || $_POST['content'] != null)){
            sendMail($_POST['email'], $_POST['subject'], $_POST['content']);
        }else{
            echo 'Faltan datos';
        }
    }
    ?>
</body>