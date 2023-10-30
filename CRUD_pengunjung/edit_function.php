<?php
require_once '../connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"])) {
    header("Location: ../login.php");
    exit;
};

$id = $_GET['editid'];
$query = "SELECT * FROM pengunjung WHERE id=?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$result) {
    die('Error: ' . mysqli_error($con));
}

// Data dari database
$nama_pengunjung = $row["name"];
$email_pengunjung = $row["email"];
$alamat_pengunjung = $row["alamat"];
$tanggal_lahir_pengunjung = $row["tgl_lahir"];
$no_telpon_pengunjung = $row["no_telpon"];
$jkel_pengunjung = $row["jkel"];
$region_pengunjung = $row["region"];
$tgl_check_in = $row["tgl_check_in"];
$tgl_check_out = $row["tgl_check_out"];
$jenis_kamar = $row["jenis_kamar"];
$jumlah_tamu = $row["jumlah_tamu"];
$kategori = $row["kategori"];
$fasilitas_tambahan = $row["fasilitas_tambahan"];
$metode_pembayaran = $row["metode_pembayaran"];
$nomor_kartu_kredit = $row["nomor_kartu_kredit"];
$tgl_expired = $row["tgl_expired"];
$pesan = $row["pesan"];
// akhir data dari database

if (isset($_POST["submit"])) {
    $nama_pengunjung = htmlspecialchars($_POST["nama_pengunjung"]);
    $email_pengunjung = htmlspecialchars($_POST["email_pengunjung"]);
    $alamat_pengunjung = htmlspecialchars($_POST['alamat_pengunjung']);
    $tanggal_lahir_pengunjung = date('Y-m-d', strtotime($_POST['tgllahir']));
    $no_telpon_pengunjung = $_POST['notlp'];
    $jkel_pengunjung = $_POST['jenis_kelamin'];
    $region_pengunjung = $_POST['kwg'];
    $tgl_check_in = date('Y-m-d', strtotime($_POST['checkin']));
    $tgl_check_out = date('Y-m-d', strtotime($_POST['checkout']));
    $jenis_kamar = $_POST['kamar'];
    $jumlah_tamu = $_POST['jumlah_tamu'];
    $kategori = $_POST['kategori'];
    $fasilitas_tambahan = '';
    if (isset($_POST['fasilitasBantal'])) {
        $fasilitas_tambahan .= 'Bantal, ';
    }
    if (isset($_POST['fasilitasAcara'])) {
        $fasilitas_tambahan .= 'Acara Spesial, ';
    }
    $fasilitas_tambahan = rtrim($fasilitas_tambahan, ', ');
    $metode_pembayaran = $_POST["metode_pembayaran"];
    $nomor_kartu_kredit = $_POST["nomor_kartu"];
    $tgl_expired = $_POST["expiry"];
    $pesan = $_POST["pesan"];

    if ($metode_pembayaran != "Kartu Kredit") {
        $nomor_kartu_kredit = '';
        $tgl_expired = '';
    }

    $update_query = "UPDATE pengunjung SET name=?, email=?, alamat=?, tgl_lahir=?, no_telpon=?, jkel=?, region=?, tgl_check_in=?, tgl_check_out=?, jenis_kamar=?, jumlah_tamu=?, kategori=?, fasilitas_tambahan=?, metode_pembayaran=?, nomor_kartu_kredit=?, tgl_expired=?, pesan=? WHERE id=?";
    $update_stmt = mysqli_prepare($con, $update_query);
    mysqli_stmt_bind_param($update_stmt, "sssssssssssssssssi", $nama_pengunjung, $email_pengunjung, $alamat_pengunjung, $tanggal_lahir_pengunjung, $no_telpon_pengunjung, $jkel_pengunjung, $region_pengunjung, $tgl_check_in, $tgl_check_out, $jenis_kamar, $jumlah_tamu, $kategori, $fasilitas_tambahan, $metode_pembayaran, $nomor_kartu_kredit, $tgl_expired, $pesan, $id);
    mysqli_stmt_execute($update_stmt);

    if (mysqli_stmt_affected_rows($update_stmt) < 0) {
        echo "Terjadi kesalahan dalam perbaruan data: " . mysqli_error($con);
    } else {
        echo '<script>alert("Data berhasil diperbarui"); window.location.href = "../list.php";</script>';
    }
}
