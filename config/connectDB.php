<?php

$hostname= "localhost";
$user = "root";
$password = "";
$db_name = "bonsai";


$conn = mysqli_connect($hostname, $user, $password, $db_name);

if (!$conn) {
    echo "Connection failed!";
}
mysqli_select_db($conn,$db_name);

?>