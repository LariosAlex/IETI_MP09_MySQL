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

    function infoUser(){
        $startSession = connToDB()->prepare("SELECT * FROM `users` WHERE users.ID = :id;");
        $startSession->bindParam(':id', $_SESSION['ID']);
        $startSession->execute();
        $userInformation = [];
        foreach($startSession as $user){
            $userInformation['username'] = $user['username'];
            $userInformation['role'] = $user['role'];
            $userInformation['email'] = $user['email'];
        }
        return $userInformation;
    }
?>