<?php
require './config/connectDB.php';




use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if(isset($_GET['check-email'])){


    $email = $_GET["email"];


    if ($conn->query("SELECT * FROM accounts WHERE email = '$email'") === FALSE) {
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
                Chúng tôi đã thay đổi mật khẩu cho bạn hãy kiểm tra ở dưới:<br>
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
            $_SESSION['response'] = "Chúng tôi đã gửi mật khẩu mới về email của bạn - Hãy kiểm tra!";
            $_SESSION['res_type']='success';

        } catch (Exception $e) {
            $_SESSION['response'] = "Lỗi: " . $mail->ErrorInfo;
            $_SESSION['res_type']='danger';

        }
}
}


?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Khôi phục mật khẩu | Website quản lí cây kiểng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="./css/util.css">
    <link rel="stylesheet" type="text/css" href="./css/main.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="uploads/fg-img.png" alt="IMG">
              </div>
                <form class="login100-form validate-form">
                    <span class="login100-form-title">
                        <b>KHÔI PHỤC MẬT KHẨU</b>
                    </span>
                    <form action="forgot.php" method="POST">
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="email" placeholder="Nhập email" name="email" id="email">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-mail-send' ></i>
                            </span>
                        </div>


                        <div class="container-login100-form-btn">
                            <input  type="submit" name="check-email"  id=check-email" value="Gửi">
                        </div>

                        <div class="text-center p-t-12">
                            <a class="txt2" href="./login.php">
                                Trở về đăng nhập
                            </a>
                        </div>


                        <br>
                        <?php if (isset($_SESSION['response'])) { ?>
                            <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
                                <button type="button" class="close" data-dismiss="alert">&times</button>
                                <b style='color:red'><?= $_SESSION['response']; ?></b>
                            </div>
                        <?php } unset($_SESSION['response']); ?>

                    </form>
                    <div class="text-center p-t-70 txt2">
                        Web site cây kiểng <i class="far fa-copyright" aria-hidden="true"></i>
                        <script type="text/javascript">document.write(new Date().getFullYear());</script> <a
                            class="txt2" href="#"> Code bởi 52000868 - 52000741</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
   <!--===============================================================================================-->
   <script src="/js/main.js"></script>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>

   
</body>
</html>