<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

if (!isset($_SESSION['timer'])) {
    unset($_SESSION['timer']);
}

$error = array();
$mode = "enter_email";

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

if (count($_POST) > 0) {
    if ($mode == 'enter_email') {
        $email = $_POST["email"];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error[] = "Tolong masukkan email yang valid";
        } elseif (!valid_email($email)) {
            $error[] = "Email tidak terdaftar!";
        } elseif (is_email_verified($email)) {
            $error[] = "Email sudah diverifikasi silahkan";
        } else {
            $_SESSION["email_verification_telat"]["email"] = $email;
            kirim_email($email);
            header("Location: email_verification_telat.php?mode=enter_code");
            die;
        }
    } elseif ($mode == 'enter_code') {
        $code = $_POST["code"];
        $email = $_SESSION["email_verification_telat"]["email"];
        $result = kode_benar($code, $email);

        if ($result == "Kode OTP benar") {
            $_SESSION["email_verification"]["code"] = $code;
            $_SESSION["email_verification"]["email"] = $email;
            $_SESSION["timer"] = time() + 60;

            // Ubah verifiedEmail jadi '1' di tabel 'user'
            $updateQuery = "UPDATE user SET verifiedEmail = 1 WHERE email = ?";
            $stmt = mysqli_prepare($con, $updateQuery);
            mysqli_stmt_bind_param($stmt, 's', $email);
            mysqli_stmt_execute($stmt);

            session_unset();
            session_destroy();
            $_SESSION = [];
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Email berhasil diverifikasi!",
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "index.php";
            });
            </script>';
            exit();
        } else {
            $error[] = $result;
        }
    }
}


if (isset($_SESSION['timer']) && $_SESSION['timer'] <= time()) {
    unset($_SESSION['timer']);
} elseif (!isset($_SESSION['timer'])) {
    $_SESSION['timer'] = time() + 60;
}

function is_email_verified($email)
{
    global $con;

    $email = addslashes($email);

    $query = "SELECT verifiedEmail FROM user WHERE email= '$email' LIMIT 1 ";
    $result = mysqli_query($con, $query);
    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row["verifiedEmail"] == 1;
    }
    return false;
}

function kirim_email($email)
{
    global $con;

    $expire = time() + (60 * 1);
    $code = rand(10000, 99999);
    $email = addslashes($email);

    $query = "INSERT INTO codes (email, code, expire) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'ssi', $email, $code, $expire);
    $result = mysqli_stmt_execute($stmt);

    $kirimEmail = send_mail(
        $email,
        'Verifikasi Email',
        "<div style='text-align: center;'>
            <p>Kode verifikasi email Anda adalah:</p>
            <strong style='font-size: 30px;'>$code</strong>
            <p>Kode ini hanya berlaku selama 1 menit. Jangan berikan kode ini kepada siapa pun!</p>
        </div>
    "
    );
}

function valid_email($email)
{
    global $con;

    $email = addslashes($email);

    $query = "SELECT * FROM user WHERE email = ? LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            return true;
        }
    }
    return false;
}
function kode_benar($code)
{
    global $con;

    $code = addslashes($code);
    $expire = time();
    $email = addslashes($_SESSION["email_verification_telat"]["email"]);

    $query = "SELECT * FROM codes WHERE code = ? AND email = ? ORDER BY id DESC LIMIT 1";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $code, $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            if ($row["expire"] > $expire) {
                return "Kode OTP benar";
            } else {
                return "Kode OTP sudah kadaluarsa!";
            }
        } else {
            return "Kode OTP salah";
        }
    }
    return "Kode OTP salah";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/login.css">
    <title>Email Verification</title>

    <style>
        h2 {
            font-size: 24px;
        }

        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            height: fit-content;
        }
    </style>
</head>

<body>

    <script>
        function startTimer() {
            <?php
            $serverTime = time();
            $sessionTimer = isset($_SESSION['timer']) ? $_SESSION['timer'] : 0;
            $countdown = max(0, $sessionTimer - $serverTime);
            $timerExpired = isset($_SESSION['timer_expired']) && $_SESSION['timer_expired'];
            ?>
            var countdown = <?php echo $countdown; ?>;
            var timerDisplay = document.getElementById("timer");

            if (countdown <= 0 || <?php echo $timerExpired ? 'true' : 'false'; ?>) {
                timerDisplay.textContent = "Waktu Habis";
            } else {
                var timer = setInterval(function() {
                    if (countdown <= 0) {
                        clearInterval(timer);
                        timerDisplay.textContent = "Waktu Habis";
                        // Simpan status waktu habis di session
                        <?php $_SESSION['timer_expired'] = true; ?>;
                    } else {
                        timerDisplay.textContent = countdown + " detik";
                        countdown--;
                    }
                }, 1000);
            }
        }

        window.onload = startTimer;

        // Hapus status waktu habis dari session ketika membuat permintaan waktu baru
        document.getElementById("timerForm").addEventListener("submit", function() {
            <?php $_SESSION['timer_expired'] = false; ?>;
        });
    </script>

    <?php
    switch ($mode) {
        case 'enter_email':
            # code...
    ?>
            <form action="email_verification_telat.php?mode=enter_email" method="POST">
                <div class="container">
                    <h2>Email Verification</h2>
                    <h6>Masukkan email kamu</h6>
                    <div class="error-msg">
                        <?php
                        if (!empty($error)) {
                            foreach ($error as $err) {
                                echo "<div class='error-msg' style='background-color: #ffe3e5; border: 1px solid #851923; min-height: 40px; height: fit-content; border-radius: 5px;'>";
                                echo '<span class="error-msg ms-1" style="font-size: 90%; color: #851923; display: inline-block; margin-top: 7px;">' . htmlspecialchars($err) . '</span>';
                                if ($err === "Email sudah diverifikasi silahkan") {
                                    echo ' <a href="index.php" class="me-1" style="text-decoration: none; margin-top: 7px;"> Login!</a>';
                                }
                                echo "<br>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="form-floating mt-4">
                        <input type="email" class="form-control w-100" name="email" required placeholder="Masukkan email kamu" autocomplete="off">
                        <label for="email">Email</label>
                    </div>
                    <input type="submit" class="btn btn-primary mb-2 mt-3" name="submit" value="Next">
                    <p><a href="index.php" style="text-decoration: none;">Login</a></p>
                </div>
            </form>
        <?php
            break;

        case 'enter_code':
            # code...
        ?>
            <form action="email_verification_telat.php?mode=enter_code" method="POST">
                <div class="container" style="width: 80%;">
                    <h2>Email Verification</h2>
                    <h6 style="font-size: 90%;">Masukkan kode OTP yang dikirim ke <?php echo $_SESSION['email_verification_telat']['email']; ?></h6>
                    <div class="error-msg">
                        <?php
                        if (!empty($error)) {
                            foreach ($error as $err) {
                                echo "<div class='error-msg' style='background-color: #ffe3e5; border: 1px solid #851923; text-align: center; min-height: 40px; border-radius: 5px;'>";
                                echo '<span class="error-msg" style="font-size: 90%; color: #851923; display: inline-block; margin-top: 7px;">' . htmlspecialchars($err) . '</span>';
                                echo "<br>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>

                    <div style="text-align: right; display: block; margin-bottom: -10px;">
                        <span id="timer" style="font-size: 90%;"></span>
                    </div>

                    <div class="form-floating mt-2">
                        <input type="text" class="form-control w-100" name="code" required placeholder="Masukkan kode OTP" autocomplete="off">
                        <label for="code">Code</label>
                    </div>

                    <input type="submit" class="btn btn-primary mb-1 mt-3 w-100" name="submit" value="Next">
                    <a href="email_verification_telat.php">
                        <input type="button" class="btn btn-primary mb-2 w-100" name="submit" value="Mulai lagi">
                    </a>
                    <p><a href="index.php" style="text-decoration: none;">Login</a></p>
                </div>
            </form>
    <?php
            break;
        default:
            # code...
            break;
    }
    ?>
</body>

</html>