<?php
session_start();
include '../config/connectDB.php';

if (isset($_GET['pid'])){
    $id = $_GET['pid'];
    $username = $_SESSION['username'];



    $sql ="select * from cart where bonsai_id='$id'";

    $sql_run = mysqli_fetch_assoc(mysqli_query($conn,$sql));


    $sql2 ="select customer_id from customers
                 where customer_id 
                  in(select account_id-1 from accounts where username='$username')";
    $customer =  mysqli_fetch_assoc(mysqli_query($conn,$sql2));
    $customer_id =$customer['customer_id'];




    if($sql_run==NULL){

        $insert_cart = "insert into cart(customer_id,bonsai_id,amount)
                            values ($customer_id,$id,1)";

        mysqli_query($conn,$insert_cart);


//        $update_amount ="update bonsai set amount=amount-1
//                where bonsai_id ='$id' ";
//        mysqli_query($conn,$update_amount);


        $_SESSION['response']="Thêm sản phẩm thành công!";
        $_SESSION['res_type']="success";
    }else{
       $sql3="update cart set amount=amount+1 
                    where bonsai_id='$id'";
         mysqli_query($conn,$sql3);
//        $update_amount ="update bonsai set amount=amount-1
//                where bonsai_id ='$id' ";
//        mysqli_query($conn,$update_amount);
        $_SESSION['response']="Thêm sản phẩm thành công!";
        $_SESSION['res_type']="success";

    }




}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <title>Giỏ hàng</title>
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
            <p class="app-sidebar__user-designation">Kiểm tra giỏ hàng của bạn</p>
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
            <li class="breadcrumb-item">Thông tin giỏ hàng</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <div class="row element-button">
                        <div class="col-sm-2">
                            <button class="btn btn-add btn-sm" type="button" title="Sửa" id="show-emp" data-toggle="modal"
                                    data-target="#modalAdd"> <i class="fas fa-plus"> <a href="./index.php">Thêm sản phẩm</a></i></button>
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
                            <th >Số TT</th>
                            <th >Mã đơn</th>
                            <th class="text-center">Tên sản phẩm</th>
                            <th class="text-center">Hình ảnh</th>
                            <th >Số lượng</th>
                            <th class="text-center">Loại sản phẩm</th>
                            <th class="text-center">Giá</th>
                            <th width="100" class="text-center">Tác vụ</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php

                        $username=$_SESSION['username'];
                        $query ="select * from cart where customer_id 
                            in(select account_id-1 from accounts where username='$username')";
                        $query_run= mysqli_query($conn,$query);
                        $sum=0;


                        if(mysqli_num_rows($query_run) > 0){
                            $i=1;
                            foreach($query_run as $cart){
                                $bonsai_id=$cart['bonsai_id'];
                                $sql = "select bonsai_name,bonsai_img,price,type_id
                                            from bonsai where bonsai_id='$bonsai_id'";
                                $result=mysqli_fetch_assoc(mysqli_query($conn,$sql));
                                if($result['type_id']==1){
                                    $result['type_id']='Office Plan';
                                }elseif($result['type_id']==2){
                                    $result['type_id']='Gift Plant';
                                }elseif($result['type_id']==3){
                                    $result['type_id']='Bonsai';
                                } else{
                                    $result['type_id']='Home Plant';
                                }

                                ?>
                                <tr>
                                    <td> <?= $i?></td>
                                    <td> <?= $cart['cart_id'];?></td>

                                    <td> <?= $result['bonsai_name'] ?></td>
                                    <td width="100px;"><img width="100px;" height="100px;" src="<?=$result['bonsai_img'] ?>" alt=""> </td>
                                    <td width="150px;">
                                        <input  aria-label="quantity" class="input-qty" max="Số tối đa" min="Số tối thiểu" name="amount" type="number" value="<?= $cart['amount'] ?>">
                                    </td>
                                    <td> <?= $result['type_id']?></td>
                                    <td> <?=  $result['price']*$cart['amount'] ?> VND</td>
                                    <td>
                                        <button class="btn btn-primary btn-sm trash deletePro" type="button" title="Xóa" id="show-emp" data-toggle="modal"
                                                data-target="#modalDelete"><i class="fas fa-trash-alt"></i>
                                        </button>


                                        <button class="btn btn-success btn-sm" type="button" title="Xóa" id="show-emp" data-toggle="modal"
                                                data-target="#modalDelete"><i class="fas fa-check-double"></i>
                                        </button>

                                    </td>
                                </tr>

                                <?php
                                $i+=1;
                                $sum+=$result['price']*$cart['amount'];
                            }
                        }
                        ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <button type="button" disabled class="btn btn-primary">Tổng tiền cần thanh toán <?=  $sum;?> VND</button>
            <button type="submit"  class="btn btn-success pay">Thanh toán</button>


        </div>
    </div>
    <?php if (isset($_SESSION['response'])) { ?>
        <div class="alert alert-<?= $_SESSION['res_type']; ?> alert-dismissible text-center">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <b><?= $_SESSION['response']; ?></b>
        </div>
    <?php } unset($_SESSION['response']); ?>
</main>






<div class="modal fade" id="modalDelete" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static"
     data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form action="controller.php" method="POST" >
            <div class="modal-content">

                <div class="modal-body">

                    <div class="row">
                        <input type="hidden" name="delete_id" id="delete_id">

                        <div class="form-group  col-md-12">
                              <span class="thong-tin-tai-khoan">
                                <h5>Xóa sản phẩm khỏi giỏ hàng</h5>
                              </span>
                        </div>
                    </div>
                    <hr>
                    <div class="row">

                        <div class="form-group  col-md-6">
                            <button class="btn btn-save" type="submit" name="deleteProduct">Xác nhận</button>

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
<script>

    $(document).ready(function () {

        $('.deletePro').on('click', function () {

            $('#modalDelete').modal('show');

            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#delete_id').val(data[1]);

        });
    });
</script>
</body>

</html>