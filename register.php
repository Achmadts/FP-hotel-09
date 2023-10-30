<?php
session_start();
require_once "connection/conn.php";
require_once "function_php/register_function.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Register</title>

    <style>
        h1 {
            font-size: 30px;
            margin-top: 10px;
            margin-bottom: 10px;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <div class="form-container"style="width: 350px;">
            <h1>Register</h1>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo '<span class="error-msg" style="color:red; font-size: 100%;">' . $error . '</span>';
                    echo '<br><br>';
                };
            };
            ?>
            <div class="form-floating mt-4">
                <input type="text" class="form-control w-100" name="name" required placeholder="Masukkan nama kamu" autocomplete="off">
                <label for="nama">Masukkan nama anda</label>
            </div>

            <div class="form-floating mt-3">
                <input type="email" class="form-control w-100" name="email" required placeholder="Masukkan email kamu" autocomplete="off">
                <label for="email">Masukkan email</label>
            </div>

            <div class="form-floating mt-3">
                <input type="password" class="form-control w-100" id="pw" name="password" required placeholder="Masukkan password">
                <label for="password">Masukkan password</label>
            </div>

            <div class="form-floating mt-3">
                <input type="password" class="form-control w-100" id="cpw" name="cpassword" required placeholder="Konfirmasi password" style="margin-bottom: -5px;">
                <label for="cpassword">Masukkan konfirmasi password</label>
            </div>

            <div class="checkbox-container mt-3">
                <input type="checkbox" id="chk">
                <label for="checkbox">Show Password</label>
            </div>

            <input type="submit" class="btn btn-primary mb-2" name="submit" value="Daftar sekarang!"><br>
            <p>Sudah memiliki akun? <a href="login.php">Login sekarang!</a></p>
    </form>
    </div>
    <script>
        const pw = document.getElementById("pw");
        const cpw = document.getElementById("cpw");
        const chk = document.getElementById("chk");

        chk.onchange = function() {
            pw.type = chk.checked ? "text" : "password";
            cpw.type = chk.checked ? "text" : "password";
        }
    </script>
</body>

</html>