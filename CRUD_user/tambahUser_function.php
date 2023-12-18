<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
<?php

if (!isset($_SESSION["login"]) && !isset($_SESSION["login_type"]) || $_SESSION["login_type"] !== "admin_login") {
    header('Location: ../index.php');
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: ../email_verification.php");
    exit;
}

if (isset($_SESSION["TFA"]["code"])) {
    header("Location: ../TFA.php");
    exit;
}

function tambahUser($con, $data)
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

if (isset($_POST["submit"])) {
    $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $error = tambahUser($con, $_POST);

    // Cek apakah terdapat kesalahan
    if (empty($error)) {
        $select = "SELECT * FROM user WHERE email = '$email' || name = '$name' ";
        $result = mysqli_query($con, $select);

        if (mysqli_num_rows($result) > 0) {
            $error[] = 'Pengguna sudah ada!';
        } else {
            if ($password !== $cpassword) {
                $error[] = 'Password tidak sesuai!';
            } else {
                $pass = password_hash($password, PASSWORD_DEFAULT);
                $insert = "INSERT INTO user(name, email, password) VALUES('$name','$email','$pass')";
                mysqli_query($con, $insert);
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "User berhasil ditambahkan",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = "../user_list.php";
                    });
                    </script>';
                exit;
            }
        }
    }
}
?>