<?php
require_once "connection/conn.php";
require_once "connection/google_config.php";
require_once "function_php/login_function.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Login</title>

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

        .text-center a {
            transition: .5s;
        }

        .text-center a {
            transition: .5s;
        }

        #login {
            transition: .5s;
        }
    </style>
</head>

<body>
    <form action="" method="POST" data-aos="flip-right" data-aos-duration="1100" data-aos-delay="100">
        <div class="container" style="width: 330px;">
            <h2>Login</h2>
            <div class="justify-content-center align-items-center my-1">
                <div class="row">
                    <div class="col-md-12 my-1"> <!-- ubah ke col-md-6 kalau mau displit / di flex -->
                        <div class="text-center">
                            <a href='<?php echo $client->createAuthUrl(); ?>' class='btn btn-outline-primary d-grid gap-1 p-3' style="font-size: 15px;"><i class='bi bi-google'></i></a>
                        </div>
                    </div>
                    <!-- <div class="col-md-4 my-1">
                        <div class="text-center">
                            <a href='#' class='btn btn-outline-primary d-grid gap-1 p-3' style="font-size: 15px;"><i class='bi bi-twitter'></i></a>
                        </div>
                    </div>
                    <div class="col-md-4 my-1">
                        <div class="text-center">
                            <a href='#' class='btn btn-outline-primary d-grid gap-1 p-3' style="font-size: 15px;"><i class='bi bi-facebook'></i></a>
                        </div>
                    </div> -->
                </div>
            </div>
            <div class="d-flex">
                <hr width="50%" class="me-1" style="margin-top: 13px;">OR
                <hr width="50%" class="ms-1" style="margin-top: 13px;">
            </div>
            <?php
            if (!empty($error)) {
                if (!is_null($hasil) && mysqli_num_rows($hasil) > 0) {
                    $row = mysqli_fetch_assoc($hasil);
                    foreach ($error as $err) {
                        echo "<div class='error-msg' style='background-color: #ffe3e5; border: 1px solid #851923; min-height: 40px; height: fit-content; border-radius: 5px;'>";
                        $tombolEmailVerification = isset($row["verifiedEmail"]) == 0 && $err === "Email belum diverifikasi! Silahkan verifikasi";
                        echo '<span class="error-msg" style="font-size: 90%; color: #851923; display: inline-block; margin-top: 7px;">' . htmlspecialchars($err) . '</span>';
                        if ($tombolEmailVerification) {
                            echo ' <a href="email_verification_telat.php" style="text-decoration: none; margin-top: 7px;"> disini</a>';
                        }
                        echo "<br>";
                        echo "</div>";
                    }
                } else {
                    foreach ($error as $err) {
                        echo "<div class='error-msg' style='background-color: #ffe3e5; text-align: center; min-height: 40px; border-radius: 5px;'>";
                        echo '<span class="error-msg" style="font-size: 90%; color: #851923; display: inline-block; margin-top: 7px;">' . htmlspecialchars($err) . '</span>';
                        echo "<br>";
                        echo "</div>";
                    }
                }
            }
            ?>
            <div class="form-floating mt-4">
                <input type="email" class="form-control w-100" name="email" required placeholder="Masukkan email kamu" value="<?= isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : '' ?>" autocomplete="off">
                <label for="email">Email</label>
            </div>


            <div class="form-floating mt-3 position-relative">
                <input type="password" class="form-control w-100" name="password" required id="pw" placeholder="Masukkan password kamu" value="<?= isset($_COOKIE['password']) ? htmlspecialchars($_COOKIE['password']) : '' ?>" autocomplete="off">
                <label for="password">password</label>
                <span style="right: 20px; top: 50%; transform: translateY(-45%); cursor: pointer; position: absolute; font-size: 20px;">
                    <i class="bi bi-eye" id="icon"></i>
                </span>
            </div>

            <div class="checkbox-container mb-4">
                <input type="checkbox" style="cursor: pointer;" id="rememeber_me" name="remember-me" value="on" <?= (isset($_COOKIE['email'])) ? "checked" : ""; ?>>
                <label for="rememeber_me" style="font-size: 13px; cursor: pointer;">Remember me</label><br>
                <a href="lupa_password.php" style="text-decoration: none; margin-left: 88px; font-size: 13px;">Lupa password?</a>
            </div>

            <input type="submit" class="btn btn-primary mb-3" name="submit" value="Login" id="login">
            <p>Belum memiliki akun? <a href="register.php" style="text-decoration: none;">Daftar sekarang!</a></p>
        </div>
    </form>

    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true,
        });
    </script>

    <script>
        const password = document.getElementById('pw');
        const icon = document.getElementById('icon');

        showHidePassword = () => {
            if (password.type == "password") {
                password.setAttribute('type', 'text');
            } else {
                password.setAttribute('type', 'password');
            }
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        };
        icon.addEventListener('click', showHidePassword);
    </script>
</body>

</html>