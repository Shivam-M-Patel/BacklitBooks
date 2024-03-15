<?php 
    session_start();
    include 'DBconnection.php';
    // delete from orders table first
    $pdo = connectDB();
    $sql = "DELETE FROM orders WHERE UserID = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['uID']]);
    // delete from users table
    $sql = "DELETE FROM users WHERE UserID = ?;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$_SESSION['uID']]);
    $_SESSION['location'] = "DeletedAcc";
    header("location:Summary.php");
?>