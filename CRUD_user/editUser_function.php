<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>
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

if (!isset($_SESSION["login"]) && !isset($_SESSION["login_type"]) || $_SESSION["login_type"] !== "admin_login") {
    header('Location: ../index.php');
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: ../email_verification.php");
    exit;
}

function editUser($data)
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
    return $error;
}

if (isset($_POST["submit"])) {
    $error = [];

    $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST['name']));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST['email']));
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];

    $error = editUser($_POST);

    // Cek apakah terdapat kesalahan
    if (empty($error)) {
        $select = "SELECT * FROM user WHERE email = '$email' OR name = '$name' ";

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
                mysqli_stmt_bind_param($update_stmt, "sssi", $name, $email, $pass, $id);
                mysqli_stmt_execute($update_stmt);

                if (mysqli_stmt_affected_rows($update_stmt) < 0) {
                    echo "Data user gagal diedit: " . mysqli_error($con);
                } else {
                    echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Data berhasil diperbarui",
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
}
?>