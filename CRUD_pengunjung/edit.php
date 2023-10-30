<?php
session_start();
require_once '../connection/conn.php';
require_once 'edit_function.php';
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
    <title>Edit data</title>

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
    <h1 style="padding: 20px; text-align: center; color: #000000;">Edit Information</h1>
    <form action="" method="POST" id="id-form" onsubmit="return toggleNomorKartu();">
        <ul>
            <li>
                <h2>Informasi Pribadi</h2><br>
                <div class="form-floating">
                    <input type="text" class="form-control" id="nama" name="nama_pengunjung" value="<?php echo $nama_pengunjung; ?>" required placeholder="Masukkan nama anda" autocomplete="off"><br>
                    <label for="nama">Nama</label>
                </div>

                <div class="form-floating">
                    <input type="email" class="form-control" id="email" name="email_pengunjung" value="<?php echo $email_pengunjung; ?>" required placeholder="Masukkan email anda" autocomplete="off"><br>
                    <label for="email">Email</label>
                </div>

                <div class="form-floating">
                    <input type="text" class="form-control" id="Alamat" name="alamat_pengunjung" value="<?php echo $alamat_pengunjung; ?>" required placeholder="Masukkan alamat anda" autocomplete="off"><br>
                    <label for="Alamat">Alamat:</label>
                </div>

                <div class="form-floating">
                    <input type="date" class="form-control" id="TanggalLahir" value="<?php echo $tanggal_lahir_pengunjung; ?>" name="tgllahir" required><br>
                    <label for="Tanggal Lahir">Tanggal Lahir</label>
                </div>

                <div class="form-floating">
                    <input type="number" class="form-control" id="notlp" name="notlp" value="<?php echo $no_telpon_pengunjung; ?>" required placeholder="Masukkan no telpon anda" autocomplete="off"><br>
                    <label for="NoTelepon">No Telepon</label>
                </div>

            </li>

            <label style="font-size: 20px; margin-bottom: 10px; margin-top: 5px">Jenis Kelamin:</label><br>
            <input type="radio" class="btn-check" id="laki" name="jenis_kelamin" value="Laki-laki" <?= ($jkel_pengunjung == "Laki-laki") ? "checked" : "" ?> required>
            <label for="laki" class="btn btn-outline-primary">Laki-laki</label>
            <input type="radio" class="btn-check" id="perempuan" name="jenis_kelamin" value="Perempuan" <?= ($jkel_pengunjung == "Perempuan") ? "checked" : "" ?>>
            <label for="perempuan" class="btn btn-outline-primary">Perempuan</label><br><br>


            <label for="tamu" class="mb-2" style="font-size: 20px;">Kewarganegaraan:</label><br>
            <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                <input type="radio" class="btn-check" id="btnradio3" name="kwg" value="Warga Lokal" <?= ($region_pengunjung == "Warga Lokal") ? "checked" : "" ?>>
                <label class="btn btn-outline-primary" for="btnradio3">Warga Lokal</label>

                <input type="radio" class="btn-check" id="btnradio4" name="kwg" value="Warga Asing" <?= ($region_pengunjung == "Warga Asing") ? "checked" : "" ?>>
                <label class="btn btn-outline-primary" for="btnradio4">Warga Asing</label>
            </div><br><br>

            <li>
                <h4>Tanggal Check-in dan Check-out</h4><br>

                <div class="form-floating">
                    <input type="date" class="form-control" id="checkin" name="checkin" required value="<?php echo $tgl_check_in; ?>"><br>
                    <label for="checkinlbl">Tanggal Check-in</label>
                </div>

                <div class="form-floating">
                    <input type="date" class="form-control" id="checkout" name="checkout" required value="<?php echo $tgl_check_out; ?>"><br>
                    <label for="checkoutlbl">Tanggal Check-out</label>
                </div>
            </li>

            <li>
                <h4>Pilihan Kamar % Fasilitas Tambahan</h4><br>
                <div class="form-floating">
                    <select class="form-select" id="kamar" name="kamar">
                        <option value=""></option>
                        <option value="single" <?= ($jenis_kamar == "Single") ? "selected" : "" ?>>Single</option>
                        <option value="double" <?= ($jenis_kamar == "Double") ? "selected" : "" ?>>Double</option>
                        <option value="suite" <?= ($jenis_kamar == "Suite") ? "selected" : "" ?>>Suite</option>
                    </select><br>
                    <label for="kamarlbl">Jenis Kamar</label>
                </div>

                <div class="form-floating">
                    <input type="number" class="form-control" id="jumlah_tamu" name="jumlah_tamu" min="1" value="<?php echo $jumlah_tamu; ?>" required>
                    <label for="jumlah_tamulbl">Jumlah Tamu</label>
                </div>
            </li>

            <div class="form-floating">
                <select class="form-select" id="kategori" name="kategori">
                    <option value=""></option>
                    <option value="vvip" <?= ($kategori == "VVIP") ? "selected" : "" ?>>VVIP</option>
                    <option value="vip" <?= ($kategori == "VIP") ? "selected" : "" ?>>VIP</option>
                    <option value="biasa" <?= ($kategori == "Biasa") ? "selected" : "" ?>>Biasa</option>
                </select>
                <label for="kategorilbl">Kategori:</label>
            </div><br>

            <label for="jenis_kelamin" class="mb-2" style="font-size: 20px;">Fasilitas Tambahan:</label><br>
            <input type="checkbox" class="btn-check" id="btn-check1" name="fasilitasBantal" <?= (strpos($fasilitas_tambahan, "Bantal") !== false) ? "checked" : "" ?>>
            <label class="btn btn-outline-primary" for="btn-check1">Bantal</label>

            <input type="checkbox" class="btn-check" id="btn-check2" name="fasilitasAcara" <?= (strpos($fasilitas_tambahan, "Acara Spesial") !== false) ? "checked" : "" ?>>
            <label class="btn btn-outline-primary" for="btn-check2">Acara Spesial</label><br><br><br>

            <li>
                <h4>Pembayaran</h4><br>
                <div class="form-floating">
                    <select id="metode_pembayaran" class="form-select" name="metode_pembayaran" onchange="toggleNomorKartu()">
                        <option value=""></option>
                        <option value="Kartu Kredit" <?= ($metode_pembayaran == "Kartu Kredit") ? "selected" : "" ?>>Kartu Kredit</option>
                        <option value="Tunai" <?= ($metode_pembayaran == "Tunai") ? "selected" : "" ?>>Tunai</option>
                        <option value="Transfer Bank" <?= ($metode_pembayaran == "Transfer Bank") ? "selected" : "" ?>>Transfer Bank</option>
                    </select>
                    <label for="metode_pembayaranlbl">Metode Pembayaran</label>
                </div>
            </li>

            <div class="form-floating" id="nomor_kartu_div">
                <input class="form-control" type="number" id="nomor_kartu" name="nomor_kartu" value="<?php echo $nomor_kartu_kredit; ?>" placeholder='Kosongkan bagian ini apabila metode pembayaran selain "Kartu Kredit" '><br>
                <label for="nomor_kartulbl">Nomor Kartu Kredit</label>
            </div>

            <div class="form-floating" id="tgl_expired_div">
                <input class="form-control" type="date" id="expiry" name="expiry" value="<?php echo $tgl_expired; ?>">
                <label for="expiry">Tanggal Kadaluarsa</label><br>
            </div>

            <div id="error_message" style="color: red;"></div>

            <li>
                <div class="form-floating">
                    <textarea class="form-control pb-5" id="pesan" name="pesan" rows="4" cols="50"><?php echo $pesan; ?></textarea>
                    <label for="pesan">Pesan Tambahan</label>
                </div><br>

                <div class="button-container">
                    <input type="submit" name="submit" class="btn btn-primary" value="Ubah" onclick="return toggleNomorKartu();">
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