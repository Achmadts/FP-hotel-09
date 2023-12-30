<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
<?php
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

$id = $_GET['editid'];

$query = "SELECT p.*, t.waktu_chekin AS waktu_checkin, t.waktu_chekout AS waktu_checkout, t.total_harga, tk.type_kamar AS nama_type_kamar, tk.harga_kamar
          FROM pengunjung p LEFT JOIN transaksi t ON p.id_pengunjung = t.id_pengunjung 
          LEFT JOIN type_kamar tk ON t.type_kamar = tk.type_kamar
          WHERE p.id_pengunjung = ?";

$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$result) {
    die('Error: ' . mysqli_error($con));
}

// Data dari database
$nama_pengunjung = $row["nama_pengunjung"];
$email_pengunjung = $row["email_pengunjung"];
$alamat_pengunjung = $row["alamat_pengunjung"];
$no_telpon_pengunjung = $row["no_hp_pengunjung"];
$tgl_check_in = $row["waktu_checkin"];
$tgl_check_out = $row["waktu_checkout"];
$jenis_kamar = $row["nama_type_kamar"];
$total_harga = $row["total_harga"];

$tgl_check_in = substr($tgl_check_in, 0, 10);
$tgl_check_out = substr($tgl_check_out, 0, 10);
// akhir data dari database

if (isset($_POST["submit"])) {
    $nama_pengunjung = htmlspecialchars($_POST["nama_pengunjung"]);
    $email_pengunjung = htmlspecialchars($_POST["email_pengunjung"]);
    $alamat_pengunjung = htmlspecialchars($_POST['alamat_pengunjung']);
    $no_telpon_pengunjung = $_POST['no_hp_pengunjung'];
    $tgl_check_in = date('Y-m-d', strtotime($_POST['checkin']));
    $tgl_check_out = date('Y-m-d', strtotime($_POST['checkout']));
    $jenis_kamar = $_POST['type_kamar'];

    $datetime1 = new DateTime($tgl_check_in);
    $datetime2 = new DateTime($tgl_check_out);
    $interval = $datetime1->diff($datetime2);
    $selisih_hari = $interval->days;

    $harga_per_hari_query = "SELECT harga_kamar FROM type_kamar WHERE type_kamar = ?";
    $stmt = mysqli_prepare($con, $harga_per_hari_query);
    mysqli_stmt_bind_param($stmt, "s", $jenis_kamar);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);
    $harga_per_hari = $row['harga_kamar'];
    $total_harga = $selisih_hari * $harga_per_hari;

    $update_pengunjung_query = "UPDATE pengunjung SET nama_pengunjung=?, email_pengunjung=?, alamat_pengunjung=?, no_hp_pengunjung=? WHERE id_pengunjung=?";
    $update_pengunjung_stmt = mysqli_prepare($con, $update_pengunjung_query);
    mysqli_stmt_bind_param($update_pengunjung_stmt, "ssssi", $nama_pengunjung, $email_pengunjung, $alamat_pengunjung, $no_telpon_pengunjung, $id);
    mysqli_stmt_execute($update_pengunjung_stmt);

    $update_transaksi_query = "UPDATE transaksi SET waktu_chekin=?, waktu_chekout=?, total_harga=? WHERE id_pengunjung=?";
    $update_transaksi_stmt = mysqli_prepare($con, $update_transaksi_query);
    mysqli_stmt_bind_param($update_transaksi_stmt, "ssdi", $tgl_check_in, $tgl_check_out, $total_harga, $id);
    mysqli_stmt_execute($update_transaksi_stmt);

    $update_type_kamar_query = "UPDATE transaksi SET type_kamar=? WHERE id_pengunjung=?";
    $update_type_kamar_stmt = mysqli_prepare($con, $update_type_kamar_query);
    mysqli_stmt_bind_param($update_type_kamar_stmt, "si", $jenis_kamar, $id);
    mysqli_stmt_execute($update_type_kamar_stmt);

    if (mysqli_stmt_affected_rows($update_pengunjung_stmt) < 0 || mysqli_stmt_affected_rows($update_transaksi_stmt) < 0 || mysqli_stmt_affected_rows($update_type_kamar_stmt) < 0) {
        echo "Data gagal diedit: " . mysqli_error($con);
    } else {
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Data berhasil diperbarui",
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = "../list.php";
        });
        </script>';
    }
}
?>