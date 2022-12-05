<?php
    session_start();
    if(isset($_SESSION['username']) &&isset($_SESSION['username'])!=NULL){

        header("Location: login.php" );
        unset($_SESSION['username']);
    }
?>
