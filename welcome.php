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

// Login GitHub
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

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
// Akhir login GitHub

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
    $sql = "SELECT * FROM user WHERE email = '{$userinfo['email']}' OR name = '{$userinfo['name']}' OR token = '{$userinfo['token']}' ";
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
    $newUserId = mysqli_insert_id($con);
    $_SESSION['login'] = $token;
    $_SESSION["user_id"] = $newUserId;
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
        $user_id = $_SESSION["user_id"] = $userinfo['id'];
        $_SESSION['userinfo'] = $userinfo;
    }
}

// echo "<pre>";
// var_dump($_SESSION);
// var_dump($_COOKIE);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <link rel="stylesheet" href="css/welcome.css">
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

        @media (max-width: 900px) {
            .populer__card img {
                height: auto;
            }

            .header__content h1 {
                font-size: 1rem;
                margin-bottom: 0rem;
            }
        }

        @media (max-width: 600px) {
            .populer__card img {
                height: auto !important;
            }

            .header__content h1 {
                font-size: 1rem;
                margin-bottom: 0rem;
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
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="about.php">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="pesanan.php">Pesanan</a>
                    </li>
                    <?php
                    if (!isset($_SESSION["login_type"]) || $_SESSION["login_type"] !== "admin_login") {
                    } else {
                        echo ' <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Admin
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="user_list.php">Data User (Hanya Admin)</a></li>
                                        <li><a class="dropdown-item" href="list.php">Data Pengunjung (Hanya Admin)</a></li>
                                    </ul>
                                </li>';
                    }
                    ?>
                </ul>
                <p class="text-light my-3 me-4"><?= isset($userinfo['name']) ? $userinfo['name'] : $_SESSION["login"]; ?></p>
                <form action="./logout.php" onsubmit="return confirmLogout();">
                    <button class="btn btn-outline-primary justify-content-center align-items-center" type="submit"><i class="bi bi-box-arrow-left" style="display: inline-block; margin-top: 1px;"></i> Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <header class="section__container header__container">
        <div class="header__image__container">
            <div class="header__content">
                <h1>Hai <span class="text-primary"><?= isset($userinfo['name']) ? $userinfo['name'] : (isset($_SESSION["login"]) ? $_SESSION["login"] : $user->name); ?>!</span> Selamat Datang di hotel PPLG</h1>
                <p>Tempat Kenyamanan dan Keramahan Berpadu😊.</p>
            </div>
        </div>
    </header>
    <section class="section__container populer__container">
        <h2 class="section__header">Tipe Kamar</h2>
        <div class="populer__grid">
            <?php
            $query = "SELECT k.*, t.harga_kamar, t.kapasitas_pengunjung, t.rating FROM kamar k
          INNER JOIN type_kamar t ON k.type_kamar = t.type_kamar";
            $result = mysqli_query($con, $query);

            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="populer__card">';
                echo '<img src="' . $row['foto_kamar'] . '" alt="foto kamar" width="350" height="300" />';
                echo '<div class="populer__content">';
                echo '<div class="populer__card__header">';
                echo '<h4 style="margin-top: -40px;">' . $row['type_kamar'] . " Room" . '</h4>';
                echo '<h4>Rp. ' . number_format($row['harga_kamar']) . '<p style="margin-top: 10px; font-size: 13px;">Permalam</p></h4>';
                echo '</div>';
                echo '<p style="margin-top: -20px;">Fasilitas</p>';
                echo '<div class="d-flex mb-0">';

                $fasilitas = explode(',', $row['fasilitas_kamar']);
                foreach ($fasilitas as $fasilitas_item) {
                    echo '<b class="me-2" style="background-color: #f3f4f6; margin-top: -5px; font-size: 12px; padding: 5px 5px 5px 5px; border-radius: 5px;">' . $fasilitas_item . '</b>';
                }
                echo '</div>';

                echo '<p style="margin-top: 1.2rem;">Kapasitas tamu</p>';
                echo '<div class="d-flex" style="margin-top: -5px;">
                    <b class="me-2" style="background-color: #f3f4f6; font-size: 12px; padding: 5px 7px 5px 7px; border-radius: 5px;">' . $row['kapasitas_pengunjung'] . ' orang dewasa</b>
                    <p class="mx-2 my-1">atau</p>
                    <b class="ms-2" style="background-color: #f3f4f6; font-size: 12px; padding: 5px 7px 5px 7px; border-radius: 5px;">' . $row['kapasitas_pengunjung'] . ' orang anak</b>
                </div>';

                echo '<p class="mb-1" style="margin-top: 1.2rem;">Rating</p>';
                for ($i = 0; $i < $row['rating']; $i++) {
                    echo '<i class="bi bi-star-fill text-warning me-1"></i>';
                }

                $statusLabel = '';
                if ($row["ketersediaan"] === "Tersedia") {
                    $statusLabel = '<a href="checkout.php?no_kamar=' . $row['no_kamar'] . '&type_kamar=' . $row['type_kamar'] . '"><button class="btn btn-primary">Booking</button></a>';
                } elseif ($row['ketersediaan'] === "Tidak tersedia") {
                    $statusLabel = '<button class="btn btn-danger" disabled>Booking (Tidak tersedia)</button>';
                }

                echo '<div style="text-align: center; margin-top: 20px;">';
                echo $statusLabel;
                echo '<a href="room_details.php?no_kamar=' . $row['no_kamar'] . '&type_kamar=' . $row['type_kamar'] . '"><button class="btn btn-secondary ms-1">Details</button></a>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            ?>
        </div>
    </section>

    <section class="client">
        <div class="section__container client__container">
            <h2 class="section__header">Fasilitas</h2>
            <div class="client__grid">
                <div class="client__card">
                    <i class="bi bi-wifi mb-3" style="font-size: 85px; justify-content: center; align-items: center; right: 50%; display: flex;"></i>
                    <p>Kami menyediakan fasilitas <strong>WiFi</strong> gratis yang bisa digunakan sepuasnya oleh seluruh pengunjung hotel kami.</p>
                </div>
                <div class="client__card" style="text-align: center;">
                    <i class="fa-solid fa-person-swimming fa-fw mb-3" style="font-size: 85px; margin: 0 auto; display: block;"></i>
                    <p>Kami menyediakan fasilitas <strong>kolam renang</strong> yang bisa digunakan kapanpun oleh seluruh pengunjung hotel kami.</p>
                </div>

                <div class="client__card">
                    <i class="fa-solid fa-dumbbell mb-3" style="font-size: 85px; justify-content: center; align-items: center; right: 50%; display: flex;"></i>
                    <p>Kami menyediakan fasilitas tempat <strong>GYM</strong> yang bisa digunakan kapanpun oleh seluruh pengunjung hotel kami.</p>
                </div>
                <div class="client__card">
                    <i class="fa-solid fa-spa mb-3" style="font-size: 85px; justify-content: center; align-items: center; right: 50%; display: flex;"></i>
                    <p>Kami menyediakan fasilitas <strong>SPA</strong> dengan kualitas sangat baik yang bisa digunakan kapanpun oleh seluruh pengunjung hotel kami.</p>
                </div>
                <div class="client__card">
                    <i class="fa-solid fa-utensils mb-3" style="font-size: 85px; justify-content: center; align-items: center; right: 50%; display: flex;"></i>
                    <p>Kami menyediakan fasilitas <strong>restaurant</strong> dengan menu-menu nusantara yang sangat lezat dan bervariasi.</p>
                </div>
                <div class="client__card">
                    <i class="fa-solid fa-clock mb-3" style="font-size: 85px; justify-content: center; align-items: center; right: 50%; display: flex;"></i>
                    <p>Kami <strong>siap melayani tamu 24 Jam</strong> jika ada yang membutuhkan bantuan.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- <section class="section__container">
        <div class="reward__container">
            <p>100+ discount codes</p>
            <h4>Join rewards and discover amazing discounts on your booking</h4>
            <button class="reward__btn">Join Rewards</button>
        </div>
    </section> -->

    <footer class="p-1 text-center" style="margin-top: 29vh;">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-md-6" style="width: 231px;">
                    <p class="fw-bold mt-3">fountaine project &COPY; 2023</p>
                </div>
                <div class="col-md-6" style="width: 65px; margin-top: 2px;">
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