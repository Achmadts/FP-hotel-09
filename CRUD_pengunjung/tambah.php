<?php
session_start();
require_once '../connection/conn.php';
require_once 'tambah_function.php';
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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
  <title>Tambah data pengunjung</title>
  <link rel="stylesheet" href="../css/input.css">

  <style>
    form {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: wheat;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>

<body>
  <form action="" method="POST" id="id-form" onsubmit="return toggleNomorKartu();" class="mt-5 mb-5" style="width: 95%;">
    <h2 class="text-center">Tambah Data</h2><br>
    <div class="form-floating">
      <input type="text" class="form-control" id="nama" name="nama_pengunjung" required placeholder="Masukkan nama anda" autocomplete="off"><br>
      <label for="nama">Nama</label>
    </div>

    <div class="form-floating">
      <input type="email" class="form-control" id="email" name="email_pengunjung" required placeholder="Masukkan email anda" autocomplete="off"><br>
      <label for="email">Email</label>
    </div>

    <div class="form-floating">
      <input type="text" class="form-control" id="Alamat" name="alamat_pengunjung" required placeholder="Masukkan alamat anda" autocomplete="off"><br>
      <label for="Alamat">Alamat</label>
    </div>

    <div class="form-floating">
      <input type="date" class="form-control" id="TanggalLahir" name="tgllahir" required><br>
      <label for="Tanggal Lahir">Tanggal Lahir</label>
    </div>

    <div class="form-floating">
      <input type="number" class="form-control" id="notlp" name="notlp" required placeholder="Masukkan no telpon anda" autocomplete="off">
      <label for="NoTelepon">No Telepon</label>
    </div>


    <label for="jkel" style="font-size: 20px; margin-bottom: 10px; margin-top: 5px">Jenis Kelamin:</label>
    <div class="jenis_kelamin d-flex" style="width: 200px;">
      <input type="radio" class="btn-check" id="laki" name="jenis_kelamin" value="Laki-laki" required autocomplete="off">
      <label for="laki" class="btn btn-outline-primary me-1">Laki-laki</label>

      <input type="radio" class="btn-check" id="perempuan" name="jenis_kelamin" value="Perempuan">
      <label for="perempuan" class="btn btn-outline-primary">Perempuan</label><br><br>
    </div>

    <label for="tamu" class="mb-2" style="font-size: 20px;">Kewarganegaraan:</label><br>
    <div class="btn-group" role="group" aria-label="Basic radio toggle button group" style="width: 250px;">
      <input type="radio" class="btn-check" name="kwg" id="btnradio3" value="Warga Lokal" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio3">Warga Lokal</label>

      <input type="radio" class="btn-check" name="kwg" id="btnradio4" value="Warga Asing" autocomplete="off">
      <label class="btn btn-outline-primary" for="btnradio4">Warga Asing</label>
    </div><br><br>

    <div class="form-floating">
      <input type="date" class="form-control" id="checkin" name="checkin" required><br>
      <label for="checkinlbl">Tanggal Check-in</label>
    </div>

    <div class="form-floating">
      <input type="date" class="form-control" id="checkout" name="checkout" required>
      <label for="checkoutlbl">Tanggal Check-out</label><br>
    </div>

    <div class="form-floating">
      <select class="form-select" id="kamar" name="kamar">
        <option value="single">Single</option>
        <option value="double">Double</option>
        <option value="suite">Suite</option>
      </select>
      <label for="kamarlbl">Jenis Kamar</label><br>
    </div>

    <div class="form-floating mb-3">
      <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu" min="1" required placeholder="Masukkan Jumlah Tamu" autocomplete="off">
      <label for="NoTelepon">Jumlah Orang</label>
    </div>


    <div class="form-floating">
      <select class="form-select" id="kategori" name="kategori">
        <option value="vvip">VVIP</option>
        <option value="vip">VIP</option>
        <option value="biasa">Biasa</option>
      </select>
      <label for="kategorilbl">Kategori</label>
    </div><br>

    <label for="fasilitas_tambahan" class="mb-2" style="font-size: 20px;">Fasilitas Tambahan:</label><br>
    <div class="fasilitas_tambahan d-flex mb-4" style="width: 255px;">
      <input type="checkbox" class="btn-check" id="btn-check1" name="fasilitasBantal">
      <label class="btn btn-outline-primary me-1" for="btn-check1">Bantal</label>

      <input type="checkbox" class="btn-check" id="btn-check2" name="fasilitasAcara">
      <label class="btn btn-outline-primary" for="btn-check2">Acara Spesial</label><br><br>
    </div>

    <div class="form-floating">
      <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" onchange="toggleNomorKartu()">
        <option value="Kartu Kredit">Kartu Kredit</option>
        <option value="Tunai">Tunai</option>
        <option value="Transfer Bank">Transfer Bank</option>
      </select>
      <label for="metode_pembayaranlbl">Metode Pembayaran</label>
    </div>

    <div class="form-floating mt-4" id="nomor_kartu_div">
      <input type="text" class="form-control" id="nomor_kartu" name="nomor_kartu" placeholder="Masukkan no kartu kredit"><br>
      <label for="nomor_kartulbl">Nomor Kartu Kredit</label>
    </div>

    <div class="form-floating" id="tgl_expired_div">
      <input type="date" class="form-control" id="expiry" name="expiry" placeholder="MM/YY">
      <label for="expiry">Tanggal Kadaluarsa</label>
    </div>

    <div id="error_message" style="color: red;"></div>

    <div class="form-floating mt-4">
      <textarea id="pesan" class="form-control pb-5" name="pesan" rows="4" cols="50"></textarea>
      <label for="pesan">Pesan Tambahan</label>
    </div>
    <br>

    <div class="button-container d-flex" style="width: 200px;">
      <input type="submit" name="submit" class="btn btn-primary mx-1" value="Tambah" onclick="return toggleNomorKartu();">
      <a href="../list.php">
        <button type="button" class="btn btn-primary">Batal</button>
      </a>
      <button class="btn btn-primary mx-1" type="reset" style="margin-left: -10px;">Ulang</button>
    </div>
  </form>
  <script src="js/script.js"></script>
  <script src="js/ulang.js"></script>
</body>

</html>