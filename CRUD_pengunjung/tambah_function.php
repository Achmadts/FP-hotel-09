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

if (isset($_POST["submit"])) {
  $nama_pengunjung = $_POST['nama_pengunjung'];
  $email_pengunjung = $_POST['email_pengunjung'];
  $alamat_pengunjung = $_POST['alamat_pengunjung'];
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
    $fasilitas_tambahan .= 'Bantal ';
  }
  if (isset($_POST['fasilitasAcara'])) {
    $fasilitas_tambahan .= 'Acara Spesial ';
  }

  $metode_pembayaran = $_POST['metode_pembayaran'];
  $nomor_kartu_kredit = htmlspecialchars(mysqli_real_escape_string($con, $_POST['nomor_kartu']));
  $tgl_expired = date('Y-m-d', strtotime($_POST['expiry']));
  $pesan = htmlspecialchars(mysqli_real_escape_string($con, $_POST['pesan']));

  if ($metode_pembayaran != "Kartu Kredit") {
    $nomor_kartu_kredit = '';
    $tgl_expired = '';
  }

  $query = "INSERT INTO pengunjung(name, email, alamat, tgl_lahir, no_telpon, jkel, region, tgl_check_in, tgl_check_out, jenis_kamar, jumlah_tamu, kategori, fasilitas_tambahan, metode_pembayaran, nomor_kartu_kredit, tgl_expired, pesan) VALUES ('$nama_pengunjung', '$email_pengunjung', '$alamat_pengunjung', '$tanggal_lahir_pengunjung', '$no_telpon_pengunjung', '$jkel_pengunjung', '$region_pengunjung', '$tgl_check_in', '$tgl_check_out', '$jenis_kamar', '$jumlah_tamu', '$kategori', '$fasilitas_tambahan', '$metode_pembayaran', '$nomor_kartu_kredit', '$tgl_expired', '$pesan')";
  $result = mysqli_query($con, $query);

  if ($result) {
    echo '<script>
    Swal.fire({
        icon: "success",
        title: "Data berhasil ditambahkan",
        showConfirmButton: false,
        timer: 1500
    }).then(function() {
        window.location.href = "../list.php";
    });
    </script>';
  } else {
    echo '<script>alert("Data gagal ditambahkan!"); window.location.href = "input.php";</script>';
  }
}
