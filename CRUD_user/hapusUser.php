<?php
session_start();
require_once '../connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"]) && !isset($_SESSION["login_type"]) || $_SESSION["login_type"] !== "admin_login") {
    header('Location: ../index.php');
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: ../email_verification.php");
    exit;
}

if (isset($_SESSION["TFA"]["code"])) {
    header("Location: ../TFA.php");
    exit;
}

if(isset($_GET['hapusid'])){
    $id = $_GET['hapusid'];

    $sql = "DELETE FROM `user` WHERE id=$id";
    $result = mysqli_query($con, $sql);
    if($result){
        echo '<script>alert("Data berhasil dihapus"); window.location.href = "../user_list.php";</script>';
        header('location: ../user_list.php');
    }else{
        die(mysqli_error($con));
    }
}

?>