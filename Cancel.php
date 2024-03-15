<?php 
    session_start();
    unset($_SESSION['cart']);
    unset($_SESSION['incart']);
    header("Location:Store.php");
?>