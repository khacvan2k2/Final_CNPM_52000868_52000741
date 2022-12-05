<?php
session_start();
require '../config/connectDB.php';



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
        <li><a class="app-nav__item" href="./index.php"><i class='bx bx-log-out bx-rotate-180'></i> </a>

        </li>
    </ul>
</header>

</aside>
<main class="app-content">
    <div class="app-title col-md-10">
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item">Thông tin sản phẩm</li>
        </ul>
    </div>


    <div class="row">
        <div class="col-md-10">

            <?php
            if (isset($_GET['id'])){
                $id = $_GET['id'];

                $query ="select * from bonsai where bonsai_id='$id'";
                $query_run= mysqli_query($conn,$query);

                if(mysqli_num_rows($query_run) > 0){
                    foreach($query_run as $bonsai){
                        if($bonsai['status_id']==0){
                            $bonsai['status_id']='Hết hàng';
                        }else{
                            $bonsai['status_id']='Còn hàng';
                        }

                        if($bonsai['type_id']==1){
                            $bonsai['type_id']='Office Plan';
                        }elseif($bonsai['type_id']==2){
                            $bonsai['type_id']='Gift Plant';
                        }elseif($bonsai['type_id']==3){
                         $bonsai['type_id']='Bonsai';
                        } else{
                            $bonsai['type_id']='Home Plant';
                        }
                        ?>

                        <div class="tile">
                            <h3 class="tile-title">Chi tiết <?php echo $bonsai['bonsai_name']?></h3>

                            <div class="tile-body">
                                <form class="row" action="./controller.php" method="POST" enctype="multipart/form-data">

                                <div class="form-group col-md-6">
                                    <label class="control-label">Tên cây</label>
                                    <input class="form-control" type="text" name="bonsai_name" id="bonsai_name" required value="<?php echo $bonsai['bonsai_name']?>" disabled>
                                </div>


                                <div class="form-group  col-md-6">
                                    <label class="control-label">Số lượng trong kho</label>
                                    <input class="form-control" type="text" name="amount" id="amount"  required value="<?php echo $bonsai['amount']?>" disabled>
                                </div>



                                <div class="form-group col-md-6 ">
                                    <label  class="control-label">Tình trạng</label>
                                    <input class="form-control" type="text" name="status_id" id="status_id" required value="<?php echo $bonsai['status_id']?>" disabled>

                                </div>

                                <div class="form-group col-md-6">
                                    <label  class="control-label">Loại cây</label>
                                    <input class="form-control" type="text" name="type" id="type" required value="<?php echo $bonsai['type_id']?>" disabled>

                                </div>

                                <div class="form-group col-md-6">
                                    <label class="control-label">Giá bán</label>
                                    <input class="form-control" type="text" name="price" id="price" required value="<?php echo  $bonsai['price'] ?> VND" disabled>
                                </div>
                                <div class="form-group col-md-6">
                                </div>

                                <div class="form-group col-md-12">
                                    <label class="control-label">Ảnh sản phẩm</label>

                                </div>

                                <div class="form-group col-md-12">
                                    <img width="500px;" src="<?php echo  $bonsai['bonsai_img'] ?>"?
                                </div>



                                <div class="form-group col-md-12">
                                    <br>
                                    <label class="control-label">Mô tả sản phẩm</label>
                                    <textarea class="form-control" name="describe_bonsai" id="describe_bonsai" disabled><?php echo  $bonsai['describe_bonsai'];?></textarea>
                                    <script>CKEDITOR.replace('describe_bonsai');</script>
                                </div>

                                <div>
                                    <button class="btn btn-save" type="submit" name="" id="">Thêm vào giỏ hàng</button>
                                    <a class="btn btn-cancel" href="./index.php">Trở về</a>
                                </div>

                                </form>

                            </div>

                        </div>
                        <?php
                    }
                }


            }

            ?>



</main>




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