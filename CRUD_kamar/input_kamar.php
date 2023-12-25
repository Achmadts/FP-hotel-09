<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</html>
<?php
session_start();
require_once '../connection/conn.php';
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_FILES['foto_kamar']) && $_FILES['foto_kamar']['error'] === 0) {
        $allowedExtensions = ['jpg', 'jpeg', 'png'];
        $filename = $_FILES['foto_kamar']['name'];
        $fileTmpName = $_FILES['foto_kamar']['tmp_name'];
        $fileParts = explode('.', $filename);
        $fileExt = strtolower(end($fileParts));

        if (!in_array($fileExt, $allowedExtensions)) {
            echo "Hanya file dengan ekstensi JPG, JPEG, atau PNG yang diperbolehkan.";
            exit;
        }

        $destination = '../assets/img/' . $filename;

        if (move_uploaded_file($fileTmpName, $destination)) {
            $pathToSaveInDatabase = './assets/img/' . $filename;

            $type_kamar = $_POST['type_kamar'];
            $unit_tersedia = $_POST["unit_tersedia"];
            $harga_kamar = htmlspecialchars($_POST['harga_kamar']);

            $rating = '';
            switch ($type_kamar) {
                case 'Standard':
                case 'View':
                case 'Thematic':
                    $rating = 4;
                    break;
                case 'Executive':
                case 'Suite':
                case 'Family':
                    $rating = 5;
                    break;
                default:
                    $rating = 0;
                    break;
            }

            $kapasitasPengunjung = '';
            switch ($type_kamar) {
                case 'Standard':
                case 'View':
                case 'Thematic':
                case 'Executive':
                    $kapasitasPengunjung = 2;
                    break;
                case 'Suite':
                case 'Family':
                    $kapasitasPengunjung = 4;
                    break;
                default:
                    $kapasitasPengunjung = 0;
                    break;
            }

            $typeKamarQuery = "INSERT INTO type_kamar (type_kamar, harga_kamar, kapasitas_pengunjung, unit_tersedia, rating) VALUES ('$type_kamar', '$harga_kamar', '$kapasitasPengunjung', '$unit_tersedia', '$rating') ON DUPLICATE KEY UPDATE harga_kamar='$harga_kamar', rating='$rating', kapasitas_pengunjung='$kapasitasPengunjung'";
            if (mysqli_query($con, $typeKamarQuery)) {
            } else {
                echo "Error: " . $typeKamarQuery . "<br>" . mysqli_error($con);
            }
        }
    }

    $fasilitas_kamar = "";

    if (isset($_POST['fasilitasWiFi'])) {
        $fasilitas_kamar .= 'WiFi,';
    }
    if (isset($_POST['fasilitasTv'])) {
        $fasilitas_kamar .= 'TV,';
    }
    if (isset($_POST['fasilitasAc'])) {
        $fasilitas_kamar .= 'AC,';
    }
    if (isset($_POST['fasilitasPemanasAir'])) {
        $fasilitas_kamar .= 'Pemanas air,';
    }

    $fasilitas_kamar = rtrim($fasilitas_kamar, ',');
    $kamarQuery = "INSERT INTO kamar (status, foto_kamar, type_kamar, fasilitas_kamar) VALUES ('Tersedia', '$pathToSaveInDatabase', '$type_kamar', '$fasilitas_kamar')";

    if (mysqli_query($con, $kamarQuery)) {
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Data berhasil ditambahkan!",
            showConfirmButton: false,
            timer: 1000
        }).then(function() {
            window.location.href = "' . filter_var("../welcome.php", FILTER_SANITIZE_URL) . '";
        });
        </script>';
    } else {
        echo "Error: " . $kamarQuery . "<br>" . mysqli_error($con);
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <title>Input Kamar</title>
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

        .fasilitas {
            display: flex;
            justify-content: center;
        }

        @media (max-width: 768px) {
            .fasilitas {
                flex-direction: column;
                align-items: center;
            }
        }
    </style>
</head>

<body>
    <form action="" method="POST" enctype="multipart/form-data" class="mt-5 mb-5" style="width: 95%;">
        <ul>
            <li>
                <h2 class="text-center">Input Kamar</h2><br>

                <div class="mb-3">
                    <label for="fotoKamar" class="form-label">Foto Kamar</label>
                    <input class="form-control" name="foto_kamar" type="file" id="fotoKamar">
                </div>

                <div class="form-floating">
                    <select class="form-select" id="type_kamar" name="type_kamar">
                        <option value="Standard">Standard</option>
                        <option value="Executive">Executive</option>
                        <option value="Suite">Suite</option>
                        <option value="View">View</option>
                        <option value="Family">Family</option>
                        <option value="Thematic">Thematic</option>
                    </select>
                    <label for="typeKamarLbl">Jenis Kamar</label><br>
                </div>

                <div class="form-floating">
                    <input type="number" class="form-control" id="totalKamar" name="unit_tersedia" required placeholder="Masukkan total kamar yang ingin ditambahkan" autocomplete="off"><br>
                    <label for="totalKamar">Masukkan total kamar yang ditambahkan</label>
                </div>
                <div class="form-floating">
                    <input type="number" class="form-control" id="hargaKamar" name="harga_kamar" required placeholder="Masukkan harga kamar" autocomplete="off"><br>
                    <label for="hargaKamar">Masukkan harga Kamar permalam</label>
                </div>

                <div class="d-flex flex-column align-items-center">
                    <label for="jenis_kelamin" class="mb-2" style="font-size: 20px;">Fasilitas:</label>
                    <div class="fasilitas mb-4" style="width: 100%;">
                        <input type="checkbox" class="btn-check" id="btn-check1" name="fasilitasWiFi">
                        <label class="btn btn-outline-primary me-1 mb-1" for="btn-check1">WiFi</label>

                        <input type="checkbox" class="btn-check" id="btn-check2" name="fasilitasTv">
                        <label class="btn btn-outline-primary me-1 mb-1" for="btn-check2">TV</label>

                        <input type="checkbox" class="btn-check" id="btn-check3" name="fasilitasAc">
                        <label class="btn btn-outline-primary me-1 mb-1" for="btn-check3">AC</label>

                        <input type="checkbox" class="btn-check" id="btn-check4" name="fasilitasPemanasAir">
                        <label class="btn btn-outline-primary mb-1" for="btn-check4">Pemanas Air</label>
                    </div>
                </div>

                <div class="button-container d-flex" style="width: 200px;">
                    <input type="submit" name="submit" class="btn btn-primary mx-1" value="Kirim">
                    <a href="../welcome.php">
                        <button type="button" class="btn btn-danger">Batal</button>
                    </a>
                    <button class="btn btn-warning mx-1" type="reset" style="margin-left: -10px;">Ulang</button>
                </div>
            </li>
        </ul>
    </form>
    <script src="js/script.js"></script>
</body>

</html>