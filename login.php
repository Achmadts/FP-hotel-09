<?php
session_start();
require_once "connection/conn.php";
require_once "function_php/login_function.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>

    <style>
        h2 {
            font-size: 24px;
        }
    </style>
</head>

<body>
    <form action="" method="POST">
        <div class="container">
            <h2>Login</h2>
            <div class="error-msg">
                <?php
                if (!empty($error)) {
                    foreach ($error as $err) {
                        echo '<span class="error-msg" style="font-size: 90%; color: red;">' . htmlspecialchars($err, ENT_QUOTES, 'UTF-8') . '</span>';
                        echo "<br><br>";
                    }
                }
                ?>
            </div>
            <div class="form-floating mt-4">
                <input type="email" class="form-control w-100" name="email" required placeholder="Masukkan email kamu" autocomplete="off">
                <label for="email">Email</label>
            </div>

            <div class="form-floating mt-3">
                <input type="password" class="form-control w-100" name="password" id="pw" required placeholder="Masukkan password kamu" autocomplete="off">
                <label for="password">password</label>
            </div>

            <div class="checkbox-container">
                <input type="checkbox" id="chk">
                <label for="checkbox">Show Password</label>
            </div>
            <input type="submit" class="btn btn-primary mb-2" name="submit" value="Login">
            <p>Belum memiliki akun? <a href="register.php" style="text-decoration: none;">Daftar sekarang!</a></p>
        </div>
    </form>
    <script>
        const pw = document.getElementById("pw");
        const chk = document.getElementById("chk");

        chk.onchange = function() {
            pw.type = chk.checked ? "text" : "password";
        };
    </script>
</body>

</html>