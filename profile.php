<html lang="en">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</html>

<?php
session_start();
require_once 'connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"]) && !isset($_COOKIE["fp_hotel_access_token"])) {
    header("Location: index.php");
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
    exit;
}

if (isset($_SESSION["TFA"]["code"])) {
    header("Location: TFA.php");
    exit;
}

$error = array();

$id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = editUser($_POST);
}

$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo "Error executing query: " . mysqli_error($con);
}

if ($result && $row = mysqli_fetch_assoc($result)) {
    $id = $row["id"];
    $name = $row["name"];
    $email = $row["email"];
} else {
    echo "Error fetching data from database: " . mysqli_error($con);
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
    return $error;
}

if (isset($_POST["submit"])) {
    $error = [];

    $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST["name"]));
    $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST["email"]));
    $verifiedEmail = 0;

    // Ambil data user dari database sebelumnya
    $query = "SELECT name, email, verifiedEmail, 2FA FROM user WHERE id = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, 'i', $row["id"]);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && $dataLama = mysqli_fetch_assoc($result)) {
        // Cek alamat email baru sama/sama dengan yang ada di database
        if ($email === $dataLama['email']) {
            $verifiedEmail = $dataLama['verifiedEmail'];
        }
    }

    $error = editUser($_POST);

    if (empty($error)) {
        $id = $row["id"];

        // Cek tombol Autentikasi 2 faktor diaktifkan/tidak
        $btn2FAAktif = isset($_POST["btnTFA"]) ? 1 : 0;

        $update = "UPDATE user SET name=?, email=?, 2FA=?, verifiedEmail=? WHERE id=?";
        $stmt = mysqli_prepare($con, $update);

        mysqli_stmt_bind_param($stmt, 'ssiii', $name, $email, $btn2FAAktif, $verifiedEmail, $id);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) < 0) {
            echo "Data user gagal diedit: " . mysqli_error($con);
        } else {
            echo '<script>
            Swal.fire({
                icon: "success",
                title: "Data berhasil diperbarui!",
                showConfirmButton: false,
                timer: 1500
            }).then(function() {
                window.location.href = "profile.php";
            });
            </script>';
            exit;
        }
    }
}

// echo "<pre>";
// var_dump($_SESSION);
// var_dump($_COOKIE);
// var_dump($name);
// echo "</pre>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="css/profile.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
        footer {
            background-color: #333;
            color: #fff;
            text-align: center;
            padding: 10px;
            font-size: 16.5px;
            width: 100%;
        }
    </style>
</head>

<body style="display: flex; flex-direction: column; min-height: 100vh;">
    <?php include "partials/navbar_profile.php"; ?>
    <div class="container light-style flex-grow-1 container-p-y">
        <form action="" method="POST">
            <h4 class="font-weight-bold py-3 mb-4 mt-3">
                Account settings
            </h4>
            <div class="card overflow-hidden">
                <div class="row no-gutters row-bordered row-border-light">
                    <div class="col-md-3 pt-0">
                        <div class="list-group list-group-flush account-settings-links">
                            <a class="list-group-item list-group-item-action active" data-toggle="list" href="#account-general">General</a>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="tab-content">
                            <div class="tab-pane fade show active" id="account-general">
                                <div class="card-body">
                                    <?php
                                    if (!empty($error)) {
                                        foreach ($error as $err) {
                                            echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($err) . '</div>';
                                        }
                                    }
                                    ?>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Nama</label>
                                        <input type="text" name="name" class="form-control" value="<?= $name; ?>" autocomplete="off" placeholder="Nama">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control mb-1" value="<?= $email; ?>" autocomplete="off" placeholder="Email">
                                        <?php
                                        if ($row["verifiedEmail"] == 0) {
                                            echo '
                                                <div class="alert alert-warning mt-3">
                                                    Silahkan verifikasi ulang email kamu<br>
                                                    <a href="profile_email_verification.php" style="text-decoration: none;">disini</a>
                                                </div>';
                                        }
                                        ?>
                                    </div>
                                    <div class="form-check form-switch mt-3">
                                        <label class="form-check-label user-select-none" for="flexSwitchCheckChecked" style="cursor: pointer;">Autentikasi Dua Faktor</label>
                                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" style="cursor: pointer;" name="btnTFA" <?php echo ($row['2FA'] == 1) ? 'checked' : ''; ?>>
                                    </div>
                                    <b><small class="text-danger" style="font-size: x-small; margin-left: 40px;">Hanya untuk login menggunakan Email!</small></b>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-end mt-3">
                <button type="submit" name="submit" class="btn btn-primary">Save changes</button>
                <button type="reset" class="btn btn-warning">Reset</button>
            </div>
        </form>
    </div>
    <footer class="p-1 text-center">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-md-6" style="width: 221px;">
                    <p class="fw-bold mt-3">fountaine project &COPY; 2023</p>
                </div>
                <div class="col-md-6" style="width: 41px; margin-top: 2px;">
                    <a href="https://www.instagram.com/rpl2_59/?igshid=OGQ5ZDc2ODk2ZA%3D%3D"><img src="assets/img/logo_pplg.png" width="41" height="40"></a>
                </div>
            </div>
        </div>
    </footer>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript"></script>

    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Yakin mau logout?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "logout.php";
                }
            });
            return false;
        }
    </script>
</body>

</html>