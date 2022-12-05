<?php
session_start();
include '../config/connectDB.php';



    $err ='';



$username =$_SESSION['username'];
    $sql = "select * from customers where account_id 
        in(select account_id from accounts where username='$username')";
    $result = mysqli_fetch_array(mysqli_query($conn,$sql));
    $name = $result[4];
    $email = $result[3];
    $phone = $result[2];
    $address = $result[7];
    $cmnd = $result[8];
    $sex =$result[6];
    $birthday =$result[5];

    if(isset($_POST['editProfile'])){
        $name=$_POST['name'];
        $phone=$_POST['phone'];
        $address=$_POST['address'];
        $cmnd =$_POST['cmnd'];
        $sex = $_POST['sex'];
        $birthday=$_POST['birthday'];

        if($sex=1){
            $sex='Nam';
        }else{
            $sex='Nữ';

        }
        if(strlen($name)<5){
            $err='Hãy điền đầy đủ tên của bạn';

            $_SESSION['response'] =$err;
            $_SESSION['res_type']='danger';




        }

        if(strlen($phone)<10 || strlen($cmnd)<10){
            $err='Số điện thoại và số CMND phải có 10 chữ số';

            $_SESSION['response'] =$err;
            $_SESSION['res_type']='danger';



        }


        if(empty($err)){
            $sql1 = "update customers set phone='$phone', fullname='$name', birthday='$birthday',sex='$sex', address='$address',identity_id='$cmnd'
            where customer_id 
                  in(select account_id-1 from accounts where username='$username')";
            $editProfile=mysqli_query($conn,$sql1);
            var_dump($editProfile);
            if($editProfile){
                $_SESSION['response'] ='Đã cập nhật thông tin của bạn';
                $_SESSION['res_type']='success';

            }
        }





    }












?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Thêm sản phẩm | Quản trị Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <!-- Font-icon css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script type="text/javascript" src="/ckeditor/ckeditor.js"></script>
    <script src="http://code.jquery.com/jquery.min.js" type="text/javascript"></script>

</head>

<body class="app sidebar-mini rtl">
<!-- Navbar-->
<header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
                                    aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


        <!-- User Menu-->
        <li><a class="app-nav__item" href="../logout.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

        </li>
    </ul>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="../uploads/user.jpg" width="50px"
                                        alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><b><?php echo $_SESSION['username']; ?></b></p>
            <p class="app-sidebar__user-designation">Kiểm tra thông tin của bạn</p>
        </div>
    </div>
    <hr>
    <ul class="app-menu">
        <li><a class="app-menu__item " href="./user_info.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                    class="app-menu__label">Thông tin cá nhân</span></a></li>
        <li><a class="app-menu__item" href="./cart.php"><i class='app-menu__icon bx bx-cart-alt'></i><span
                    class="app-menu__label">Giỏ hàng của bạn</span></a></li>


        <li><a class="app-menu__item" href="./receipt.php"><i class='app-menu__icon bx bx-cart-alt'></i><span
                        class="app-menu__label">Hóa đơn</span></a></li>
    </ul>

</aside>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Thông tin của bạn</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <h3 class="tile-title">Chỉnh sửa thông tin của bạn</h3>
                <div class="tile-body">

                    <form class="row" action="user_info.php" method="POST" enctype="multipart/form-data">

                        <div class="form-group col-md-6">
                            <label class="control-label">Họ và Tên</label>
                            <input class="form-control" type="text" name="name" id="name" required value="<?= $name; ?>">
                        </div>



                        <div class="form-group col-md-6">
                            <label class="control-label">Email</label>
                            <input class="form-control" type="email" name="email" id="email" disabled required value="<?= $email ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Điện thoại</label>
                            <input class="form-control" type="text" name="phone" id="phone"required value="<?= $phone; ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Ngày Sinh</label>
                            <input class="form-control" type="text" name="birthday" id="birthday"required value="<?= $birthday; ?>">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Địa chỉ</label>
                            <input class="form-control" type="text" name="address" id="address"required value="<?= $address; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="control-label">Số CMND</label>
                            <input class="form-control" type="text" name="cmnd" id="cmnd" required value="<?= $cmnd; ?>">
                        </div>
                        <div class="form-group col-md-6 ">
                            <label for="exampleSelect1" class="control-label">Giới tính</label>
                            <select class="form-control" id="sex" name="sex">
                                <option value="1">Nam</option>
                                <option value="0">Nữ</option>
                            </select>
                        </div>





                        <div class="form-group col-md-12"></div>
                        <div>
                            <button class="btn btn-save" type="submit" name="editProfile" id="editProfile">Lưu lại</button>
                            <a class="btn btn-cancel" href="./product.php">Hủy bỏ</a>
                        </div>

                    </form>

                </div>

            </div>

            <?php if (isset($_SESSION['response'])) { ?>
                <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <b><?= $_SESSION['response']; ?></b>
                </div>
            <?php } unset($_SESSION['response']); ?>
</main>



<!--
MODAL CHỨC VỤ
-->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới nhà cung cấp</h5>
              </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Nhập tên chức vụ mới</label>
                        <input class="form-control" type="text" required>
                    </div>
                </div>
                <BR>
                <button class="btn btn-save" type="button">Lưu lại</button>
                <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                <BR>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!--
MODAL
-->






<!--
MODAL TÌNH TRẠNG
-->
<div class="modal fade" id="addtinhtrang" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
     data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-body">
                <div class="row">
                    <div class="form-group  col-md-12">
              <span class="thong-tin-thanh-toan">
                <h5>Thêm mới tình trạng</h5>
              </span>
                    </div>
                    <div class="form-group col-md-12">
                        <label class="control-label">Nhập tình trạng mới</label>
                        <input class="form-control" type="text" required>
                    </div>
                </div>
                <BR>
                <button class="btn btn-save" type="button">Lưu lại</button>
                <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                <BR>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<!--
MODAL
-->


<!-- Essential javascripts for application to work-->
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="./js/main.js"></script>

<!-- The javascript plugin to display page loading on top-->
<script src="js/plugins/pace.min.js"></script>
<!-- Page specific javascripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

<!-- Page specific javascripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>


<!-- Data table plugin-->
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
<script>
</script>
</body>

</html>