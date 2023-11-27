<?php
session_start();
require_once "../connection/conn.php";
require_once "tambahUser_function.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = tambahUser($con, $_POST,);

    if (count($error) == 0) {
        header("Location: ../user_list.php");
        die;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <title>Tambah User</title>

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
        <div class="form-container" style="width: 350px;">
            <h1>Tambah User</h1>
            <?php
            if (isset($error)) {
                foreach ($error as $error) {
                    echo "<div class='error-msg' style='background-color: #ffe3e5; text-align: center; min-height: 40px; border-radius: 5px;'>";
                    echo '<span class="error-msg" style="color: #851923; font-size: 90%; margin-top: 7px; display: inline-block;">' . $error . '</span>';
                    echo "</div><br>";
                };
            };
            ?>
            <div class="form-floating mt-4">
                <input type="text" class="form-control w-100" name="name" required placeholder="Masukkan nama kamu" autocomplete="off" value="<?= (isset($_POST["submit"])) ? $name : ""; ?>">
                <label for="nama">Masukkan nama user</label>
            </div>

            <div class="form-floating mt-3">
                <input type="email" class="form-control w-100" name="email" required placeholder="Masukkan email kamu" autocomplete="off" value="<?= (isset($_POST["submit"])) ? $email : ""; ?>">
                <label for="email">Masukkan email user</label>
            </div>

            <div class="form-floating mt-3">
                <input type="password" class="form-control w-100" id="pw" name="password" required placeholder="Masukkan password" value="<?= (isset($_POST["submit"])) ? $password : ""; ?>">
                <label for="password">Masukkan password</label>
            </div>

            <div class="form-floating mt-3 position-relative">
                <input type="password" class="form-control w-100" id="cpw" name="cpassword" required placeholder="Konfirmasi password" style="margin-bottom: -5px;" value="<?= (isset($_POST["submit"])) ? $password : ""; ?>">
                <label for="cpassword">Masukkan konfirmasi password</label>
                <span style="right: 20px; top: 50%; transform: translateY(-45%); cursor: pointer; position: absolute; font-size: 20px;">
                    <i class="bi bi-eye" id="icon"></i>
                </span>
            </div><br>

            <input type="submit" class="btn btn-primary mb-2 mt-3" name="submit" value="Tambah!"><br>
    </form>
    </div>
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