<?php
session_start();
require_once 'connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"])) {
    header('Location: login.php');
    exit;
};

$query = "SELECT * FROM pengunjung";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.10/dist/sweetalert2.all.min.js"></script>
    <title>Data Pengunjung</title>

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
    </style>
</head>

<body>
    <?php include "partials/navbar_pengunjung.php"; ?>

    <div class="tombol mx-5 justify-content-center align-items-center" style="margin-top: 100px;">
        <a href="CRUD_pengunjung/tambah.php" style="margin-left: 105px;" class="float-start"><button><i class="bi bi-person-plus-fill"> Tambah Data </i></button></a>
        <a href="welcome.php" style="margin-right: 105px;" class="float-end"><button><i class="bi bi-box-arrow-left"> Kembali </i></button></a>
    </div>
    <br><br><br>
    <table border="1">
        <tr>
            <th style="background-color: #000; color: #fff;">No</th>
            <th style="background-color: #252525; color: #fff;">Nama</th>
            <th style="background-color: #252525; color: #fff;">Alamat</th>
            <th style="background-color: #252525; color: #fff;">No telepon</th>
            <th style="background-color: #252525; color: #fff;">Tanggal Check-in</th>
            <th style="background-color: #252525; color: #fff;">Tanggal Check-out</th>
            <th style="background-color: #252525; color: #fff;">Tipe Kamar</th>
            <th style="background-color: #252525; color: #fff;">Jumlah Tamu</th>
            <th style="background-color: #252525; color: #fff;" class="text-center">Action</th>
        </tr>

        <?php
        $i = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $i++;
                echo "<tr class='border'>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $row['name'] . "</td>";
                echo "<td>" . $row['alamat'] . "</td>";
                echo "<td>" . $row['no_telpon'] . "</td>";
                echo "<td>" . $row['tgl_check_in'] . "</td>";
                echo "<td>" . $row['tgl_check_out'] . "</td>";
                echo "<td>" . $row['jenis_kamar'] . "</td>";
                echo "<td>" . $row['jumlah_tamu'] . "</td>";
                echo '<div class="container">
                    <td class="d-flex text-center justify-content-center align-items-center mb-4" style="border: none;">
                        <a href="crud_pengunjung/edit.php?editid=' . $row["id"] . '" style="margin-bottom: -10px;" class="justify-content-center"><button class="btn btn-primary mx-2 mt-0"><i class="bi bi-pencil-square text-white"></i></button></a>
                        <button class="btn btn-danger mx-2 mt-0 tombol-hapus" data-id="' . $row["id"] . '" style="margin-bottom: -30px;"><i class="bi bi-trash text-white"></i></button>
                    </td>
                </div>';
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada data pengunjung.</td></tr>";
        }
        ?>
    </table>
    <footer class="p-1 text-center" style="margin-top: 31.8vh;">
        <p class="fw-bold mt-3">fountaine project &COPY; 2023</p>
    </footer>
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
                        window.location.href = 'crud_pengunjung/hapus.php?hapusid=' + itemId;
                    }
                });
            });
        });
    </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>