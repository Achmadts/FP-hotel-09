<?php
if (isset($_SESSION["login"])) {
    header("Location: welcome.php");
    exit;
};

if (isset($_POST["submit"])) {
    $error = [];

    $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

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
            echo '<script>alert("Registrasi berhasil"); window.location.href = "login.php";</script>';
        }
    }
}
?>