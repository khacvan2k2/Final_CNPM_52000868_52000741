<?php
include "../config/connectDB.php";
include "../session.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Quản trị Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="css/main.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap4.min.css">

    <!-- or -->
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
            <li class="breadcrumb-item active"><a href="#"><b>Danh sách sản phẩm</b></a></li>
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
                            <a class="btn btn-add btn-sm" type="button" href="./add_Product.php" title="Thêm" ><i class="fas fa-plus"> Tạo sản phẩm mới</i></a>
                        </div>

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
                    <table class="table table-hover table-bordered" id="sampleTable">
                        <thead>
                        <tr>
                            <th width="10"><input type="checkbox" id="all"></th>
                            <th class="text-center">Mã sản phẩm</th>
                            <th class="text-center">Tên sản phẩm</th>
                            <th width="100px;" class="text-center">Hình ảnh</th>
                            <th class="text-center">Mô tả</th>
                            <th class="text-center">Loại sản phẩm</th>
                            <th class="text-center">Số lượng trong kho</th>
                            <th width="120px;" class="text-center">Giá bán</th>
                            <th class="text-center">Trạng thái</th>
                            <th width="65px;" class="text-center">Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                        $query ="select * from bonsai";
                        $query_run= mysqli_query($conn,$query);

                        if(mysqli_num_rows($query_run) > 0){
                            foreach($query_run as $bonsai){
                                if($bonsai['status_id']==1){
                                    $bonsai['status_id'] = "Còn hàng";
                                    $status = 'badge bg-success' ;
                                }else{
                                    $bonsai['status_id'] = "Hết hàng";
                                    $status = 'badge bg-danger' ;
                                }

                                $id=$bonsai['type_id'];
                                $name_type = "select type_name from bonsaiType
                                                       where type_id='$id'";
                                $name_type_run = mysqli_fetch_assoc(mysqli_query($conn,$name_type)) ;

                                ?>
                                <tr>
                                    <td width="10"><input type="checkbox" name="check1" value="1"></td>
                                    <td> <?= $bonsai['bonsai_id'] ?></td>
                                    <td> <?= $bonsai['bonsai_name'] ?></td>
                                    <td> <img src="<?= $bonsai['bonsai_img']?>" width="100px;" height="100px;"> </td>
                                    <td> <?= $bonsai['describe_bonsai'] ?></td>
                                    <td> <?= $name_type_run['type_name'] ?></td>
                                    <td> <?= $bonsai['amount'] ?></td>
                                    <td>  <?= $bonsai['price'] ?> VND</td>
                                    <td> <span class='<?=$status ?>'><?= $bonsai['status_id']?> </span></td>

                                    <td>
                                        <button class="btn btn-primary btn-sm trash deletePro" type="button" title="Xóa" id="show-emp" data-toggle="modal"
                                                data-target="#deletemodal"><i class="fas fa-trash-alt"></i>
                                        </button>


                                        <button class="btn btn-primary btn-sm editPro" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                                data-target="#modalEdit"><i class="fas fa-edit"></i>
                                        </button>

                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</main>




<!--   Modal edit products-->
<div class="modal fade" id="modalEdit" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="controller.php" method="POST" >
            <div class="modal-content">

                <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="product_id" id="product_id">

                        <div class="form-group  col-md-12">
                              <span class="thong-tin-tai-khoan">
                                <h5>Chỉnh sửa thông tin sản phẩm</h5>
                              </span>
                        </div>
                    </div>
                    <hr>

                    <div class="row">

                        <input type="hidden" name="bonsai_id" id="bonsai_id">

                        <div class="form-group col-md-6">
                            <label class="control-label">Tên sản phẩm</label>
                            <input class="form-control" type="text" name="name" id="name">
                        </div>
                        <div class="form-group col-md-6">
                            <label for="exampleSelect1" class="control-label">Loại cây</label>
                            <select class="form-control" name="bonsai_type" id="bonsai_type" >
                                <option value="3">Bonsai Nghệ thuật</option>
                                <option value="4">Home Plant</option>
                                <option value="1">Office Plant</option>
                                <option value="2">Gift Plant</option>

                            </select>
                        </div>


                        <div class="form-group col-md-6">
                            <label class="control-label">Số lượng</label>
                            <input class="form-control" type="text" name="amount_pr" id="amount_pr">
                        </div>


                        <div class="form-group col-md-6">
                            <label class="control-label">Giá sản phẩm</label>
                            <input class="form-control" type="text" name="price" id="price">
                        </div>

                        <div class="form-group col-md-6">
                            <label for="exampleSelect1" class="control-label">Tình trạng</label>
                            <select class="form-control" id="status" name="status">
                                <option value="1">Còn hàng</option>
                                <option value="0">Hết hàng</option>
                            </select>
                        </div>

                        <div class="form-group  col-md-6">
                            <label class="control-label">Mô tả sản phẩm</label>
                            <textarea class="form-control" name="describe_bonsai" id="describe_bonsai"></textarea>
                            <script>CKEDITOR.replace('describe_bonsai');</script>
                        </div>

                    </div>
                    <BR>
                    <BR>
                    <BR>
                    <button class="btn btn-save" type="submit" name="edit_Product">Lưu lại</button>
                    <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                    <BR>
                </div>

            </div>
        </form>

    </div>
</div>

<!--   Modal delete products -->
<div class="modal fade" id="deletemodal" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="./controller.php" method="POST" >
            <div class="modal-content">

                <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="pro_id" id="pro_id">

                        <div class="form-group  col-md-12">
                              <span class="thong-tin-tai-khoan">
                                <h5>Xóa sản phẩm này</h5>
                              </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group  col-md-6">
                            <button class="btn btn-save" type="submit" name="delete_Product">Xác nhận</button>
                        </div>

                        <div class="form-group col-md-6">
                            <a class="btn btn-cancel" data-dismiss="modal" href="#">Hủy bỏ</a>
                        </div>

                    </div>
                    <BR>
                    <BR>
                    <BR>
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

<!-- Page specific javascripts-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>


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



</script>

<script>
    $(document).ready(function () {

        $('.deletePro').on('click', function () {

            $('#deletemodal').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#pro_id').val(data[1]);

        });
    });
</script>

<script>




    $(document).ready(function () {

        $('.editPro').on('click', function () {

            $('#modalEdit').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            $('#bonsai_id').val(data[1]);
            $('#name').val(data[2]);
            $('#describe_bonsai').val(data[4]);
            $('#bonsai_type :selected').text();
            $('#amount_pr').val(data[6]);
            $('#price').val(data[7]);
            $('#status :selected').text();

        });
    });
</script>

</body>

</html>