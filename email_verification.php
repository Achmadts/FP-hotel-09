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

if (!isset($_SESSION["email_verification"]["code"])) {
    header("Location: index.php");
}

if (isset($_SESSION["TFA"]["code"])) {
    header("Location: TFA.php");
    exit;
}

if (!isset($_SESSION['email_verification'])) {
    $_SESSION['email_verification'] = array();
}

if (isset($_SESSION["login"]) || isset($_COOKIE["fp_hotel_access_token"])) {
    header("Location: welcome.php");
    exit;
}

if (!isset($_SESSION['timer'])) {
    unset($_SESSION['timer']);
}

$error = array();
$mode = "enter_code";

if (isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

$email = isset($_SESSION["email_verification"]["email"]) ? $_SESSION["email_verification"]["email"] : '';

if (!isset($_SESSION["email_verification"])) {
    $_SESSION["email_verification"] = array();
}

if (count($_POST) > 0) {
    if ($mode === 'enter_code') {
        $code = $_POST["code"];
        $result = kode_benar($code, $email);

        if ($result == "Kode OTP benar") {
            $_SESSION["email_verification"]["code"]  = $code;
            $_SESSION["email_verification"]["email"]  = $email;
            $_SESSION["timer"] = time() + 60;

            // Ubah verifiedEmail jadi '1' di tabel 'user'
            $email = $_SESSION["email_verification"]["email"];
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
                title: "Verifikasi email berhasil!",
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
        if (isset($_POST['kirimUlangKode'])) {
            global $con;

            $email = isset($_SESSION["email_verification"]["email"]) ? $_SESSION["email_verification"]["email"] : '';

            // Kirim ulang kode OTP verifikasi email
            $email = mysqli_real_escape_string($con, $email);
            $kodeBaru = rand(10000, 99999);
            $expire = time() + (60 * 1);
            $query = "INSERT INTO codes (email, code, expire) VALUES (?, ?, ?)";
            $stmt = mysqli_prepare($con, $query);
            mysqli_stmt_bind_param($stmt, 'ssi', $email, $kodeBaru, $expire);
            $result = mysqli_stmt_execute($stmt);

            $kirimEmail = send_mail($email, 'Verifikasi Email', "
            <div style='text-align: center;'>
                <p>Kode verifikasi email Anda adalah:</p>
                <strong style='font-size: 30px;'>$kodeBaru</strong>
                <p>Kode ini hanya berlaku selama 1 menit. Jangan berikan kode ini kepada siapa pun!</p>
            </div>
        ");

            $error = array_filter($error, function ($pesan) {
                return $pesan !== "Kode OTP salah!";
            });
            $error[] = "Kode verifikasi baru berhasil dikirim!";
        }
    }
}

if (isset($_SESSION['timer']) && $_SESSION['timer'] <= time()) {
    unset($_SESSION['timer']);
} elseif (!isset($_SESSION['timer'])) {
    $_SESSION['timer'] = time() + 60;
}

function kode_benar($code, $email)
{
    global $con;

    $code = mysqli_real_escape_string($con, $code);
    $expire = time();

    if (isset($_SESSION["email_verification"]["code"])) {
        $email = mysqli_real_escape_string($con, $email);

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
                return "Kode OTP salah!";
            }
        } else {
            return "Terjadi kesalahan pada query database";
        }
    }
    return "Terjadi kesalahan pada sesi verifikasi email";
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
    <?php
    switch ($mode) {
        case 'enter_code':
            # code...
    ?>
            <form action="" id="timerForm" method="POST">
                <div class="container" style="width: 100%;">
                    <h2>Email Verification</h2>
                    <h6 style="font-size: 90%; margin-bottom: 15px;">Masukkan kode OTP yang dikirim ke: <br> <?php echo isset($_SESSION['email_verification']['email']) ? htmlspecialchars($_SESSION['email_verification']['email']) : ''; ?></h6>
                    <div class="error-msg">
                        <?php
                        if (!empty($error)) {
                            foreach ($error as $err) {
                                $background_color = '#ffe3e5';
                                $text_color = '#851923';
                                $border_color = '#851923';

                                // Cek apakah pesan = "Kode verifikasi baru berhasil dikirim!"
                                $pesanKodeVerifikasiBaru = isset($_POST["kirimUlangKode"]) && $err === "Kode verifikasi baru berhasil dikirim!";
                                if ($pesanKodeVerifikasiBaru) {
                                    $background_color = '#D4EDDA';
                                    $text_color = '#40754C';
                                    $border_color = '#40754C';
                                }

                                echo "<div class='error-msg' style='background-color: $background_color; border: 1px solid $border_color; text-align: center; min-height: 40px; border-radius: 5px;'>";
                                echo '<span class="error-msg" style="font-size: 90%; color: ' . $text_color . '; display: inline-block; margin-top: 7px;">' . htmlspecialchars($pesanKodeVerifikasiBaru ? "Kode verifikasi baru berhasil dikirim!" : $err) . '</span>';
                                if ($pesanKodeVerifikasiBaru) {
                                    echo '<span class="error-msg" style="font-size: 90%; color: ' . $text_color . '; display: inline-block; margin-top: 7px;"></span>';
                                }
                                echo "</div>";
                                echo "<br>";
                            }
                        }
                        ?>

                    </div>

                    <div style="text-align: right; display: block; margin-bottom: -5px;">
                        <span id="timer" style="font-size: 90%;"></span>
                    </div>

                    <div class="form-floating mt-2">
                        <input type="text" class="form-control w-100" name="code" placeholder="Masukkan kode OTP" autocomplete="off">
                        <label for="code">Code</label>
                    </div>
                    <input type="submit" class="btn btn-primary mt-3 w-100" name="submit" value="Next">
                    <button type="submit" class="btn btn-primary mb-1 mt-1 w-100" id="resendCodeBtn" name="kirimUlangKode">Kirim Ulang Kode</button>
                </div>
            </form>
    <?php
            break;
            // ...
    }
    ?>
    <script>
        function disabledKirimUlangKode() {
            var button = document.getElementById('resendCodeBtn');
            button.disabled = true;

            setTimeout(function() {
                button.disabled = false;
            }, 60000); // 1 menit = 60000 milidetik
        }

        window.onload = function() {
            disabledKirimUlangKode();
        };
        document.getElementById('resendCodeBtn').addEventListener('click', disabledKirimUlangKode());
    </script>
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
</body>

</html>