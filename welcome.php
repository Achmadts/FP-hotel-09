<?php
session_start();
require_once 'connection/conn.php';
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"])) {
    header('Location: login.php');
    exit;
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="welcome.css">
    <title>Welcome</title>
    <style>
        /* button {
            background-color: #0074d9;
            color: #fff;
            padding: 10px 20px;
            margin: 3px;
            border: none;
            cursor: pointer;
            box-shadow: 0px 0px 10px rgba(0, 0, 0.1);
            display: inline;
            border-radius: 5px;
        } */

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

<body>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container">
            <a href="#"><img src="WhatsApp_Image_2023-09-05_at_15.02.25-removebg-preview.png.png" alt="Logo" width="26" height="25" class="d-inline-block align-text-top m-2 mt-3 mb-3"></a>
            <a class="navbar-brand" href="#">Hotel PPLG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="user_list.php">Data User</a></li>
                            <li><a class="dropdown-item" href="list.php">Data Pengunjung</a></li>
                        </ul>
                    </li>
                </ul>
                <a href="https://www.instagram.com/neskar.story/"><img src="WhatsApp_Image_2023-09-05_at_15.02.31-removebg-preview.png.png" width="41" height="40" class="me-0"></a>
            </div>
        </div>
    </nav>
    <center>
        <div class="container1 justify-content-center align-items-center" style="margin-top: 30vh;">
            <h1>Selamat Datang <span style="background: #0074d9; color: #fff; border-radius: 5px; padding: 0 10px;"><?php echo $_SESSION["login"] ?></span> di Hotel PPLG!</h1>
            <p>Tempat Kenyamanan dan Keramahan Berpadu😊.</p>
            <div class="row mt-2" style="width: 135px;">
                <div class="col-6">
                    <a href="input.php"><button class="btn btn-primary">Input</button></a>
                </div>
                <div class="col-6">
                    <form action="logout.php" onsubmit="return confirmLogout();">
                        <input type="submit" class="btn btn-primary" value="Logout">
                    </form>
                </div>
            </div>
        </div>
    </center>
    <footer class="p-1 text-center" style="margin-top: 32.3vh;">
        <p class="fw-bold mt-3">fountaine project &COPY; 2023</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
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

</html>