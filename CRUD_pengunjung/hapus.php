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

if (isset($_GET['hapusid'])) {
    $id = $_GET['hapusid'];

    $delete_transaksi_sql = "DELETE FROM `transaksi` WHERE id_pengunjung=$id";
    $result_transaksi = mysqli_query($con, $delete_transaksi_sql);

    if (!$result_transaksi) {
        die(mysqli_error($con));
    }

    $delete_pengunjung_sql = "DELETE FROM `pengunjung` WHERE id_pengunjung=$id";
    $result_pengunjung = mysqli_query($con, $delete_pengunjung_sql);

    if ($result_pengunjung) {
        echo '<script>alert("Data berhasil dihapus"); window.location.href = "list.php";</script>';
        header('location: ../list.php');
    } else {
        die(mysqli_error($con));
    }
}
