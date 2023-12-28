<?php
session_start();
require_once 'connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"]) && !isset($_SESSION["login_type"]) || $_SESSION["login_type"] !== "admin_login") {
    header('Location: index.php');
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

// echo "<pre>";
// print_r($_SESSION);
// print_r($_COOKIE);
// echo "</pre>";

$limit = 2;
$halaman = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;
$query = "SELECT * FROM user";
$result = $con->query($query);
$totalBaris = $result->num_rows;
$totalHalaman = ceil($totalBaris / $limit);
$imbang = ($halaman - 1) * $limit;
$query = $query . " LIMIT $limit OFFSET $imbang";
$result = $con->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/stylelist.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.all.min.js"></script>
    <title>Data User</title>

    <style>
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: #fff;
            box-shadow: 0px 0px 10px 10px rgba(0, 0, 0, 0.1);
        }

        tr:hover {
            background-color: #f5f5f5;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 16.5px;
            width: 100%;
        }

        .swal2-title {
            background-color: white;
        }

        .pagination-container {
            position: fixed;
            bottom: 75px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 1;
            padding: 10px;
        }

        @media (max-width: 900px) {
            .alert.alert-primary {
                margin-left: 0rem !important;
                width: 100% !important;
            }
        }

        @media (max-width: 600px) {
            .alert.alert-primary {
                margin-left: 0rem !important;
                width: 100% !important;
            }
        }
    </style>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    <div style="flex-grow: 1;">
        <?php include "partials/navbar_user.php"; ?>

        <!-- <div class="tombol mx-5 justify-content-center align-items-center" style="margin-top: 100px;"> -->
        <div class="container">
            <div class="alert alert-primary mt-4 mb-4" style="width: 93.5%; margin-left: 2.65rem;" role="alert">
                Tabel User yang terdaftar
            </div>
            <div class="row  mt-3 justify-content-center align-items-center">
                <div class="col-md-4">
                    <a href="CRUD_user/tambah_user.php" style="margin-left: 110px;" class="float-start"><button><i class="bi bi-person-plus-fill"> Tambah Data </i></button></a>
                </div>
            </div>
        </div>
        <!-- </div> -->
        <div class="table table-responsive">
            <table border="1" class="table align-middle" style="width: 80%;">
                <thead>
                    <tr>
                        <th style="background-color: #000; color: #fff;">No</th>
                        <th style="background-color: #000; color: #fff;">Id</th>
                        <th style="background-color: #252525; color: #fff;">Nama</th>
                        <th style="background-color: #252525; color: #fff;">Email</th>
                        <th style="background-color: #252525; color: #fff;">Verivied Email</th>
                        <th style="background-color: #252525; color: #fff;">Token</th>
                        <th style="background-color: #252525; color: #fff;" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="tampil">
                    <?php
                    $i = ($halaman - 1) * $limit;
                    if ($result->num_rows > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $i++;
                            echo "<tr class='border'>";
                            echo "<td>" . $i . "</td>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['name'] . "</td>";
                            echo "<td>" . $row['email'] . "</td>";
                            echo "<td>" . $row['verifiedEmail'] . "</td>";
                            echo "<td>" . $row['token'] . "</td>";
                            echo '<div class="container">
                            <td class="d-flex text-center justify-content-center align-items-center mb-4" style="border: none;">
                                <a href="CRUD_user/edit_user.php?editid=' . $row["id"] . '" style="margin-bottom: -10px; margin-top: 20px; text-align: center; display: block;" class="justify-content-center"><button class="btn btn-primary mx-2 mt-0"><i class="bi bi-pencil-square text-white"></i></button></a>
                                <button class="btn btn-danger mx-2 mt-0 tombol-hapus" data-id="' . $row["id"] . '" style="margin-bottom: -30px;"><i class="bi bi-trash text-white"></i></button>
                            </td>
                        </div>';
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>Tidak ada data user.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <?php include 'partials/pagination.php'; ?>
    </div>
    <footer class="p-1 text-center">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-md-6" style="width: 221px;">
                    <p class="fw-bold mt-3" style="font-size: 16.5px;">fountaine project &COPY; 2023</p>
                </div>
                <div class="col-md-6" style="width: 41px; margin-top: -17px;">
                    <a href="https://www.instagram.com/rpl2_59/?igshid=OGQ5ZDc2ODk2ZA%3D%3D"><img src="assets/img/logo_pplg.png" width="41" height="40"></a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script>
        document.querySelectorAll('.tombol-hapus').forEach(function(button) {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Yakin mau hapus data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'CRUD_user/hapusUser.php?hapusid=' + itemId;
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#search").on("keyup", function() {
                $.ajax({
                    type: "POST",
                    url: 'search_user.php',
                    data: {
                        cari: $(this).val()
                    },
                    cache: false,
                    success: function(data) {
                        $('#tampil').html(data);
                    }
                });
            });
        });
    </script>
</body>

</html>