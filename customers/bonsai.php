<?php
session_start();
require '../config/connectDB.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ</title>

    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">

    <script src="../js/index.js"></script>


</head>
<body>

<!-- header section starts  -->

<header>

    <div class="header-2">

        <a href="#" class="logo"> <i class="fas fa-seedling"></i> TDTU </a>

        <form action="" class="search-bar-container">
            <input type="search" id="search-bar" placeholder="search here...">
            <label for="search-bar" class="fas fa-search"></label>
        </form>

    </div>

    <div class="header-3">

        <div id="menu-bar" class="fas fa-bars"></div>

        <nav class="navbar">
            <a href="index.php">home</a>
            <a href="#category">Thể loại</a>
            <a href="#product">Sản phẩm</a>
            <a href="#deal">deal</a>
            <a href="#contact">Liên hệ</a>
        </nav>

        <div class="icons">
            <a href="cart.php" class="fas fa-shopping-cart" id="name"></a>
            <?php
            if(isset($_POST['name'])){
                $_SESSION['name']='okkk0';
                var_dump($_SESSION['name']);
            }
            ?>
            <a href="../login.php" class="fas fa-user-circle"></a>
            <a>Hello <?php echo $_SESSION['username'];?></a>
        </div>

    </div>

</header>

<!-- header section ends -->

<!-- home section starts  -->

<section class="home" id="home">

    <div class="swiper-container home-slider">

        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <div class="box" style="background: url(../uploads/slider1.jpg);">
                    <div class="content">
                        <span>Giảm 25%</span>
                        <h3>Cây cối tạo ra niềm vui cho mọi người</h3>
                        <a href="#" class="btn">Mua ngay</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="box" style="background: url(../uploads/slider2.jpg);">
                    <div class="content">
                        <span>Giảm 30%</span>
                        <h3>Trang trí ngôi nhà của bạn</h3>
                        <a href="#" class="btn">Mua ngay</a>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="box" style="background: url(../uploads/slider3.jpg);">
                    <div class="content">
                        <span>Giảm 35%</span>
                        <h3>Cải thiện không gian sống</h3>
                        <a href="#" class="btn">Mua ngay</a>
                    </div>
                </div>
            </div>



            <div class="swiper-pagination"></div>
        </div>


    </div>


</section>

<!-- home section ends -->

<!-- banner section starts  -->

<section class="banner-container">

    <div class="banner">
        <img src="../uploads/banner1.jpg" alt="">
        <div class="content">
            <span>Cây xanh</span>
            <h3>Cho ngôi nhà của bạn</h3>
            <a href="#" class="btn">Mua ngay</a>
        </div>
    </div>
    <div class="banner">
        <img src="../uploads/banner2.jpg" alt="">
        <div class="content">
            <span>Cây xanh</span>
            <h3>Cho văn phòng của bạn</h3>
            <a href="#" class="btn">Mua ngay</a>
        </div>
    </div>

</section>

<!-- banner section ends -->




<!-- product section starts  -->

<section class="product" id="product">

    <h1 class="heading">Bonsai Nghệ Thuật</h1>

    <div class="box-container">

        <?php
        $query ="select * from bonsai where type_id=3";
        $query_run = mysqli_query($conn,$query);

        if(mysqli_num_rows($query_run) > 0){
            foreach($query_run as $bonsai){
                ?>
                <div class="box">

                    <div class="icons">
                        <a href="#" class="fas fa-heart"></a>
                        <a href="#" class="fas fa-share"></a>
                        <a href="info.php?id=<?php echo $bonsai['bonsai_id'] ?>" class="fas fa-eye"></a>
                    </div>
                    <img src="<?= $bonsai['bonsai_img'] ?>">
                    <h3><?=  $bonsai['bonsai_name']?></h3>
                    <div class="stars">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="far fa-star"></i>
                    </div>
                    <div class="quantity">
                        <span> Số lượng: <?=$bonsai['amount'];?> </span>
                    </div>
                    <div class="price"><?= $bonsai['price'];?> VND <span> $150</span></div>
                    <form action="cart.php" method="POST">
                        <a href="cart.php?pid=<?= $bonsai['bonsai_id'] ?>" class="btn">Thêm vào giỏ</a>
                    </form>
                    <form action="info.php" method="POST">
                        <a href="info.php?id=<?= $bonsai['bonsai_id'] ?>" class="btn btn-warning info" id="info">Xem chi tiết sản phẩm này</a>
                    </form>
                </div>
                <?php



            }
        }

        ?>



    </div>

</section>

<!-- product section ends -->

<!-- .icons section starts  -->

<section class="icons-container">

    <div class="icon">
        <img src="../uploads/icon1.png" alt="">
        <div class="content">
            <h3>free shipping</h3>
            <p>Free shipping on order</p>
        </div>
    </div>
    <div class="icon">
        <img src="../uploads/icon2.png" alt="">
        <div class="content">
            <h3>100% Hoàn Tiền</h3>
            <p>Hoàn </p>
        </div>
    </div>
    <div class="icon">
        <img src="../uploads/icon3.png" alt="">
        <div class="content">
            <h3>Bảo mật thanh toán</h3>
            <p>100% bảo mật</p>
        </div>
    </div>
    <div class="icon">
        <img src="../uploads/icon4.png" alt="">
        <div class="content">
            <h3>Hỗ trợ 24/7</h3>
            <p>Liên hệ mọi lúc</p>
        </div>
    </div>

</section>

<!-- .icons section ends -->

<!-- deal section starts  -->

<section class="deal" id="deal">

    <h1 class="heading"> deal trong ngày </h1>

    <div class="row">

        <div class="content">
            <h3 class="title">đừng quên deal của bạn</h3>
            <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Recusandae rem eligendi repudiandae pariatur. Aut, esse molestias laborum sunt reprehenderit repellat officiis aspernatur consequatur nemo! Veritatis, ex architecto! Eligendi, iste nulla.</p>
            <a href="#" class="btn">check out deal</a>
        </div>

        <div class="image">
            <img src="../uploads/deal-img.jpg" alt="">
        </div>

    </div>

</section>

<!-- deal section ends -->

<div class="header-1">

    <div class="share">
        <span> follow us : </span>
        <a href="#" class="fab fa-facebook-f"></a>
        <a href="#" class="fab fa-twitter"></a>
        <a href="#" class="fab fa-instagram"></a>
        <a href="#" class="fab fa-linkedin"></a>
    </div>

    <div class="call">
        <span> call us : </span>
        <a href="#">+123-456-7890</a>
    </div>

</div>

<!-- footer section starts  -->
<section class="footer">

    <div class="box-container">

        <div class="box">
            <h3>about us</h3>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Quo hic eum veniam aut nisi. Libero autem nemo amet recusandae eveniet?</p>
        </div>
        <div class="box">
            <h3>Locations</h3>
            <a href="#">Miền Bắc</a>
            <a href="#">Miền Trung</a>
            <a href="#">Miền Nam</a>
            <a href="#">Khác</a>
        </div>
        <div class="box">
            <h3>quick links</h3>
            <a href="#">Home</a>
            <a href="#">Thể Loại</a>
            <a href="#">Sản phẩm</a>
            <a href="#">deal</a>
            <a href="#">Liên hệ</a>
        </div>
        <div class="box">
            <h3>follow us</h3>
            <a href="#">facebook</a>
            <a href="#">twitter</a>
            <a href="#">instagram</a>
            <a href="#">linked</a>
        </div>

    </div>

    <h1 class="credit"> created by <span> 52000868 </span> </h1>

</section>

<!-- footer section ends -->

<!-- scroll top button  -->
<a href="#home" class="scroll-top fas fa-angle-up"></a>



<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!-- custom js file link  -->
<script src="./js/index.js"></script>

</body>
</html>