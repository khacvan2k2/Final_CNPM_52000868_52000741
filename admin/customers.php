<?php
session_start();
require '../config/connectDB.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Danh sách khách hàng | Quản trị Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">

</head>

<body onload="time()" class="app sidebar-mini rtl">
<!-- Navbar-->
<header class="app-header">
    <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar"
                                    aria-label="Hide Sidebar"></a>
    <!-- Navbar Right Menu-->
    <ul class="app-nav">


        <!-- User Menu-->
        <li><a class="app-nav__item" href="../login.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

        </li>
    </ul>
</header>
<!-- Sidebar menu-->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
    <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="../uploads/hay.jpg" width="50px"
                                        alt="User Image">
        <div>
            <p class="app-sidebar__user-name"><b>Admin</b></p>
            <p class="app-sidebar__user-designation">Chào mừng bạn trở lại</p>
        </div>
    </div>
    <hr>
    <ul class="app-menu">
        <li><a class="app-menu__item " href="./accounts.php"><i class='app-menu__icon bx bx-id-card'></i> <span
                        class="app-menu__label">Quản lý tài khoản</span></a></li>
        <li><a class="app-menu__item" href="./customers.php"><i class='app-menu__icon bx bx-user-voice'></i><span
                        class="app-menu__label">Quản lý khách hàng</span></a></li>

        <li><a class="app-menu__item" href="./product.php"><i
                        class='app-menu__icon bx bx-purchase-tag-alt'></i><span class="app-menu__label">Quản lý sản phẩm</span></a>
        </li>

        <li><a class="app-menu__item" href="./receipt.php"><i class='app-menu__icon bx bx-task'></i><span
                        class="app-menu__label">Quản lý đơn hàng</span></a></li>



    </ul>


</aside>
<main class="app-content">
    <div class="app-title">
        <ul class="app-breadcrumb breadcrumb side">
            <li class="breadcrumb-item active"><a href="#"><b>Danh sách khách hàng</b></a></li>
        </ul>
        <div id="clock"></div>
    </div>

    <?php if (isset($_SESSION['response'])) { ?>
        <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b><?= $_SESSION['response']; ?></b>
        </div>
    <?php } unset($_SESSION['response']); ?>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">

                    <div class="row element-button">

                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm nhap-tu-file" type="button" title="Nhập" onclick="myFunction(this)"><i
                                        class="fas fa-file-upload"></i> Tải từ file</a>
                        </div>

                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm print-file" type="button" title="In" onclick="myApp.printTable()"><i
                                        class="fas fa-print"></i> In dữ liệu</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm print-file js-textareacopybtn" type="button" title="Sao chép"><i
                                        class="fas fa-copy"></i> Sao chép</a>
                        </div>

                        <div class="col-sm-2">
                            <a class="btn btn-excel btn-sm" href="" title="In"><i class="fas fa-file-excel"></i> Xuất Excel</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm pdf-file" type="button" title="In" onclick="myFunction(this)"><i
                                        class="fas fa-file-pdf"></i> Xuất PDF</a>
                        </div>
                        <div class="col-sm-2">
                            <a class="btn btn-delete btn-sm" type="button" title="Xóa" onclick="myFunction(this)"><i
                                        class="fas fa-trash-alt"></i> Xóa tất cả </a>
                        </div>
                    </div>
                    <table class="table table-hover table-bordered"
                           id="sampleTable">
                        <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th class="text-center">Mã KH</th>
                            <th class="text-center">Mã tài khoản</th>
                            <th class="text-center">Họ và tên</th>
                            <th class="text-center">Số điện thoại</th>
                            <th class="text-center">Email</th>
                            <th class="text-center">Ngày sinh</th>
                            <th class="text-center">Giới tính</th>
                            <th class="text-center">Địa chỉ</th>
                            <th class="text-center">Số CMND</th>
                            <th width="100" class="text-center">Tính năng</th>
                        </tr>
                        </thead>
                        <tbody>


                        <?php
                        $query ="select * from customers";
                        $query_run= mysqli_query($conn,$query);

                        if(mysqli_num_rows($query_run) > 0){


                            foreach($query_run as $customers){
                                $day = $customers['birthday'];
                                $sql = "select date_format('$day','%d/%m/%Y')";
                                $birthday = mysqli_fetch_array(mysqli_query($conn,$sql));
                                ?>

                                <tr>

                                    <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                    <td> <?php echo $customers['customer_id'] ?></td>
                                    <td> <?= $customers['account_id'] ?></td>
                                    <td> <?= $customers['fullname'] ?></td>
                                    <td> <?= $customers['phone'] ?></td>
                                    <td> <?= $customers['email'] ?></td>
                                    <td> <?= $birthday[0]?></td>
                                    <td> <?= $customers['sex'] ?></td>
                                    <td> <?= $customers['address'] ?></td>
                                    <td> <?= $customers['identity_id'] ?></td>

                                    <td>
                                        <a class="btn btn-primary btn-sm trash" href="controller.php?deleteCustomer=<?=$customers['customer_id'];?>" title="Xóa" onclick="return confirm('Do you want delete this record?');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>

                                        <button class="btn btn-primary btn-sm editCustomer" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                                data-target="#ModalUP"><i class="fas fa-edit"></i>
                                        </button>


                                    </td>
                                </tr>


                                <?php
                            }
                        }
                        ?>


                        </tbody>
                    </table>
                </div>
            </div
        </div>
    </div>

    <?php if (isset($_SESSION['response'])) { ?>
        <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b><?= $_SESSION['response']; ?></b>
        </div>
    <?php } unset($_SESSION['response']); ?>


</main>



<div class="modal fade" id="ModalUP" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">

    <div class="modal-dialog modal-dialog-centered" role="document">

        <form action="controller.php" method="POST">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group  col-md-12">
                          <span class="thong-tin-thanh-toan">
                            <h5>Chỉnh sửa thông khách hàng</h5>
                          </span>
                        </div>
                    </div>


                    <div class="row">
                        <input type="hidden" name="customer_id" id="customer_id">


                        <div class="form-group col-md-6">
                            <label class="control-label">Họ tên</label>
                            <input class="form-control" name="fullname" id="fullname" type="text">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Số điện thoại</label>
                            <input class="form-control" name="phone" id="phone" type="text">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Ngày sinh</label>
                            <input class="form-control" name="birth" id="birth" type="date">
                        </div>


                        <div class="form-group col-md-6">
                            <label for="exampleSelect1" class="control-label">Giới tính</label>
                            <select class="form-control" name="sex" id="sex">
                                <option>Nam</option>
                                <option>Nữ</option>
                            </select>
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Địa chỉ</label>
                            <input class="form-control" name="address" id="address" type="text">
                        </div>

                        <div class="form-group col-md-6">
                            <label class="control-label">Số CMND</label>
                            <input class="form-control" name="identity_id" id="identity_id" type="text">
                        </div>
                    </div>

                    <BR>
                    <BR>
                    <BR>
                    <button class="btn btn-save" type="submit" name="updateCustomer">Lưu lại</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                    <BR>
                </div>
            </div>
        </form>
    </div>
</div>
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
<!-- Data table plugin-->
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/plugins/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">


    $('#sampleTable').DataTable();

    //Thời Gian
    function time() {
        var today = new Date();
        var weekday = new Array(7);
        weekday[0] = "Chủ Nhật";
        weekday[1] = "Thứ Hai";
        weekday[2] = "Thứ Ba";
        weekday[3] = "Thứ Tư";
        weekday[4] = "Thứ Năm";
        weekday[5] = "Thứ Sáu";
        weekday[6] = "Thứ Bảy";
        var day = weekday[today.getDay()];
        var dd = today.getDate();
        var mm = today.getMonth() + 1;
        var yyyy = today.getFullYear();
        var h = today.getHours();
        var m = today.getMinutes();
        var s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        nowTime = h + " giờ " + m + " phút " + s + " giây";
        if (dd < 10) {
            dd = '0' + dd
        }
        if (mm < 10) {
            mm = '0' + mm
        }
        today = day + ', ' + dd + '/' + mm + '/' + yyyy;
        tmp = '<span class="date"> ' + today + ' - ' + nowTime +
            '</span>';
        document.getElementById("clock").innerHTML = tmp;
        clocktime = setTimeout("time()", "1000", "Javascript");

        function checkTime(i) {
            if (i < 10) {
                i = "0" + i;
            }
            return i;
        }
    }


    //In dữ liệu
    var myApp = new function () {
        this.printTable = function () {
            var tab = document.getElementById('sampleTable');
            var win = window.open('', '', 'height=700,width=700');
            win.document.write(tab.outerHTML);
            win.document.close();
            win.print();
        }
    }


         //Sao chép dữ liệu
      var copyTextareaBtn = document.querySelector('.js-textareacopybtn');

      copyTextareaBtn.addEventListener('click', function(event) {
      var copyTextarea = document.querySelector('.js-copytextarea');
      copyTextarea.focus();
      copyTextarea.select();

      try {
        var successful = document.execCommand('copy');
        var msg = successful ? 'successful' : 'unsuccessful';
        console.log('Copying text command was ' + msg);
      } catch (err) {
        console.log('Oops, unable to copy');
      }
    });





    //Modal
    $("#show-emp").on("click", function () {
        $("#ModalUP").modal({ backdrop: false, keyboard: false })
    });
</script>


<script>

    $(document).ready(function () {

        $('.editCustomer').on('click', function () {

            $('#ModalUP').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);
            $('#customer_id').val(data[1]);
            $('#fullname').val(data[3]);
            $('#phone').val(data[4]);
            $('#birth').val(data[6]);
            $('#sex :selected').text();
            $('#address').val(data[8]);

            $('#identity_id').val(data[9]);




        });
    });
</script>


</body>

</html>