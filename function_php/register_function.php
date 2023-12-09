<?php
session_start();
require_once "connection/conn.php";
require_once "mail.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["email_verification"]) || !is_array($_SESSION["email_verification"])) {
    $_SESSION["email_verification"] = array();
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
    exit;
}

if (isset($_SESSION["login"]) || isset($_COOKIE["fp_hotel_access_token"])) {
    header("Location: welcome.php");
    exit;
}

function register($con, $data)
{
    $error = array();

    // validasi
    if (!preg_match('/^[a-zA-Z\s]+$/', $data["name"])) {
        $error[] = "Nama harus berupa huruf";
    }

    if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $error[] = "Masukkan email yang valid";
    }

    if (strlen(trim($data["password"])) < 6) {
        $error[] = "Password minimal harus 6 karakter";
    }

    if ($data["password"] !== $data["cpassword"]) {
        $error[] = "Password tidak sesuai!";
    }

    // cek pengguna sudah ada/belum di db
    $name = htmlspecialchars(mysqli_real_escape_string($con, $data['name']));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $data['email']));

    $select = "SELECT * FROM user WHERE email = '$email' OR name = '$name' ";
    $result = mysqli_query($con, $select);

    if (mysqli_num_rows($result) > 0) {
        $error[] = 'Pengguna sudah ada!';
    }

    return $error;
}
function kirim_email($email)
{
    global $con;

    $expire = time() + (60 * 1);
    $code = rand(10000, 99999);
    $email = mysqli_real_escape_string($con, $email);

    $query = "INSERT INTO codes (email, code, expire) VALUES ('$email', '$code', '$expire')";
    mysqli_query($con, $query);
    $kirimEmail = send_mail($email, 'Verifikasi Email',
        "<div style='text-align: center;'>
            <p>Kode verifikasi email Anda adalah:</p>
            <strong style='font-size: 30px;'>$code</strong>
            <p>Kode ini hanya berlaku selama 1 menit. Jangan berikan kode ini kepada siapa pun!</p>
        </div>
    ");

    return $code;
}

if (isset($_POST["submit"])) {
    $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
    $password = $_POST['password'];

    $error = register($con, $_POST);

    if (empty($error)) {
        $select = "SELECT * FROM user WHERE email = '$email' OR name = '$name' ";
        $result = mysqli_query($con, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'Pengguna sudah ada!';
        } else {
            // Simpan data kalau gak ada error
            $password = $_POST['password'];
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $insert = "INSERT INTO user(name, email, password) VALUES('$name','$email','$pass')";
            mysqli_query($con, $insert);

            $verification_code = kirim_email($email);

            $_SESSION["email_verification"]["email"] = $email;
            $_SESSION["email_verification"]["code"] = $verification_code;

            header("Location: email_verification.php?email=" . urlencode($email));
            exit();
        }
    }
    return $error;
}
