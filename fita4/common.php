<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

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

    function sendMail($adress, $title, $content){
        require 'vendor/phpmailer/phpmailer/src/Exception.php';
        require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
        require 'vendor/phpmailer/phpmailer/src/SMTP.php';

        $mail = new PHPMailer();
        $mail->IsSMTP();
        $mail->Mailer = "smtp";

        $mail->SMTPDebug  = 1;  
        $mail->SMTPAuth   = TRUE;
        $mail->SMTPSecure = "tls";
        $mail->Port       = 587;
        $mail->Host       = "smtp.gmail.com";
        $mail->Username   = "alariosalmendros.cf@iesesteveterradas.cat";
        $mail->Password   = "**********";

        $mail->IsHTML(true);
        $mail->AddAddress($adress);
        $mail->Subject = $title;

        $mail->MsgHTML($content); 
        if(!$mail->Send()) {
            echo "Error while sending Email.";
        } else {
            echo "Email sent successfully";
        }
    }
?>