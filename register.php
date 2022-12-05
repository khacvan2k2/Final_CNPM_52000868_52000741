<?php
    session_start();
    include "./config/connectDB.php";


    $err =[];

    if(isset($_POST['register'])){
        $username = $_POST['username'];
        $email = $_POST["email"];
        $password =$_POST['password'];
        $re_password = $_POST['re-password'];


        /* Kiểm tra email đã tồn tại hay chưa*/
        $sql_check="select * from accounts where email='$email'";
        $check =mysqli_query($conn,$sql_check);
        $data=mysqli_fetch_array($check);

        if(empty($username)){
            $err['username'] = 'Bạn chưa nhập tên tài khoản';
        }
        if($data!=null && $username==$data[2]){
            $err['username'] = 'Tên tài khoản đã tồn tại';
        }
        if(strlen($username)<6){
            $err['username'] = 'Tên tài khoản phải có ít nhất 6 ký tự';
        }
        if(empty($email)){
            $err['email'] = 'Bạn chưa nhập email';
        }
        if($data!=null && $email==$data[1]){
            $err['email'] = 'Email đã tồn tại';
        }
        if(empty($password)){
            $err['password'] = 'Bạn chưa nhập mật khẩu';
        }
        if(strlen($password)<6){
            $err['password'] = 'Mật khẩu phải có ít nhất 6 ký tự';
        }
        if($password!=$re_password){
            $err['re-password'] = 'Mật khẩu nhập lại không đúng';
        }


        if(empty($err)){
            $sql = "insert into accounts(email,username,pwd,account_role) values('$email','$username','$password',0)";
            $query = mysqli_query($conn,$sql);



            /*Tạo một khách hàng với thông tin email của account vừa tạo*/
            $sql_check1="select * from accounts where email='$email'";
            $check1 =mysqli_query($conn,$sql_check1);
            $data1=mysqli_fetch_array($check1);



            $sql2 = "insert into customers(account_id,email) values ('$data1[0]','$data1[1]')";
            $query1 = mysqli_query($conn,$sql2);
            if($query==true && $query1==true){
                header("Location: login.php");
            }
        }



    }




?>



<!DOCTYPE html>
<html lang="en">

<head>
    <title>Đăng ký tài tài khoản | Website quản lí cây kiểng</title>
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
        <div class="container-register100">
            <div class="wrap-register100">
                <div class="register100-pic js-tilt" data-tilt>
                    <img src="uploads/register.png" alt="IMG">
                </div>
                <!--=====TIÊU ĐỀ======-->
                <form class="register100-form validate-form" method="POST">
                    <span class="register100-form-title">
                        <b>ĐĂNG KÝ TÀI KHOẢN</b>
                    </span>
                    <!--=====FORM INPUT TÀI KHOẢN VÀ PASSWORD======-->
                    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
                        <div class="wrap-input100 validate-input">
                            <input class="input100" type="text" placeholder="Tên tài khoản" name="username"
                                id="username">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-user'></i>
                            </span>
                        </div>

                        <div class="has-error">
                            <span>
                                <?php echo(isset($err['username']))?$err['username']:'' ?>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="email" placeholder="Email"
                                name="email" id="email">
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bxl-gmail'></i>
                            </span>
                        </div>

                        <div class="has-error">
                            <span>
                                <?php echo(isset($err['email']))?$err['email']:'' ?>
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

                        <div class="has-error">
                            <span>
                                <?php echo(isset($err['password']))?$err['password']:'' ?>
                            </span>
                        </div>

                        <div class="wrap-input100 validate-input">
                            <input autocomplete="off" class="input100" type="password" placeholder="Nhập lại mật khẩu"
                                name="re-password" id="password-field">
                            <span toggle="#password-field" class="bx fa-fw bx-hide field-icon click-eye"></span>
                            <span class="focus-input100"></span>
                            <span class="symbol-input100">
                                <i class='bx bx-check-square'></i>
                            </span>
                        </div>



                        <div class="has-error">
                            <span>
                                <?php echo(isset($err['re-password']))?$err['re-password']:'' ?>
                            </span>
                        </div>
                        <!--=====ĐĂNG KY======-->
                        <div class="container-register100-form-btn">
                            <input type="submit" value="Đăng ký" id="submit" name="register" onclick="validateRegister()" />
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
    <script>
        //show - hide mật khẩu

        $(".click-eye").click(function () {
            $(this).toggleClass("bx-show bx-hide");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
        setTimeout("document.getElementsByClassName('has-error').innerHTML=''",3000);
    </script>
</body>

</html>