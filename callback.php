<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</html>
<?php
session_start();
require_once 'connection/conn.php';
require_once "./vendor/autoload.php";

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Dotenv\Dotenv;

function getUser($accessToken)
{
    $apiUrl = "https://api.github.com/user";
    $client = new Client();

    try {
        $response = $client->get($apiUrl, [
            'headers' => [
                'Authorization' => 'Bearer ' . $accessToken,
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

function tukarKode($data, $apiUrl)
{
    $client = new Client();

    try {
        $response = $client->post($apiUrl, [
            'form_params' => $data,
            'headers' => [
                'Accept' => 'application/json'
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

if (isset($_GET["error"]) || !isset($_GET["code"])) {
    echo "Beberapa kesalahan terjadi";
    exit();
}

$kodeOtentikasi = $_GET["code"];
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Tukar kode untuk mendapatkan akses token (pakai Guzzle agar lebih mudah)
$data = [
    'client_id' => $_ENV["GITHUB_CLIENT_ID"],
    'client_secret' => $_ENV["GITHUB_CLIENT_SECRET"],
    'code' => $kodeOtentikasi,
];

$apiUrl = "https://github.com/login/oauth/access_token";

$tokenData = tukarKode($data, $apiUrl);

if ($tokenData === false) {
    exit("Gagal mendapatkan token");
}

if (!empty($tokenData->error)) {
    exit($tokenData->error);
}

if (!empty($tokenData->access_token)) {
    $infoUser = getUser($tokenData->access_token);

    if ($infoUser === false) {
        exit("Gagal mendapatkan informasi User");
    }

    $_SESSION["login"] = $infoUser->name;

    // Cek apakah email diterima dari API GitHub
    $email = isset($infoUser->email) ? $infoUser->email : 'default@gmail.com'; // Ganti dengan email default kalau email kosong

    // Kalau user menggunakan email default karena emailnya kosong maka, tambahkan nomor acak untuk pembeda
    if ($email === 'default@gmail.com') {
        $email = 'default_' . uniqid() . '@gmail.com';
    }

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$db", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Cek User sudah ada / belum ada di database
        $queryPeriksaUser = "SELECT * FROM user WHERE name = :name OR email = :email OR token_id = :token_id";
        $pernyataanPeriksaUser = $pdo->prepare($queryPeriksaUser);
        $pernyataanPeriksaUser->bindParam(':name', $infoUser->name, PDO::PARAM_STR);
        $pernyataanPeriksaUser->bindParam(':email', $email, PDO::PARAM_STR);
        $pernyataanPeriksaUser->bindParam(':token_id', $infoUser->id, PDO::PARAM_STR);
        $pernyataanPeriksaUser->execute();

        $UserSudahAda = $pernyataanPeriksaUser->fetch(PDO::FETCH_ASSOC);

        if ($UserSudahAda) {
            // Kalau user sudah terdaftar maka langsung arahkan ke halaman welcome.php
            $user_id = $_SESSION["user_id"] = $UserSudahAda["id"];
            $_SESSION["login"] = $UserSudahAda["name"];
            $_SESSION["login_type"] = ($UserSudahAda["type"] == 1) ? "admin_login" : "login";
            setcookie('fp_hotel_access_token', $tokenData->access_token, time() + 2592000, "/", "", false, true);

            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Login berhasil!",
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "welcome.php";
            });
            </script>';
            exit();
        }

        // Kalau user belum ada, masukkan data user ke database
        $hashedPassword = password_hash($infoUser->name, PASSWORD_DEFAULT);

        $queryInsertUser = "INSERT INTO user (name, email, password, verifiedEmail, token, token_id)
                          VALUES (:name, :email, :password, 1, :token, :token_id)";
        $stmtInsertUser = $pdo->prepare($queryInsertUser);
        $stmtInsertUser->bindParam(':name', $infoUser->name, PDO::PARAM_STR);
        $stmtInsertUser->bindParam(':email', $email, PDO::PARAM_STR);
        $stmtInsertUser->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmtInsertUser->bindParam(':token', $tokenData->access_token, PDO::PARAM_STR);
        $stmtInsertUser->bindParam(':token_id', $infoUser->id, PDO::PARAM_INT);
        $stmtInsertUser->execute();

        $newUserId = $pdo->lastInsertId();
        $user_id = $_SESSION["user_id"] = $newUserId;

        echo '<script>
        Swal.fire({
            icon: "success",
            title: "Login berhasil!",
            showConfirmButton: false,
            timer: 1500
        }).then(function() {
            window.location.href = "welcome.php";
        });
        </script>';
        exit();
    } catch (PDOException $e) {
        exit("Gagal menyimpan data User ke dalam database: " . $e->getMessage());
    }
}
?>