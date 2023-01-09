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
<h1>DELETE USER</h1>
<h3>YOU ARE TRYING TO DELETE THE USER:</h3>
    <?php
        function deleteUser($userID){
            $startSession = connToDB()->prepare("DELETE FROM users WHERE users.ID = :id;");
            $startSession->bindParam(':id', $userID);
            $startSession->execute();
            header("Location: admin_users.php");
        }
        
        $startSession = connToDB()->prepare("SELECT * FROM `users` WHERE users.ID = :id;");
        $startSession->bindParam(':id', $_SESSION['deleteUser']);
        $startSession->execute();

        foreach($startSession as $user){
            echo '<a><strong>ID</strong>: '.$user['ID'].'</a><br>';
            echo '<a><strong>NAME</strong>: '.$user['username'].'</a><br>';
            echo '<a><strong>EMAIL</strong>: '.$user['email'].'</a><br>';
            echo '<a><strong>ROL</strong>: '.$user['role'].'</a><br>';
        }
    ?>
<h3>ARE YOU SURE TO DELETE PERMANETLY THIS USER?</h3>
<form action="" method="post">
<input type="submit" style="background:lime" value="YES, I WANT TO DELETE THE USER" name="delete">
<input type="submit" style="background:red" value="NO I DON'T WANT TO DO IT" name="noDelete">
</form>
<?php 
    if(isset($_POST['noDelete'])){
        header("Location: ./admin_users.php");
        exit;
    }
    if(isset($_POST['delete'])){
        deleteUser($_SESSION['deleteUser']);
        $_SESSION['deleteUser'] = '';
    }
?>
</body>
</html>