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
    <form action="" method="POST" id="id-form" class="mt-5 mb-5" style="width: 95%;">
        <ul>
            <li>
                <h2 class="text-center">Edit Data</h2><br>
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
                    <input type="number" class="form-control" id="notlp" name="no_hp_pengunjung" value="<?php echo $no_telpon_pengunjung; ?>" required placeholder="Masukkan no telpon anda" autocomplete="off">
                    <label for="NoTelepon">No Telepon</label>
                </div>
            </li>

            <li>
                <div class="form-floating">
                    <input type="date" class="form-control" id="checkin" name="checkin" required value="<?php echo $tgl_check_in; ?>"><br>
                    <label for="checkinlbl">Tanggal Check-in</label>
                </div>

                <div class="form-floating">
                    <input type="date" class="form-control" id="checkout" name="checkout" required value="<?php echo $tgl_check_out; ?>">
                    <label for="checkoutlbl">Tanggal Check-out</label>
                </div>
            </li>

            <li>
                <div class="form-floating">
                    <select class="form-select" id="kamar" name="type_kamar">
                        <?php
                        if ($row && isset($row['nama_type_kamar'])) {
                            echo '<option value="' . $row['nama_type_kamar'] . '">' . $row['nama_type_kamar'] . '</option>';
                        } else {
                            echo '<option value="">Tidak ada jenis kamar yang tersedia</option>';
                        }
                        ?>
                    </select>
                    <label for="kamarlbl">Jenis Kamar</label>
                </div>
            </li>

            <div class="input-group mb-3">
                <span class="input-group-text">Rp</span>
                <input type="text" class="form-control" id="totalHarga" name="total_pembayaran" disabled placeholder="Total harga" value="<?php echo number_format($total_harga, 0, ',', '.'); ?>">
            </div>

            <li>
                <div class="button-container d-flex" style="width: 200px;">
                    <input type="submit" name="submit" class="btn btn-primary mx-1" value="Ubah">
                    <a href="../list.php">
                        <button type="button" class="btn btn-primary">Batal</button>
                    </a>
                    <button class="btn btn-primary mx-1" style="margin-left: -10px;" type="reset">Ulang</button>
                </div>
            </li>
        </ul>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');
            const totalPembayaranInput = document.querySelector('input[name="total_pembayaran"]');

            function TotalPembayaran() {
                const hargaKamar = parseFloat('<?php echo $row['harga_kamar']; ?>');
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkoutDate <= checkinDate) {
                    totalPembayaranInput.value = "0.00";
                    return;
                }

                const diffTime = Math.abs(checkoutDate - checkinDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                const total = hargaKamar * diffDays;
                totalPembayaranInput.value = total.toFixed(0).replace(/\d(?=(\d{3})+$)/g, '$&,');
            }
            checkinInput.addEventListener('change', TotalPembayaran);
            checkoutInput.addEventListener('change', TotalPembayaran);
        });
    </script>

</body>

</html>