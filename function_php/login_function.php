<?php
if (isset($_SESSION["login"])) {
    header("Location: welcome.php");
    exit;
}

if (isset($_POST["submit"])) {
    $error = [];

    $email = $_POST["email"];
    $password = $_POST["password"];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $error[] = "Format email tidak valid!";
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

            if (!password_verify($password, $row["password"])) {
                $error[] = "Password salah!";
            } else {
                $nama_pengguna = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
                $_SESSION["login"] = $nama_pengguna;
                header("Location: welcome.php");
                exit();
            }
        } else {
            $error[] = "Email salah atau belum terdaftar!";
        }
    }
}