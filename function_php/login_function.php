<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</html>
<?php
session_start();
require_once "connection/conn.php";
require_once "mail.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (isset($_SESSION["login"]) || isset($_COOKIE["fp_hotel_access_token"])) {
    header("Location: welcome.php");
    exit;
}

if (isset($_SESSION["TFA"]["code"])) {
    header("Location: TFA.php");
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
    exit;
}

if (isset($_SESSION["email_verification_telat"]["email"])) {
    header("Location: email_verification_telat.php");
    exit;
}

function kirim_email($email)
{
    global $con;

    $expire = time() + (60 * 1);
    $code = rand(10000, 99999);
    $email = mysqli_real_escape_string($con, $email);

    $query = "INSERT INTO codes (email, code, expire) VALUES ('$email', '$code', '$expire')";
    mysqli_query($con, $query);
    
    $kirimEmail = send_mail($email, 'Two Factor Authentication', "
    <div style='text-align: center;'>
        <p>Kode OTP 2FA Anda adalah:</p>
        <strong style='font-size: 30px;'>$code</strong>
        <p>Kode ini hanya berlaku selama 1 menit. Jangan berikan kode ini kepada siapa pun!</p>
    </div>
    ");

    return $code;
}

if (isset($_POST["submit"])) {
    $error = [];

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error[] = "Email tidak valid!";
    }

    $email = mysqli_real_escape_string($con, $email);

    if (!empty($email) && !empty($password)) {
        $select = "SELECT * FROM user WHERE email = ?";
        $stmt = mysqli_prepare($con, $select);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        $hasil = mysqli_stmt_get_result($stmt);

        if (mysqli_num_rows($hasil) > 0) {
            $row = mysqli_fetch_assoc($hasil);

            // Check 2FA status
            if ($row["2FA"] == 1) {
                $verification_code = kirim_email($email);
                $_SESSION["TFA"]["email"] = $email;
                $_SESSION["TFA"]["code"] = $verification_code;
                header("Location: TFA.php?email=" . urlencode($email));
                exit();
            }

            // Kalau checkbox remember me di check
            if (isset($_POST['remember-me']) && $_POST['remember-me'] == 'on') {
                $email_cookie = mysqli_real_escape_string($con, $email);
                $password_cookie = mysqli_real_escape_string($con, $password);

                setcookie('email', $email_cookie, time() + (86400 * 30), "/");
                setcookie('password', $password_cookie, time() + (86400 * 30), "/");
            } else {
                // Kalau checkbox remember me tidak di check
                if (!isset($_SESSION["remember-me"]) || $_SESSION["remember-me"] !== true) {
                    setcookie('password', '', time() - 3600, "/");
                    setcookie('email', '', time() - 3600, "/");
                }
            }
            if ($row["verifiedEmail"] == 0) {
                $error[] = "Email belum diverifikasi! Silahkan verifikasi";
            } else {
                if (!password_verify($password, $row["password"])) {
                    $error[] = "Password salah!";
                } else {
                    $nama_pengguna = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                    $_SESSION["login"] = $nama_pengguna;
                    $user_id = $_SESSION["user_id"] = $row['id'];

                    if ($row["type"] == 1) {
                        $_SESSION["login_type"] = "admin_login";
                    } else {
                        $_SESSION["login_type"] = "login";
                    }

                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Login berhasil!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = "./welcome.php";
                    });
                    </script>';
                    exit();
                }
            }
        } else {
            $error[] = "Email salah atau belum terdaftar!";
        }
    }
}
?>