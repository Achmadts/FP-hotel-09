<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
<?php
session_start();
require_once "connection/conn.php";
require_once "mail.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
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
    switch ($mode) {
        case 'enter_email':
            $email = $_POST["email"];
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error[] = "Tolong masukkan email yang valid";
            } elseif (!valid_email($email)) {
                $error[] = "Email tidak ditemukan!";
            } else {
                $_SESSION["lupa_pw"]["email"] = $email;
                kirim_email($email);
                header("Location: lupa_password.php?mode=enter_code");
                die;
            }
            break;

        case 'enter_code':
            # code...
            $code = $_POST["code"];
            $result = kode_benar($code);

            if ($result == "Kode OTP benar") {
                $_SESSION["lupa_pw"]["code"]  = $code;
                $_SESSION["timer"] = time() + 60;
                header("Location: lupa_password.php?mode=enter_password");
                die;
            } else {
                $error[] = $result;
            }
            break;
        case 'enter_password':
            # code...
            $password = $_POST["password"];
            $password2 = $_POST["password2"];

            if ($password !== $password2) {
                $error[] = "Password tidak sesuai!";
            } elseif (strlen(trim($password)) < 6) {
                $error[] = "Password minimal harus 6 karakter";
            } elseif (!isset($_SESSION["lupa_pw"]["email"]) || !isset($_SESSION["lupa_pw"]["code"])) {
                header("Location: lupa_password.php");
                die;
            } else {
                simpan_password($password);
                if (isset($_SESSION["lupa_pw"])) {
                    unset($_SESSION["lupa_pw"]);
                }
                echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Password berhasil diubah!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(function() {
                    window.location.href = "index.php";
                });
                </script>';
                exit();
            }
            break;

        default:
            # code...
            break;
    }
}

if (isset($_SESSION['timer']) && $_SESSION['timer'] <= time()) {
    unset($_SESSION['timer']);
} elseif (!isset($_SESSION['timer'])) {
    $_SESSION['timer'] = time() + 60;
}

function kirim_email($email)
{
    global $con;

    $expire = time() + (60 * 1);
    $code = rand(10000, 99999);
    $email = addslashes($email);

    $query = "INSERT INTO codes (email, code, expire) VALUE ('$email', '$code', '$expire')";
    mysqli_query($con, $query);

    $kirimEmail = send_mail($email, 'Reset Password',
        "<div style='text-align: center;'>
            <p>Kode anda adalah:</p>
            <strong style='font-size: 30px;'>$code</strong>
            <p>Kode ini hanya berlaku selama 1 menit. Jangan berikan kode ini kepada siapa pun!</p>
        </div>
    ");
}
function simpan_password($password)
{
    global $con;

    $password = password_hash($password, PASSWORD_DEFAULT);
    $email = addslashes($_SESSION["lupa_pw"]["email"]);

    $query = "UPDATE user SET password= '$password' WHERE email= '$email' LIMIT 1 ";
    mysqli_query($con, $query);
}
function valid_email($email)
{
    global $con;

    $email = addslashes($email);

    $query = "SELECT * FROM user WHERE email= '$email' LIMIT 1 ";
    $result = mysqli_query($con, $query);
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
    $email = addslashes($_SESSION["lupa_pw"]["email"]);

    $query = "SELECT * FROM codes  WHERE code = '$code' && email = '$email' ORDER BY id DESC LIMIT 1 ";
    $result = mysqli_query($con, $query);
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
    <title>Reset Password</title>

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
            <form action="lupa_password.php?mode=enter_email" method="POST">
                <div class="container">
                    <h2>Reset Password</h2>
                    <h6>Masukkan email kamu</h6>
                    <div class="error-msg">
                        <?php
                        if (!empty($error)) {
                            foreach ($error as $err) {
                                echo "<div class='error-msg' style='background-color: #ffe3e5; border: 1px solid #851923; text-align: center; min-height: 40px; border-radius: 5px;'>";
                                echo '<span class="error-msg" style="color: #851923; font-size: 90%; margin-top: 7px; display: inline-block;">' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</span>';
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
            <form action="lupa_password.php?mode=enter_code" method="POST">
                <div class="container" style="width: 80%;">
                    <h2>Reset Password</h2>
                    <h6 style="font-size: 90%;">Masukkan kode OTP yang dikirim ke <?php echo $_SESSION['lupa_pw']['email']; ?></h6>
                    <div class="error-msg">
                        <?php
                        if (!empty($error)) {
                            foreach ($error as $err) {
                                echo "<div class='error-msg' style='background-color: #ffe3e5; border: 1px solid #851923; text-align: center; min-height: 40px; border-radius: 5px; margin-bottom: 10px;'>";
                                echo '<span class="error-msg" style="color: #851923; font-size: 90%; margin-top: 7px; display: inline-block;">' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</span>';
                                echo "<br>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>

                    <div style="text-align: right; display: block; margin-bottom: 5px;">
                        <span id="timer" style="font-size: 90%;"></span>
                    </div>

                    <div class="form-floating mt-2">
                        <input type="text" class="form-control w-100" name="code" required placeholder="Masukkan kode OTP" autocomplete="off">
                        <label for="code">Code</label>
                    </div>

                    <input type="submit" class="btn btn-primary mb-1 mt-3 w-100" name="submit" value="Next">
                    <a href="lupa_password.php">
                        <input type="button" class="btn btn-primary mb-2 w-100" name="submit" value="Mulai lagi">
                    </a>
                    <p><a href="index.php" style="text-decoration: none;">Login</a></p>
                </div>
            </form>
        <?php
            break;
        case 'enter_password':
            # code...
        ?>
            <form action="lupa_password.php?mode=enter_password" method="POST">
                <div class="container" style="width: 100%;">
                    <h2>Reset Password</h2>
                    <h6>Masukkan password baru</h6>
                    <div class="error-msg">
                        <?php
                        if (!empty($error)) {
                            foreach ($error as $err) {
                                echo "<div class='error-msg' style='background-color: #ffe3e5; border: 1px solid #851923; text-align: center; min-width: 235px; width: fit-content; min-height: 40px; border-radius: 5px;'>";
                                echo '<span class="error-msg" style="color: #851923; font-size: 90%; margin-top: 7px; display: inline-block;">' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</span>';
                                echo "<br>";
                                echo "</div>";
                            }
                        }
                        ?>
                    </div>
                    <div class="form-floating mt-4">
                        <input type="password" id="pw" class="form-control w-100" name="password" required placeholder="Password" autocomplete="off">
                        <label for="password">Password</label>
                    </div>

                    <div class="form-floating mt-4">
                        <input type="password" id="cpw" class="form-control w-100" name="password2" required placeholder="Konfirmasi password baru" autocomplete="off">
                        <label for="password2">Konfirmasi Password</label>
                        <span style="right: 20px; top: 50%; transform: translateY(-45%); cursor: pointer; position: absolute; font-size: 20px;">
                            <i class="bi bi-eye" id="icon"></i>
                        </span>
                    </div>

                    <input type="submit" class="btn btn-primary mb-1 mt-3 w-100" name="submit" value="Next">
                    <!-- <a href="lupa_password.php">
                        <input type="button" class="btn btn-primary mb-2 w-100" name="submit" value="Kirim ulang">
                    </a> -->
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

    <script>
        const password = document.getElementById('pw');
        const cpassword = document.getElementById('cpw');
        const toggler = document.getElementById('icon');

        const showHidePassword = () => {
            if (password.type == "password" && cpassword.type == "password") {
                password.setAttribute('type', 'text');
                cpassword.setAttribute('type', 'text');
            } else {
                password.setAttribute('type', 'password');
                cpassword.setAttribute('type', 'password');
            }
            toggler.classList.toggle('bi-eye');
            toggler.classList.toggle('bi-eye-slash');
        };
        toggler.addEventListener('click', showHidePassword);
    </script>
</body>

</html>