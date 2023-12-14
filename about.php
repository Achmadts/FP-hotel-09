<?php
session_start();
require_once 'connection/conn.php';
require_once 'vendor/autoload.php';
require_once "connection/google_config.php";
header("Content-Security-Policy: frame-ancestors 'none';");
header("X-Frame-Options: DENY");

if (!isset($_SESSION["login"])) {
    header('Location: index.php');
    exit;
}

if (isset($_SESSION["email_verification"]["code"])) {
    header("Location: email_verification.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="css/about.css" />
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark mb-4" data-bs-theme="dark">
        <div class="container">
            <a href="#"><img src="./assets/img/WhatsApp_Image_2023-09-05_at_15.02.25-removebg-preview.png.png" alt="Logo" width="26" height="25" class="d-inline-block align-text-top m-2 mt-3 mb-3"></a>
            <a class="navbar-brand" href="#">Hotel PPLG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="about.php">About</a>
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
                <form action="./logout.php" onsubmit="return confirmLogout();" class="ms-2 mb-0">
                    <button class="btn btn-outline-primary justify-content-center align-items-center" type="submit"><i class="bi bi-box-arrow-left" style="display: inline-block; margin-top: 1px;"></i> Logout</button>
                </form>
            </div>
        </div>
    </nav>
    <section class="section">
        <div class="row">
            <h1 data-aos="fade-up">Fountaine Team</h1>
        </div>
        <div class="row" style="display: flex; justify-content: center; align-items: center;">
            <div class="column" data-aos="fade-down" data-aos-duration="500" data-aos-delay="0">
                <div class="card">
                    <div class="img-container">
                        <img src="assets/img/logo_pplg.png" alt="Achmad Tirto Sudiro" />
                    </div>
                    <h3>Achmad Tirto Sudiro</h3>
                    <p>Mentor</p>
                    <div class="icons">
                        <a href="https://api.whatsapp.com/send?phone=62895320316384&text=Hai%20Achmad%20Tirto%20Sudiro%20Ganteng%20😘">
                            <span class="icon"><i class="fab fa-whatsapp"></i></span>
                        </a>
                        <a href="https://www.instagram.com/achmadtirtosudiro/">
                            <span class="icon"><i class="fab fa-instagram"></i></span>
                        </a>
                        <a href="https://github.com/Achmadts">
                            <span class="icon"><i class="fab fa-github"></i></span>
                        </a>
                        <a href="mailto:achmadtirtosudirosudiro@gmail.com">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <!-- Column 1-->
            <div class="column" data-aos="fade-up">
                <div class="card">
                    <div class="img-container">
                        <img src="assets/img/logo_pplg.png" alt="Martasya" />
                    </div>
                    <h3>Martasya</h3>
                    <p>Team</p>
                    <div class="icons">
                        <a href="#">
                            <span class="icon"><i class="fab fa-tiktok"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fab fa-instagram"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fab fa-github"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column 2-->
            <div class="column" data-aos="fade-up" data-aos-duration="500" data-aos-delay="0">
                <div class="card">
                    <div class="img-container">
                        <img src="assets/img/logo_pplg.png" alt="Fitria Rahmadani" />
                    </div>
                    <h3>Fitria Rahmadani</h3>
                    <p>Team Lead</p>
                    <div class="icons">
                        <a href="#">
                            <span class="icon"><i class="fab fa-tiktok"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fab fa-instagram"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fab fa-github"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                        </a>
                    </div>
                </div>
            </div>
            <!-- Column 3-->
            <div class="column" data-aos="fade-up">
                <div class="card">
                    <div class="img-container">
                        <img src="assets/img/logo_pplg.png" alt="Wulan Sari" />
                    </div>
                    <h3>Wulan Sari</h3>
                    <p>Team</p>
                    <div class="icons">
                        <a href="#">
                            <span class="icon"><i class="fab fa-tiktok"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fab fa-instagram"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fab fa-github"></i></span>
                        </a>
                        <a href="#">
                            <span class="icon"><i class="fas fa-envelope"></i></span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <footer class="text-center mt-4 p-1">
        <div class="container">
            <div class="row justify-content-center align-items-center text-center">
                <div class="col-md-6" style="width: 221px;">
                    <p class="fw-bold mt-3">fountaine project &COPY; 2023</p>
                </div>
                <div class="col-md-6" style="width: 41px; margin-top: 2px;">
                    <a href="https://www.instagram.com/rpl2_59/?igshid=OGQ5ZDc2ODk2ZA%3D%3D"><img src="assets/img/logo_pplg.png" width="41" height="40" alt="PPLG"></a>
                </div>
            </div>
        </div>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1500,
            delay: 150,
            once: true,
        });
    </script>
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