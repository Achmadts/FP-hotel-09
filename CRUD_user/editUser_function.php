<?php
$id = $_GET['editid'];
$query = "SELECT * FROM user WHERE id=?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$result) {
    die('Error: ' . mysqli_error($con));
}

$name = $row["name"];
$email = $row["email"];
$password = $row["password"];
$cpassword = $row["password"];


if (!isset($_SESSION["login"])) {
    header("Location: ../login.php");
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

    if (mysqli_num_rows($result) > 1) {
        $error[] = 'Pengguna sudah ada!';
    } else {
        if ($password !== $cpassword) {
            $error[] = 'Password tidak sesuai!';
        } else {
            $pass = password_hash($password, PASSWORD_DEFAULT);
            $update_query = "UPDATE user SET name=?, email=?, password=? WHERE id=?";
            $update_stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($update_stmt, "sssi", $name, $email, $password, $id);
            mysqli_stmt_execute($update_stmt);

            if (mysqli_stmt_affected_rows($update_stmt) < 0) {
                echo "Terjadi kesalahan dalam perbaruan data: " . mysqli_error($con);
            } else {
                echo '<script>alert("Data berhasil diperbarui"); window.location.href = "../user_list.php";</script>';
            }
        }
    }
}
?>