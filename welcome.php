<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</html>
<?php
session_start();

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Dotenv\Dotenv;

require_once 'connection/conn.php';
require_once 'vendor/autoload.php';
require_once "connection/google_config.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

// GitHub login
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// get the user's details

function getUser()
{
    if (empty($_COOKIE["fp_hotel_access_token"])) {
        return false;
    }
    $apiUrl = "https://api.github.com/user";

    $client = new Client();

    try {
        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $_COOKIE["fp_hotel_access_token"],
                'Accept' => 'application/json',
            ]
        ]);
        if ($response->getStatusCode() == 200) {
            return json_decode($response->getBody()->getContents());
        }
        return false;
    } catch (RequestException $e) {
        return false;
    }
}
$user = false;
$user = getUser();
// END GitHub login

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
    exit;
}

if (isset($_GET['code'])) {
    // Ambil token kalau belum ada di sesi
    if (!isset($_SESSION['access_token'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $_SESSION['access_token'] = $token;
    }

    if (isset($_SESSION['access_token']['access_token'])) {
        $client->setAccessToken($_SESSION['access_token']['access_token']);
        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Login berhasil!",
            showConfirmButton: false,
            timer: 1000
        }).then(function() {
            window.location.href = "' . filter_var("welcome.php", FILTER_SANITIZE_URL) . '";
        });
        </script>';
        // header('Location: ' . filter_var("welcome.php", FILTER_SANITIZE_URL));

        $google_oauth = new Google\Service\Oauth2($client);
        $google_account_info = $google_oauth->userinfo->get();
        $userinfo = [
            'email' => $google_account_info['email'],
            'name' => $google_account_info['name'],
            'verifiedEmail' => $google_account_info['verifiedEmail'],
            'token' => $google_account_info['id'],
        ];
    } else {
        echo 'Gagal mendapatkan access token. Pesan Kesalahan: Kunci "access_token" tidak ditemukan di session.';
        die();
    }
    // Cek apakah user sudah ada di db
    $sql = "SELECT * FROM user  WHERE email = '{$userinfo['email']}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $userinfo = mysqli_fetch_assoc($result);
        $token = $userinfo["token"];
    } else {
        $sql = "INSERT INTO user (name, email, verifiedEmail, token) VALUES ('{$userinfo['name']}', '{$userinfo['email']}', '{$userinfo['verifiedEmail']}', '{$userinfo['token']}')";
        $result = mysqli_query($con, $sql);

        if ($result) {
            $token = $userinfo['token'];
        } else {
            echo "Pengguna tidak dibuat!";
            die();
        }
    }
    $_SESSION['login'] = $token;
} else {
    if (!isset($_SESSION["login"]) && !isset($_COOKIE["fp_hotel_access_token"])) {
        header("Location: index.php");
        die();
    };

    // Cek apakah user sudah ada di db
    $sql = "SELECT * FROM user WHERE token = '{$_SESSION['login']}'";
    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row["type"] == 1) {
            $_SESSION["login_type"] = "admin_login";
        } else {
            $_SESSION["login_type"] = "user_login";
        }

        $userinfo = $row;
    }
}

// echo "<pre>";
// var_dump($_SESSION);
// var_dump($_COOKIE);
// print_r($userinfo);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" href="assets/css/welcome.css">
    <title>Welcome</title>
    <style>
        /* button {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            margin: 3px;
            border: none;
            cursor: pointer;
            box-shadow: 0px 0px 10px rgba(0, 0, 0.1);
            display: inline;
            border-radius: 5px;
        } */

        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 16.5px;
            width: 100%;
        }
    </style>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container">
            <a href="#"><img src="./assets/img/WhatsApp_Image_2023-09-05_at_15.02.25-removebg-preview.png.png" alt="Logo" width="26" height="25" class="d-inline-block align-text-top m-2 mt-3 mb-3"></a>
            <a class="navbar-brand" href="#">Hotel PPLG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="about.php">About</a>
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
                <p class="text-light my-3"><?= isset($userinfo['name']) ? $userinfo['name'] : $_SESSION["login"]; ?></p>
            </div>
        </div>
    </nav>
    <center>
        <div style="flex-grow: 1;">
            <div class="container justify-content-center align-items-center" style="margin-top: 30vh;">
                <h1>Selamat Datang <span style="background: #0074d9; color: #fff; border-radius: 5px; padding: 0 10px;"> <?= isset($userinfo['name']) ? $userinfo['name'] : (isset($_SESSION["login"]) ? $_SESSION["login"] : $user->name); ?></span> di Hotel PPLG!</h1>
                <p>Tempat Kenyamanan dan Keramahan Berpadu😊.</p>
                <div class="row mt-2" style="width: 135px;">
                    <div class="col-6">
                        <a href="input.php"><button class="btn btn-primary">Input</button></a>
                    </div>
                    <div class="col-6">
                        <form action="logout.php" onsubmit="return confirmLogout();">
                            <input type="submit" class="btn btn-primary" value="Logout">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </center>
    <footer class="p-1 text-center" style="margin-top: 29vh;">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-md-6" style="width: 221px;">
                    <p class="fw-bold mt-3">fountaine project &COPY; 2023</p>
                </div>
                <div class="col-md-6" style="width: 41px; margin-top: 2px;">
                    <a href="https://www.instagram.com/rpl2_59/?igshid=OGQ5ZDc2ODk2ZA%3D%3D"><img src="assets/img/logo_pplg.png" width="41" height="40"></a>
                </div>
            </div>
        </div>
    </footer>
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

</html>