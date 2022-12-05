<?php
session_start();
include '../config/connectDB.php';


/*-----------------------------Thao tác với các tài khoản*-----------------------------*/


// <--Xóa một tài khoản-->
if(isset($_POST['deletedata']))
{
    $id = $_POST['delete_id'];
    $id_cus = $id - 1;



    $query = "DELETE FROM customers WHERE customer_id='$id_cus'";
    $query_run = mysqli_query($conn, $query);

    $query_1 = "DELETE FROM accounts WHERE account_id='$id'";
    $query_run_1 = mysqli_query($conn, $query_1);

    if($query_run && $query_run_1)
    {

        echo '<script> alert("Data Deleted"); </script>';
        header("Location:   accounts.php");
        $_SESSION['response']="Xóa thành công!";

    }
    else
    {
        echo '<script> alert("Data Not Deleted"); </script>';
    }
}


// <--Thêm một tài khoản mới-->
if(isset($_POST['add_account']))
{
    $name = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password= mysqli_real_escape_string($conn, $_POST['password']);
    //    $pwd = password_hash($password,PASSWORD_DEFAULT);

    $check = "select * from accounts where email='$email' ";
    $check_run = mysqli_fetch_array(mysqli_query($conn,$check));



    if($check_run!=null && $check_run['email']==$email){
        $_SESSION['response']="Không thành công - Đã tồn tại email!";
        $_SESSION['res_type']="danger";

        $res = [
            'status' => 500];
        return;
    }

    if($name == NULL || $email == NULL || $password == NULL)
    {
        $res = [
            'status' => 422,
        ];
        $_SESSION['response']="Không thành công - Vui lòng điền đủ thông tin!";
        $_SESSION['res_type']="danger";
        return;
    }

    $insert_acc = "INSERT INTO accounts(email,username,pwd,account_role) VALUES ('$email','$name','$password',0)";
    $insert_acc_run = mysqli_query($conn, $insert_acc);


    $take_id = "select account_id from accounts where email='$email'";
    $acc_id =  mysqli_fetch_array(mysqli_query($conn, $take_id));
    $insert_cus = "INSERT INTO customers(account_id,email) VALUES ('$acc_id[0]','$email')";
    $insert_cus_run = mysqli_query($conn, $insert_cus);

    if($insert_acc_run==true)
    {

        $res = [
            'status' => 200,
        ];
        $_SESSION['response']="Thêm tài khoản thành công!";
        $_SESSION['res_type']="success";
        return;


    }
    else
    {
        $res = [
            'status' => 500];
        return;
    }
}


// <--Chỉnh sửa tài khoản-->
if(isset($_POST['edit_Account'])){
    $id = $_POST['account_id'];
    $username=$_POST['username'];
    $pwd=$_POST['password'];
    $account_role=$_POST['account_role'];



    if($account_role=='Khách Hàng'){
        $account_role=0;
    }else{
        $account_role=1;
    }

    if($username == NULL || $pwd == NULL)
    {
        $res = [
            'status' => 422,
        ];
        $_SESSION['response']="Vui lòng điền đủ thông tin!";
        $_SESSION['res_type']="danger";
        return;
    }

    if(strlen($pwd)<6){
        $res = [
            'status' => 422,
        ];

        $_SESSION['response']="Mật khẩu quá ngắn!";
        $_SESSION['res_type']="danger";

        return;
    }



    $query_1 = "update accounts 
                set account_role='$account_role',
                    username='$username',pwd='$pwd'
                WHERE account_id='$id'";
    $query_run_1 = mysqli_query($conn, $query_1);

    if($query_run_1)
    {
        echo '<script> alert("Data update"); </script>';
        $_SESSION['response']="Chỉnh sửa tài khoản thành công!";
        $_SESSION['res_type']="success";

        header("Location:   accounts.php");

    }
}



/*-----------------------------Thao tác với thông tin người dùng -----------------------------*/



//Cập nhật thông tin người dùng
if(isset($_POST['updateCustomer']))
{
    $id = $_POST['customer_id'];
    $name = $_POST['fullname'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $address = $_POST['address'];
    $identity =$_POST['identity_id'];
    $birthday = $_POST['birth'];



    if($name == NULL || $phone == NULL || $address == NULL ||  $identity ==NULL || $birthday ==NULL)
    {
        header('Location: ./customers.php');

        $_SESSION['response']="Không thành công - Vui lòng điền đủ thông tin!";
        $_SESSION['res_type']="danger";
    }
    if(strlen($phone)<10){
        header('Location: ./customers.php');

        $_SESSION['response']="Không thành công - Số điện thoại không đúng!";
        $_SESSION['res_type']="danger";
    }






    $query = "UPDATE customers 
                SET  fullname='$name', sex='$sex', phone='$phone', address='$address', 
                    phone='$phone',identity_id ='$identity',birthday='$birthday'
                    WHERE customer_id='$id'  ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        echo '<script> alert("Data Updated"); </script>';
        header("Location: ./customers.php");
        $_SESSION['response']="Thành công!";
        $_SESSION['res_type']="success";
    }
    else
    {
        echo '<script> alert("Data Not Updated"); </script>';
    }
}



// Xóa thông tin người dùng
if(isset($_GET['deleteCustomer'])){
    $id=$_GET['deleteCustomer'];

    $sql="SELECT * FROM customers WHERE customer_id=?";
    $stmt2=$conn->prepare($sql);
    $stmt2->bind_param("i",$id);
    $stmt2->execute();
    $result2=$stmt2->get_result();
    $row=$result2->fetch_assoc();



    $query="DELETE FROM customers WHERE customer_id=?";
    $stmt=$conn->prepare($query);
    $stmt->bind_param("i",$id);
    $stmt->execute();
    header('Location: ./customers.php');

    $_SESSION['response']="Xóa thành công!";
    $_SESSION['res_type']="danger";
}



/*-----------------------------Thao tác với các sản phẩm -----------------------------*/


//Thêm sản phẩm
if(isset($_POST['addProduct'])) {
    $proName = mysqli_real_escape_string($conn, $_POST['bonsai_name']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $bonsai_type = mysqli_real_escape_string($conn, $_POST['bonsai_type']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $amount = mysqli_real_escape_string($conn, $_POST['amount']);

    $describe_bonsai = mysqli_real_escape_string($conn, $_POST['describe_bonsai']);


    if($bonsai_type ==1){
        $url ="../uploads/OfficePlant/";
    }elseif ($bonsai_type ==2){
        $url ="../uploads/GiftPlant/";
    }elseif ($bonsai_type ==3){
        $url ="../uploads/Bonsai/";
    }else{
        $url ="../uploads/HomePlant/";
    }

    $filename = $_FILES["uploadfile"]["name"];
    $temp = $_FILES["uploadfile"]["tmp_name"];
    $folder = $url . $filename;


    if($proName ==NULL || $amount ==NULL || $status ==NULL ||  $bonsai_type ==NULL || $price==NULL){
        $_SESSION['response']="Không thành công - Vui lòng nhập đủ thông tin!";
        $_SESSION['res_type']="danger";
        header("Location: product.php");
        return;

    }

    var_dump($amount,$price);


    $sql = "insert into bonsai(bonsai_name,bonsai_img,type_id,describe_bonsai,amount,price,status_id) values
            ('$proName','$folder','$bonsai_type','$describe_bonsai',
                    '$amount','$price','$status')";
    $sql_run = mysqli_query($conn,$sql);



    if(move_uploaded_file($temp,$folder)){
        echo "<h3>  Image uploaded successfully!</h3>";
    }

    if($sql_run){
        $_SESSION['response']="Thêm sản phẩm thành công!";
        $_SESSION['res_type']="success";
        header("Location: product.php");
    }




}


// sửa sản phẩm

if(isset($_POST['edit_Product'])){

    $product_id=$_POST['bonsai_id'];
    $name=$_POST['name'];
    $describe_bonsai=$_POST['describe_bonsai'];
    $bonsai_type=$_POST['bonsai_type'];
    $amount=$_POST['amount_pr'];
    $price=$_POST['price'];
    $status=$_POST['status'];

    var_dump($product_id,$name,$bonsai_type,$amount,$status,$price,$describe_bonsai);

    if($name==NULL ||$amount==NULL ||$price==NULL || $describe_bonsai==NULL){
        $_SESSION['response']="Không thành công - vui lòng điền đầy đủ thông tin!";
        $_SESSION['res_type']="danger";
        header("Location: product.php");
        return;


    }else{
        $sql="update bonsai set bonsai_name='$name', type_id='$bonsai_type',amount='$amount',
            price='$price',describe_bonsai='$describe_bonsai', status_id='$status'
                    where bonsai_id='$product_id'";
        $sql_run = mysqli_query($conn,$sql);

        if($sql_run){
            $_SESSION['response']="Chỉnh sửa sản phẩm thành công!";
            $_SESSION['res_type']="success";
            header("Location: product.php");
        }
    }





}

// Xóa sản phẩm
if(isset($_POST['delete_Product'])){
    $product_id = $_POST['pro_id'];
    var_dump($product_id);
    $sql ="delete from bonsai where bonsai_id='$product_id'";
    $sql_run =mysqli_query($conn,$sql);

    if($sql_run){
        $_SESSION['response']="Xóa sản phẩm thành công!";
        $_SESSION['res_type']="success";
        header("Location: product.php");
    }


}

?>
