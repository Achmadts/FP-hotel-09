<?php
session_start();
require_once "../connection/conn.php";
require_once "editUser_function.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

$error = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $error = editUser($_POST);

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
    <title>Edit data user</title>

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
            <h1>Edit user</h1>
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
                <input type="text" class="form-control w-100" name="name" value="<?= $name; ?>" required placeholder="Masukkan nama kamu" autocomplete="off">
                <label for="nama">Masukkan nama anda</label>
            </div>

            <div class="form-floating mt-3">
                <input type="email" class="form-control w-100" name="email" value="<?= $email; ?>" required placeholder="Masukkan email kamu" autocomplete="off">
                <label for="email">Masukkan email</label>
            </div>
            <div class="form-check form-switch mt-3 mb-4">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" style="cursor: pointer;" name="btnType" <?php echo ($row['type'] == 1) ? 'checked' : ''; ?>>
                <label class="form-check-label" style="margin-right: 20rem; cursor: pointer;" for="flexSwitchCheckChecked">Admin</label>
            </div>
            <input type="submit" class="btn btn-primary mb-2" name="submit" value="Ubah!"><br>
    </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>

</html>