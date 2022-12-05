

<?php
session_start();
include '../config/connectDB.php';

// xóa sản phẩm khoỏi giỏ hàng

if(isset($_POST['deleteProduct'])){
    $cart_id = $_POST['delete_id'];
    var_dump($cart_id);

    try {
        $sql="delete from cart where  cart_id='$cart_id'";
        $sql_run=mysqli_query($conn,$sql);
        if($sql_run){
            $_SESSION['response']="Xóa sản phẩm thành công!";
            $_SESSION['res_type']="success";
            header("Location: cart.php");
        }
    }catch (Exception $e){
        var_dump($e->getMessage());
        $_SESSION['response']="Bạn đang có hóa đơn với sản phẩm này - Hãy xóa hóa đơn đó để xóa sản phẩm!";
        $_SESSION['res_type']="danger";
        header("Location: cart.php");
    }




}

?>
