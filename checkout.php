<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</html>
<?php
session_start();
require_once 'connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION["login"]) && !isset($_COOKIE["fp_hotel_access_token"])) {
    header("Location: index.php");
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
    exit;
}

if (isset($_SESSION["TFA"]["code"])) {
    header("Location: TFA.php");
    exit;
}

$no_kamar = $_GET['no_kamar'] ?? null;

if ($no_kamar) {
    $query = "SELECT k.*, t.harga_kamar, t.rating FROM kamar k INNER JOIN type_kamar t ON k.type_kamar = t.type_kamar WHERE k.no_kamar = '$no_kamar'";
    $result = mysqli_query($con, $query);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $error = [];

    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $alamat = $_POST['alamat'];
    $no_telpon = $_POST['no_telpon'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $type_kamar = $row['type_kamar'];

    // Pemeriksaan apakah semua kolom sudah terisi
    if (empty($nama) || empty($email) || empty($alamat) || empty($no_telpon) || empty($checkin) || $checkin == '0000-00-00' || empty($checkout) || $checkout == '0000-00-00') {
        $error[] = "Semua kolom harus diisi!";

        if (!empty($error)) {
            foreach ($error as $err) {
                echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Gagal melakukan booking!",
                    text: "' . $err . '"
                }).then(function() {
                    window.location.href = "checkout.php?no_kamar=' . urlencode($row['no_kamar']) . '";
                });
                </script>';
            }
            exit();
        }
    }

    // Jika semua kolom terisi, maka lanjutkan eksekusi query
    $query_insert_pengunjung = "INSERT INTO pengunjung (nama_pengunjung, email_pengunjung, alamat_pengunjung, no_hp_pengunjung) VALUES ('$nama', '$email', '$alamat', '$no_telpon')";
    mysqli_query($con, $query_insert_pengunjung);
    $pengunjung_id = mysqli_insert_id($con);

    $query_update_unit = "UPDATE type_kamar SET unit_tersedia = unit_tersedia - 1 WHERE type_kamar = '$type_kamar'";
    mysqli_query($con, $query_update_unit);

    $tgl_checkin = strtotime($checkin);
    $tgl_checkout = strtotime($checkout);

    $id = $_SESSION["user_id"];
    $waktu_sekarang = date('Y-m-d H:i:s');
    $waktu_expire = date('Y-m-d H:i:s', strtotime($waktu_sekarang . ' + 1 hour'));

    // Menghitung selisih hari check-in dan check-out
    $selisih = $tgl_checkout - $tgl_checkin;
    $lama_inap = floor($selisih / (60 * 60 * 24));
    $total_harga = $row['harga_kamar'] * $lama_inap;
    $query_insert_transaksi = "INSERT INTO transaksi (id_pengunjung, id, no_kamar, waktu_chekin, waktu_chekout, lama_inap, total_harga, expire, status) VALUES ('$pengunjung_id', '$id', '$no_kamar', '$checkin', '$checkout', '$lama_inap', '$total_harga', '$waktu_expire', 'Belum Dibayar')";
    mysqli_query($con, $query_insert_transaksi);

    $_SESSION['session_id_pengunjung'] = $pengunjung_id;
    echo '<script>
    Swal.fire({
        icon: "success",
        title: "Booking berhasil!",
        showConfirmButton: false,
        timer: 1000
    }).then(function() {
        window.location.href = "' . filter_var("pesanan.php", FILTER_SANITIZE_URL) . '";
    });
    </script>';
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Room Booking</title>

    <style>
        .container h1 {
            margin: 3rem 0rem 0rem 8.1rem;
        }

        nav {
            margin: 0rem 0rem 0rem 8.1rem;
        }

        @media (max-width: 900px) {
            .row .col-md-6 {
                width: 97%;
                overflow: hidden;
            }

            #card-img {
                margin-left: .7rem !important;
            }

            .container h1 {
                margin: 3rem 0rem 0rem .8rem;
            }

            nav {
                margin: 0rem 0rem 0rem .8rem;
            }
        }

        @media (max-width: 600px) {
            .row .col-md-6 {
                width: 97%;
                overflow: hidden;
            }

            #card-img {
                margin-left: .7rem !important;
            }

            #card-booking {
                margin-left: .7rem !important;
                width: 96.5% !important;
            }
        }

        .card-img-top {
            margin-left: 16px;
            margin-right: 16px;
            width: calc(100% - 32px);
        }
    </style>
</head>

<body>
    <div class="container">
        <?php echo '<h1>' . $row['type_kamar'] . ' Room</h1>'; ?>
        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
            <ol class="breadcrumb mt-3 mb-4">
                <li class="breadcrumb-item"><a href="welcome.php" class="text-decoration-none text-dark">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Booking</li>
            </ol>
        </nav>
        <form action="" method="POST">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="card" id="card-img" style="margin-top: .5rem; margin-left: 8rem;">
                        <?php echo '<img src="' . $row['foto_kamar'] . '" alt="foto kamar" class="card-img-top mt-3 rounded"/>'; ?>
                        <div class="card-body">
                            <?php echo '<h4>' . $row['type_kamar'] . ' Room</h4>'; ?>
                            <?php echo '<h6 class="card-title">Rp. ' . number_format($row['harga_kamar']) . ' permalam</h6>'; ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card" id="card-booking" style="margin-top: .5rem; margin-bottom: 3rem; width: 80%;">
                        <div class="card-body">
                            <h4>Detail Booking</h4>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mt-2">
                                        <input type="text" class="form-control" id="input_nama" name="nama" placeholder="Nama" autocomplete="off">
                                        <label for="input_nama">Nama</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-2 mt-2">
                                        <input type="email" class="form-control" id="input_email" name="email" placeholder="email@gmail.com" autocomplete="off">
                                        <label for="input_email">Email</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <textarea class="form-control" name="alamat" placeholder="Alamat" id="input_alamat"></textarea>
                                        <label for="input_alamat">Alamat</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <input type="number" id="input_no_telpon" class="form-control" name="no_telpon" placeholder="08***********">
                                        <label for="input_no_telpon">No Telpon</label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <input type="date" name="checkin" class="form-control" id="checkin">
                                        <label for="floatingInput">Check-in</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating mb-2">
                                        <input type="date" name="checkout" class="form-control" id="checkout">
                                        <label for="floatingInput">Check-out</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-floating mt-1 mb-2">
                                <input type="text" name="total_pembayaran" class="form-control" id="floatingInput" placeholder="Total pembayaran" disabled value="Rp. ">
                                <label for="floatingInput">Total Pembayaran</label>
                            </div>
                            <p class="text-danger mt-3 mb-0" id="pesan_error"></p>
                            <button class="btn btn-primary w-100 mb-1 mt-2" id="tombol_booking">Booking sekarang!</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pesanError = document.getElementById('pesan_error');
            const bookingButton = document.getElementById('tombol_booking');
            const checkinInput = document.getElementById('checkin');
            const checkoutInput = document.getElementById('checkout');
            const totalPembayaranInput = document.querySelector('input[name="total_pembayaran"]');

            function cekInput() {
                const input_nama = document.getElementById('input_nama').value;
                const input_email = document.getElementById('input_email').value;
                const input_alamat = document.getElementById('input_alamat').value;
                const input_no_telpon = document.getElementById('input_no_telpon').value;
                const checkinValue = checkinInput.value;
                const checkoutValue = checkoutInput.value;

                const today = new Date();
                const checkinDate = new Date(checkinValue);
                const checkoutDate = new Date(checkoutValue);

                // console.log("CheckIn: " + checkinDate);
                // console.log("CheckOut: " + checkoutDate);
                // console.log("Hari ini: " + today);

                if (checkinDate <= today || checkoutDate <= checkinDate || checkinValue === '0000-00-00' || checkinValue === '' || checkoutValue === '0000-00-00' || checkoutValue === '') {
                    pesanError.textContent = 'Masukkan tanggal check-in & check-out yang valid!';
                    bookingButton.setAttribute('disabled', true);
                } else if (input_nama !== '' && input_email !== '' && input_alamat !== '' && input_no_telpon !== '') {
                    bookingButton.removeAttribute('disabled');
                    pesanError.textContent = '';
                } else {
                    bookingButton.setAttribute('disabled', true);
                    pesanError.textContent = 'Semua kolom harus diisi!';
                }
                // console.log("input_nama:", input_nama);
                // console.log("input_email:", input_email);
                // console.log("input_alamat:", input_alamat);
                // console.log("input_no_telpon:", input_no_telpon);
            }

            function TotalPembayaran() {
                const hargaKamar = parseFloat('<?php echo $row['harga_kamar']; ?>'); // Ambil harga kamar dari PHP
                const checkinDate = new Date(checkinInput.value);
                const checkoutDate = new Date(checkoutInput.value);

                if (checkoutDate <= checkinDate) {
                    totalPembayaranInput.value = "Rp. 0.00";
                    return;
                }

                const diffTime = Math.abs(checkoutDate - checkinDate);
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                const total = hargaKamar * diffDays;
                totalPembayaranInput.value = "Rp. " + total.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'); // Format menjadi Rupiah
            }

            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('input', cekInput);
            });

            const tanggalInputs = document.querySelectorAll('input[type="date"]');
            tanggalInputs.forEach(input => {
                input.addEventListener('change', cekInput);
            });

            cekInput();

            bookingButton.addEventListener('click', function(e) {
                if (bookingButton.hasAttribute('disabled')) {
                    e.preventDefault();
                }
            });

            checkinInput.addEventListener('change', TotalPembayaran);
            checkoutInput.addEventListener('change', TotalPembayaran);
        });
    </script>
</body>

</html>