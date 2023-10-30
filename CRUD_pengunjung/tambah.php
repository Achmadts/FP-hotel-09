<?php
session_start();
require_once '../connection/conn.php';
require_once 'tambah_function.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="../css/input.css">
  <title>Pendaftaran Hotel</title>

  <style>
    form {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      background-color: wheat;
      border-radius: 5px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    a {
      text-decoration: none;
      color: #000000;
    }

    a:hover {
      color: #000000;
    }
  </style>

</head>

<body>
  <h1 style="padding: 20px; text-align: center; color: #000000;">Tambah Data Pengunjung</h1>
  <form action="" method="POST" id="id-form" onsubmit="return toggleNomorKartu();">
    <ul>
      <li>
        <h2>Informasi Pribadi</h2><br>
        <div class="form-floating">
          <input type="text" class="form-control" id="nama" name="nama_pengunjung" required placeholder="Masukkan nama anda" autocomplete="off">
          <label for="nama">Nama</label><br>
        </div>

        <div class="form-floating">
          <input type="email" class="form-control" id="email" name="email_pengunjung" required placeholder="Masukkan email anda" autocomplete="off">
          <label for="email">Email</label><br>
        </div>

        <div class="form-floating">
          <input type="text" class="form-control" id="Alamat" name="alamat_pengunjung" required placeholder="Masukkan alamat anda" autocomplete="off">
          <label for="Alamat">Alamat</label><br>
        </div>

        <div class="form-floating">
          <input type="date" class="form-control" id="TanggalLahir" name="tgllahir" required>
          <label for="Tanggal Lahir">Tanggal Lahir</label><br>
        </div>

        <div class="form-floating">
          <input type="number" class="form-control" id="notlp" name="notlp" required placeholder="Masukkan no telpon anda" autocomplete="off">
          <label for="NoTelepon">No Telepon</label>
        </div>
      </li>

      <label for="jkel" style="font-size: 20px; margin-bottom: 10px; margin-top: 5px">Jenis Kelamin:</label><br>

      <input type="radio" class="btn-check" id="laki" name="jenis_kelamin" value="Laki-laki" required>
      <label for="laki" class="btn btn-outline-primary">Laki-laki</label>

      <input type="radio" class="btn-check" id="perempuan" name="jenis_kelamin" value="Perempuan">
      <label for="perempuan" class="btn btn-outline-primary">Perempuan</label><br><br>


      <label for="tamu" class="mb-2" style="font-size: 20px;">Kewarganegaraan:</label><br>
      <div class="btn-group" role="group" aria-label="Basic radio toggle button group">

        <input type="radio" class="btn-check" id="btnradio3" name="kwg" value="Warga Lokal">
        <label for="btnradio3" class="btn btn-outline-primary">Warga Lokal</label>

        <input type="radio" class="btn-check" id="btnradio4" name="kwg" value="Warga Asing">
        <label for="btnradio4" class="btn btn-outline-primary">Warga Asing</label>
      </div><br><br><br>

      <li>
        <h4>Tanggal Check-in dan Check-out</h4><br>

        <div class="form-floating">
          <input type="date" class="form-control" id="checkin" name="checkin" required>
          <label for="checkinlbl">Tanggal Check-in:</label><br>
        </div>

        <div class="form-floating">
          <input type="date" class="form-control" id="checkout" name="checkout" required>
          <label for="checkoutlbl">Tanggal Check-out:</label><br>
        </div>
      </li>

      <li>
        <h4>Pilihan Kamar % Fasilitas Tambahan</h4><br>

        <div class="form-floating">
          <select class="form-select" id="kamar" name="kamar">
            <option value="single">Single</option>
            <option value="double">Double</option>
            <option value="suite">Suite</option>
          </select>
          <label for="kamarlbl">Jenis Kamar</label><br>
        </div>

        <div class="form-floating">
          <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu" min="1" required>
          <label for="jumlah_tamulbl">Jumlah Tamu</label>
        </div>
      </li>


      <div class="form-floating">
        <select class="form-select" id="kategori" name="kategori">
          <option value="vvip">VVIP</option>
          <option value="vip">VIP</option>
          <option value="biasa">Biasa</option>
        </select>
        <label for="kategorilbl">Kategori</label><br>
      </div>

      <label for="jenis_kelamin" class="mb-2" style="font-size: 20px;">Fasilitas` Tambahan:</label><br>
      <input class="btn-check" id="btn-check1" type="checkbox" name="fasilitasBantal">
      <label for="btn-check1" class="btn btn-outline-primary">Bantal</label>

      <input class="btn-check" id="btn-check2" type="checkbox" name="fasilitasAcara">
      <label for="btn-check2" class="btn btn-outline-primary">Acara Spesial</label><br><br><br>

      <li>
        <h4>Pembayaran</h4><br>
        <div class="form-floating">
          <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" onchange="toggleNomorKartu()">
            <option value="Kartu Kredit">Kartu Kredit</option>
            <option value="Tunai">Tunai</option>
            <option value="Transfer Bank">Transfer Bank</option>
          </select>
          <label for="metode_pembayaranlbl">Metode Pembayaran</label>
        </div>
      </li>

      <div class="form-floating" id="nomor_kartu_div">
        <input type="number" class="form-control" id="nomor_kartu" name="nomor_kartu" placeholder="Masukkan no kartu kredit">
        <label for="nomor_kartulbl">Nomor Kartu Kredit</label><br>
      </div>

      <div class="form-floating" id="tgl_expired_div">
        <input type="date" class="form-control" id="expiry" name="expiry" placeholder="MM/YY">
        <label for="expiry">Tanggal Kadaluarsa</label><br>
      </div>

      <div id="error_message" style="color: red;"></div>
      <li>

        <div class="form-floating">
          <textarea id="pesan" class="form-control pb-5" name="pesan" rows="4" cols="50"></textarea>
          <label for="pesan">Pesan Tambahan</label>
        </div>

        <br>
        <div class="button-container">
          <input type="submit" name="submit" class="btn btn-primary" value="Kirim" onclick="return toggleNomorKartu();">
          <a href="../list.php">
            <button type="button" class="btn btn-primary">Batal</button>
          </a>
          <button class="btn btn-primary" style="margin-left: -10px;" type="button" onclick="ulang()">Ulang</button>
        </div>
      </li>
    </ul>
  </form><br><br><br>
  <script src="js/ulang.js"></script>
  <script src="js/script.js"></script>
</body>
</html>