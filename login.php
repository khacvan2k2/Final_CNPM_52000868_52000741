
<?php
session_start();
include "./config/connectDB.php";


if(isset($_POST['login'])) {
    $username= $_POST['username'];
    $pwd = $_POST['password'];
    $error='';
    if($username=='' || $pwd ==''){
        $error = '<div class="alert alert-danger">Xin nhập đủ đầy đủ thông tin</div>';
    } else {
        $account= mysqli_query($conn,
            "SELECT * FROM accounts WHERE username='$username' AND pwd='$pwd'");
        $row = mysqli_fetch_assoc($account);

        if($row && $row['account_role']==='1'){

            header("Location: ./admin/admin.php");
            $_SESSION['username'] = $username;



        }else if($row && $row['account_role']==='0'){
            header("Location: ./customers/index.php");
            $_SESSION['username'] = $username;


        }
        else{
            $error = '<div class="alert alert-danger">Sai thông tin tài khoản hoặc mật khẩu</div>';

        }


    }

}


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng nhập | Website quản lí cây kiểng</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <div class="login100-pic js-tilt" data-tilt>
                    <img src="uploads/user.jpg" alt="IMG">
                </div>
                <!--=====TIÊU ĐỀ======-->
                <form class="login100-form validate-form" method="POST" action="">
                    <span class="login100-form-title">
                        <b>ĐĂNG NHẬP WEB SITE</b>
                    </span>
                    <!--=====FORM INPUT TÀI KHOẢN VÀ PASSWORD======-->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>">
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" placeholder="Tài khoản" name="username"
                                id="username">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-user'></i>
                            </span>
                        </div>
                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Mật khẩu"
                                   name="password" id="password-field">
                            <span toggle="#password-field" class="bx fa-fw bx-hide field-icon click-eye"></span>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-key'></i>
                            </span>
                        </div>

                        <!--=====ĐĂNG NHẬP======-->
                        <div class="container-login100-form-btn">
                            <input type="submit" value="Đăng nhập" id="submit"  name="login"/>
                        </div>
                        <br>

                          <div class="has-error">
                              <?php echo (isset($error)) ? $error: "" ?>
                          </div>



                        <!--=====LINK TÌM ĐĂNG KÝ TÀI KHOẢN======-->
                        <div class="register text-left p-t-12">
                            <a class="txt2" href="register.php">
                                    Bạn chưa có tài khoản?
                            </a>
                        </div>

                            <!--=====LINK TÌM MẬT KHẨU======-->
                        <div class="forget text-right p-t-12" >
                            <a class="txt2" href="forgot.php">
                                    Bạn quên mật khẩu?
                            </a>
                        </div>
                    </form>



                    <!--=====FOOTER======-->
                    <div class="text-center p-t-70 txt2">
                        Web site cây kiểng <i class="far fa-copyright" aria-hidden="true"></i>
                        <script type="text/javascript">document.write(new Date().getFullYear());</script> <a
                            class="txt2" href="#"> Code bởi 52000868 - 52000741</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--Javascript-->
    <script src="/js/main.js"></script>
    <script src="https://unpkg.com/boxicons@latest/dist/boxicons.js"></script>
    <script type="text/javascript">
        //show - hide mật khẩu
        function myFunction() {
            var x = document.getElementById("myInput");
            if (x.type === "password") {
                x.type = "text"
            } else {
                x.type = "password";
            }
        }
        $(".click-eye").click(function () {
            $(this).toggleClass("bx-show bx-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") == "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });

        setTimeout("document.getElementsByClassName('has-error').innerHTML=''",3000);

    </script>
</body>

</html>