<?php
include'./config/connectDB.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_POST['checkemail'])){
  echo 'alo';

    $email = $_POST["email"];
    var_dump($email);

    if ($conn->query("SELECT * FROM accounts WHERE emil = '$email'") === FALSE) {
        echo "This Email not been Register yet!";
        exit();
    }
    function random_str($digit)
    {
        $str = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $size = strlen($chars);
        for ($i = 0; $i < $digit; $i++) {
            $str .= $chars[rand(0, $size - 1)];
        }
        return $str;
    }

    $pass = random_str(10);
    if ($conn->query("UPDATE accounts SET pwd = '$pass' WHERE email = '$email'") === TRUE) {
        $mail = new PHPMailer(true);
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER; // Enable verbose debug output
        $mail->isSMTP(); // gửi mail SMTP
        $mail->CharSet = 'UTF-8';
        $mail->Host = 'smtp.gmail.com'; // Set the SMTP server to send through
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Username = 'khacvan2k2@gmail.com'; // SMTP username
        $mail->Password = 'ezkujxspmlwrqwey';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->From = "khacvan2k2@gmail.com";
        $mail->FromName = "WebSite Cây Kiểng";

        $mail->addAddress($email);

        $mail->isHTML(true);   // Set email format to HTML
        $mail->Subject = 'Forgot PassWord';
        $mail->Body = '
            Thanks for recovery Password <br>
            Your password account has been changed, you can login with the account below<br>
            <br>
            -------------------------------<br>
            Password: ' . $pass . '<br>
            -------------------------------<br>
            <br>
            <b style="color:red">Please Change Password to Protect you account!</b> <br>
            Click this link to visit our Website:
            http://localhost/bonsai/index.php
            ';
        try {
            $mail->send();
            echo "We had sent new password to your email. Please check it!";
        } catch (Exception $e) {
            echo "Mailer Error: " . $mail->ErrorInfo;
        }
    }
}












?>

