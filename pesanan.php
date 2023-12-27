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

if (isset($_SESSION['status_pembayaran']) && $_SESSION['status_pembayaran'] == 'success') {
    echo '<script>
            document.addEventListener("DOMContentLoaded", function() {
                Swal.fire({
                    title: "Pembayaran Berhasil!",
                    text: "Terimakasih!",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
          </script>';

    unset($_SESSION['status_pembayaran']);
}

if (isset($_POST['submit'])) {

    if (!isset($_GET['id_transaksi'])) {
        echo "ID transaksi tidak ditemukan!";
        exit;
    }
    $id_transaksi = $_GET['id_transaksi'];

    if (!isset($_GET['id_pengunjung'])) {
        echo "ID pengunjung tidak ditemukan!";
        exit;
    }
    $id_pengunjung = $_GET['id_pengunjung'];

    if (!isset($_POST['nominal']) || empty($_POST['nominal'])) {
        echo "Nominal tidak ditemukan!";
        exit;
    }

    function hapusFormatAngka($amount)
    {
        return (int) str_replace(['Rp.', '.', ' '], '', $amount);
    }

    $nominal = hapusFormatAngka($_POST['nominal']);

    if (!isset($_SESSION['user_id'])) {
        echo "User ID tidak ditemukan!";
        exit;
    }
    $user_id = $_SESSION['user_id'];

    $query_total_harga = "SELECT total_harga FROM transaksi WHERE id_transaksi = ?";
    $stmt_total_harga = mysqli_prepare($con, $query_total_harga);
    mysqli_stmt_bind_param($stmt_total_harga, "i", $id_transaksi);
    mysqli_stmt_execute($stmt_total_harga);
    $result_total_harga = mysqli_stmt_get_result($stmt_total_harga);
    $row_total_harga = mysqli_fetch_assoc($result_total_harga);
    $total_harga = $row_total_harga['total_harga'];

    if ($nominal != $total_harga) {
        echo '<script>
            Swal.fire({
                title: "Gagal!",
                text: "Nominal tidak sesuai!",
                icon: "error"
            });
        </script>';
    } else {
        $update_query = "UPDATE transaksi SET status = 'Dibayar' WHERE id_transaksi = ?";
        $stmt = mysqli_prepare($con, $update_query);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "i", $id_transaksi);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);

            $_SESSION['status_pembayaran'] = 'success';
            header("Location: pesanan.php");
            exit;
        } else {
            echo "Error: " . mysqli_error($con);
        }
    }
}

if (isset($_POST['hapusHistoriPesanan'])) {
    if (!isset($_GET['id_transaksi']) || !isset($_GET['id_pengunjung'])) {
        echo "ID transaksi atau ID pengunjung tidak ditemukan!";
        exit;
    }

    $id_transaksi = $_GET['id_transaksi'];
    $id_pengunjung = $_GET['id_pengunjung'];

    $query_select = "SELECT id_pengunjung FROM transaksi WHERE id_pengunjung = ? AND id_pengunjung = ? AND (status = 'Expired' OR status = 'Dibayar')";
    $stmt_select = mysqli_prepare($con, $query_select);
    mysqli_stmt_bind_param($stmt_select, "ii", $id_transaksi, $id_pengunjung);
    mysqli_stmt_execute($stmt_select);

    $result = mysqli_stmt_get_result($stmt_select);

    if ($row = mysqli_fetch_assoc($result)) {
        $query1 = "DELETE FROM transaksi WHERE id_pengunjung = ?";
        $stmt1 = mysqli_prepare($con, $query1);
        mysqli_stmt_bind_param($stmt1, "i", $id_pengunjung);
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_close($stmt1);

        $query2 = "DELETE FROM pengunjung WHERE id_pengunjung = ?";
        $stmt2 = mysqli_prepare($con, $query2);
        mysqli_stmt_bind_param($stmt2, "i", $id_pengunjung);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_close($stmt2);

        header("Location: pesanan.php");
        exit();
    } else {
        echo "Tidak ada data pengunjung dengan ID transaksi dan ID pengunjung yang diberikan!";
    }

    mysqli_stmt_close($stmt_select);
}

if (isset($_POST['batalkanPesanan'])) {
    if (!isset($_GET['id_transaksi'])) {
        echo "ID transaksi tidak ditemukan dalam URL!";
        exit;
    }

    $id_transaksi = $_GET['id_transaksi'];

    $query_check_transaksi = "SELECT id_transaksi FROM transaksi WHERE id_transaksi = ? AND status = 'Belum Dibayar'";
    $stmt_check_transaksi = $con->prepare($query_check_transaksi);
    $stmt_check_transaksi->bind_param('s', $id_transaksi);
    $stmt_check_transaksi->execute();
    $result_transaksi = $stmt_check_transaksi->get_result();

    if ($result_transaksi->num_rows > 0) {
        $query_update = "UPDATE transaksi SET status = 'Dibatalkan' WHERE id_transaksi = ?";
        $stmt_update = $con->prepare($query_update);
        $stmt_update->bind_param('s', $id_transaksi);

        if ($stmt_update->execute()) {
            header('Location: pesanan.php');
            exit();
        } else {
            echo "Gagal membatalkan pesanan: " . $stmt_update->error;
        }
        $stmt_update->close();
    } else {
        echo "Tidak ada transaksi yang ditemukan dengan ID transaksi tersebut atau sudah dibayar.";
    }
    $stmt_check_transaksi->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Pesanan</title>

    <style>
        .img-fluid {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        @media (max-width: 900px) {
            .img-fluid {
                border-top-left-radius: 5px;
                border-top-right-radius: 5px;
                border-bottom-left-radius: 0px;
            }
        }


        @media (max-width: 600px) {
            .img-fluid {
                width: 100% !important;
                height: 100% !important;
                margin: auto !important;
            }
        }
    </style>

</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container">
            <a href="#"><img src="./assets/img/WhatsApp_Image_2023-09-05_at_15.02.25-removebg-preview.png.png" alt="Logo" width="26" height="25" class="d-inline-block align-text-top m-2 mt-3 mb-3"></a>
            <a class="navbar-brand ms-2" href="#">Hotel PPLG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="profile.php">Pesanan</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data (Hanya Admin)
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="user_list.php">Data User (Hanya Admin)</a></li>
                            <li><a class="dropdown-item" href="list.php">Data Pengunjung (Hanya Admin)</a></li>
                        </ul>
                    </li>
                </ul>
                <p class="text-light my-3 me-4"><?= isset($_SESSION["userinfo"]) ? $_SESSION["userinfo"]["name"] : $_SESSION["login"]; ?></p>
                <form action="./logout.php" onsubmit="return confirmLogout();">
                    <button class="btn btn-outline-primary justify-content-center align-items-center" type="submit" style="margin-bottom: -15px;"><i class="bi bi-box-arrow-left" style="display: inline-block; margin-top: 1px;"></i> Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <?php
    $user_id = $_SESSION["user_id"];

    $updateExpiredQuery = "
        UPDATE transaksi t
        JOIN user u ON t.id = u.id
        SET t.status = 'Expired'
        WHERE u.id = $user_id AND t.status = 'Belum Dibayar' AND NOW() > t.expire;
    ";

    mysqli_query($con, $updateExpiredQuery);

    $query = "
    SELECT t.id_transaksi, k.foto_kamar, tk.type_kamar, tk.rating, t.waktu_chekin, t.waktu_chekout, t.total_harga, t.status, t.expire, t.id_pengunjung
    FROM kamar k
    JOIN type_kamar tk ON k.type_kamar = tk.type_kamar
    JOIN transaksi t ON k.no_kamar = t.no_kamar
    JOIN user u ON t.id = u.id
    WHERE u.id = $user_id;
";

    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) == 0) {
        echo '<div class="container mt-5">
     <div class="alert alert-warning" role="alert">
         Tidak ada pesanan.
     </div>
   </div>';
    } else {
        while ($row = mysqli_fetch_assoc($result)) {
    ?>
            <div class="container mb-5">
                <form action="pesanan.php?id_transaksi=<?php echo $row['id_transaksi']; ?>&id_pengunjung=<?php echo $row['id_pengunjung']; ?>" method="POST">
                    <div class="card mb-3 mt-5" style="max-width: 58.47rem;">
                        <div class="row g-0">
                            <div class="col-md-6">
                                <img src="<?php echo $row['foto_kamar']; ?>" class="img-fluid h-100" alt="<?php echo $row['type_kamar']; ?> Room">
                            </div>
                            <div class="col-md-6">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h5 class="card-title"><?php echo $row["type_kamar"]; ?> Room</h5>
                                        </div>
                                        <div class="col-md-6 d-flex justify-content-md-end justify-content-start mb-3 mb-md-0">
                                            <p class="card-text">
                                                <?php
                                                for ($i = 0; $i < $row['rating']; $i++) {
                                                    echo '<i class="bi bi-star-fill text-warning me-1"></i>';
                                                }
                                                ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between" style="margin-bottom: -10px; margin-top: 5px;">
                                        <p>Status:</p>
                                        <?php
                                        if ($row && $row['status'] === 'Dibayar') {
                                            echo '<p class="text-end"><i class="bi bi-circle-fill text-success"> ' . $row["status"] . '</i></p>';
                                        } elseif ($row && $row['status'] === 'Belum Dibayar') {
                                            echo '<p class="text-end"><i class="bi bi-circle-fill text-warning"> ' . $row["status"] . '</i></p>';
                                        } else {
                                            echo '<p class="text-end"><i class="bi bi-circle-fill text-danger"> ' . $row["status"] . '</i></p>';
                                        }
                                        ?>
                                    </div>
                                    <div class="d-flex justify-content-between" style="margin-bottom: -10px;">
                                        <p>Check In:</p>
                                        <p class="text-end"><?php echo $row["waktu_chekin"] ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between" style="margin-bottom: -10px;">
                                        <p>Check Out:</p>
                                        <p class="text-end"><?php echo $row["waktu_chekout"] ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between" style="margin-bottom: -10px;">
                                        <p>Tenggat bayar:</p>
                                        <p class="text-end"><?php echo $row["expire"] ?></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <p>Total harga:</p>
                                        <p class="text-end">Rp. <?php echo number_format($row['total_harga']); ?></p>
                                    </div>
                                    <?php
                                    if ($row && $row['status'] === 'Dibayar' || $row && $row['status'] === 'Expired' || $row && $row['status'] === 'Dibatalkan') {
                                        echo '<button type="submit" class="btn btn-danger w-100 mt-4" name="hapusHistoriPesanan">Hapus histori pesanan</button>';
                                    } else {
                                        echo '<div class="input-group mb-3">
                                                    <span class="input-group-text">Rp</span>
                                                    <input type="text" class="form-control" name="nominal" placeholder="Masukkan nominal pembayaran" autocomplete="off">
                                                </div>
                                                <div class="d-flex">
                                                <button type="submit" class="btn btn-primary w-50 me-1" name="submit">Bayar</button>
                                                <button type="submit" class="btn btn-danger w-50 ms-1" name="batalkanPesanan">Batalkan Pesanan</button>
                                                </div>';
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
    <?php
        }
    }
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin mau logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
            return false;
        }
    </script>
    <script>
        function formatAngka(angka) {
            var reverse = angka.toString().split('').reverse().join(''),
                ribuan = reverse.match(/\d{1,3}/g);
            ribuan = ribuan.join('.').split('').reverse().join('');
            return ribuan;
        }

        function hapusFormatAngka(rp) {
            return parseInt(rp.replace(/,.*|[^0-9]/g, ''), 10);
        }

        document.querySelector('[name="nominal"]').addEventListener('input', function(e) {
            e.target.value = formatAngka(hapusFormatAngka(e.target.value));
        });
    </script>
</body>

</html>