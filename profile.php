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
$errorPw = array();

$id = $_SESSION["user_id"];

// Ambil data user diluar blok switch
$query = "SELECT * FROM user WHERE id = ?";
$stmt = mysqli_prepare($con, $query);

mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (!$result) {
    echo "Query gagal: " . mysqli_error($con);
}

if ($result && $row = mysqli_fetch_assoc($result)) {
    $id = $row["id"];
    $name = $row["name"];
    $email = $row["email"];
} else {
    echo "Gagal mengambil data dari database: " . mysqli_error($con);
}

function editUser($data)
{
    $error = array();
    $errorPw = array();

    // validasi
    if (!preg_match('/^[a-zA-Z\s]+$/', $data["name"])) {
        $error[] = "Nama harus berupa huruf";
    }

    if (!filter_var($data["email"], FILTER_VALIDATE_EMAIL)) {
        $error[] = "Masukkan email yang valid";
    }
    return $error;
}

$mode = isset($_POST["submit_general"]) ? 'submit_general' : (isset($_POST["submit_password"]) ? 'submit_password' : '');
$tabAktif = ($mode === 'submit_password') ? 'account-change-password' : 'account-general';

switch ($mode) {
    case 'submit_general':
        $error = [];
        $name = htmlspecialchars(mysqli_real_escape_string($con, $_POST["name"]));
        $email = htmlspecialchars(mysqli_real_escape_string($con, $_POST["email"]));
        $verifiedEmail = 0;

        // Ambil data lama pengguna dari database
        $query = "SELECT name, email, verifiedEmail, 2FA FROM user WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, 'i', $row["id"]);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && $dataLama = mysqli_fetch_assoc($result)) {
            // Cek email atau nama yang baru udah ada di database/belum
            if ($name !== $dataLama['name']) {
                $checkNameQuery = "SELECT id FROM user WHERE name = ?";
                $checkNameStmt = mysqli_prepare($con, $checkNameQuery);
                mysqli_stmt_bind_param($checkNameStmt, 's', $name);
                mysqli_stmt_execute($checkNameStmt);
                $checkNameResult = mysqli_stmt_get_result($checkNameStmt);
                if (mysqli_num_rows($checkNameResult) > 0) {
                    $error[] = "Nama sudah ada!";
                }
            }

            if ($email !== $dataLama['email']) {
                $checkEmailQuery = "SELECT id FROM user WHERE email = ?";
                $checkEmailStmt = mysqli_prepare($con, $checkEmailQuery);
                mysqli_stmt_bind_param($checkEmailStmt, 's', $email);
                mysqli_stmt_execute($checkEmailStmt);
                $checkEmailResult = mysqli_stmt_get_result($checkEmailStmt);
                if (mysqli_num_rows($checkEmailResult) > 0) {
                    $error[] = "Email sudah ada!";
                }
            }

            if ($email === $dataLama['email']) {
                $verifiedEmail = $dataLama['verifiedEmail'];
            }
        }

        $errorsFromValidation = editUser($_POST);
        $error = array_merge($error, $errorsFromValidation);

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
        break;

    case 'submit_password':
        $errorPw = [];
        $pwLama = isset($_POST["pwLama"]) ? htmlspecialchars(mysqli_real_escape_string($con, $_POST["pwLama"])) : "";
        $pwBaru = isset($_POST["pwBaru"]) ? htmlspecialchars(mysqli_real_escape_string($con, $_POST["pwBaru"])) : "";
        $ulangPwBaru = isset($_POST["ulangPwBaru"]) ? htmlspecialchars(mysqli_real_escape_string($con, $_POST["ulangPwBaru"])) : "";

        if ($pwBaru !== $ulangPwBaru) {
            $errorPw[] = "Kata sandi baru tidak sama dengan pengulangan.";
        }

        if (strlen($pwBaru) < 6) {
            $errorPw[] = "Password minimal harus 6 karakter.";
        }

        $queryCekPassword = "SELECT password FROM user WHERE id = ?";
        $stmtCekPassword = mysqli_prepare($con, $queryCekPassword);
        mysqli_stmt_bind_param($stmtCekPassword, 'i', $id);
        mysqli_stmt_execute($stmtCekPassword);
        $resultCekPassword = mysqli_stmt_get_result($stmtCekPassword);

        if ($resultCekPassword && $rowCheckPassword = mysqli_fetch_assoc($resultCekPassword)) {
            $hashedpwLama = $rowCheckPassword['password'];

            if (!password_verify($pwLama, $hashedpwLama)) {
                $errorPw[] = "Kata sandi lama salah.";
            }
        }

        if (empty($errorPw)) {
            // Perbarui pw
            $hashedpwBaru = password_hash($pwBaru, PASSWORD_DEFAULT);

            $queryUpdatePassword = "UPDATE user SET password = ? WHERE id = ?";
            $stmtUpdatePassword = mysqli_prepare($con, $queryUpdatePassword);
            mysqli_stmt_bind_param($stmtUpdatePassword, 'si', $hashedpwBaru, $id);
            mysqli_stmt_execute($stmtUpdatePassword);

            if (mysqli_stmt_affected_rows($stmtUpdatePassword) < 0) {
                echo "Password gagal diubah!: " . mysqli_error($con);
            } else {
                echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Password berhasil diperbarui!",
                        showConfirmButton: false,
                        timer: 1500
                    }).then(function() {
                        window.location.href = "profile.php";
                    });
                    </script>';
                exit;
            }
        }
        break;
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
        <h4 class="font-weight-bold py-3 mb-4 mt-3">
            <i class="bi bi-gear"></i> Account settings
        </h4>
        <div class="card overflow-hidden">
            <div class="row no-gutters row-bordered row-border-light">
                <div class="col-md-3 pt-0">
                    <div class="list-group list-group-flush account-settings-links">
                        <a class="list-group-item list-group-item-action <?= ($tabAktif === 'account-general') ? 'active' : ''; ?>" data-toggle="list" href="#account-general">General</a>
                        <a class="list-group-item list-group-item-action <?= ($tabAktif === 'account-change-password') ? 'active' : ''; ?>" data-toggle="list" href="#account-change-password">Change Password</a>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="tab-content">
                        <div class="tab-pane fade <?= ($tabAktif === 'account-general') ? 'show active' : ''; ?>" id="account-general">
                            <form action="" method="POST">
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
                                        <input type="text" name="name" class="form-control" value="<?= $name; ?>" autocomplete="off" placeholder="Nama" required>
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Email</label>
                                        <input type="email" name="email" class="form-control mb-1" value="<?= $email; ?>" autocomplete="off" placeholder="Email" required>
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
                                <div class="text-end mt-3 me-2">
                                    <button type="submit" name="submit_general" class="btn btn-primary">Save changes</button>
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade <?= ($tabAktif === 'account-change-password') ? 'show active' : ''; ?>" id="account-change-password">
                            <form action="" method="POST">
                                <div class="card-body pb-2">
                                    <?php
                                    if (!empty($errorPw)) {
                                        foreach ($errorPw as $err) {
                                            echo '<div class="alert alert-danger mt-3">' . htmlspecialchars($err) . '</div>';
                                        }
                                    }
                                    ?>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Password lama</label>
                                        <input type="password" name="pwLama" id="pw_lama" class="form-control" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Password baru</label>
                                        <input type="password" name="pwBaru" class="form-control" id="pw_baru" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="form-label">Ulangi password baru</label>
                                        <div class="input-group">
                                            <input type="password" name="ulangPwBaru" class="form-control pb-2" id="ulang_pw_baru" required>
                                            <span class="input-group-text" style="cursor: pointer;">
                                                <i class="bi bi-eye" id="icon"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-end mt-3 me-2">
                                    <button type="submit" name="submit_password" class="btn btn-primary">Save changes</button>
                                    <button type="reset" class="btn btn-warning">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
    <script>
        const pwLama = document.getElementById('pw_lama');
        const pwBaru = document.getElementById('pw_baru');
        const ulangPwBaru = document.getElementById('ulang_pw_baru');
        const icon = document.getElementById('icon');

        showHidePassword = () => {
            if (pwLama.type == "password" || pwBaru.type == "password" || ulangPwBaru.type == "password") {
                pwLama.setAttribute('type', 'text');
                pwBaru.setAttribute('type', 'text');
                ulangPwBaru.setAttribute('type', 'text');
            } else {
                pwLama.setAttribute('type', 'password');
                pwBaru.setAttribute('type', 'password');
                ulangPwBaru.setAttribute('type', 'password');
            }
            icon.classList.toggle('bi-eye');
            icon.classList.toggle('bi-eye-slash');
        };
        icon.addEventListener('click', showHidePassword);
    </script>
</body>

</html>