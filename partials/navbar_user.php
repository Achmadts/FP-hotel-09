<?php
$cari = isset($_GET["cari"]) ? htmlspecialchars($_GET["cari"]) : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
        <div class="container-fluid">
            <a href="#"><img src="./assets/img/WhatsApp_Image_2023-09-05_at_15.02.25-removebg-preview.png.png" alt="Logo" width="26" height="25" class="d-inline-block align-text-top mx-2 mb-4 mt-1"></a>
            <a class="navbar-brand mb-3" href="#">Hotel PPLG</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item mb-3">
                        <a class="nav-link" aria-current="page" href="welcome.php">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item active" href="user_list.php">Data User</a></li>
                            <li><a class="dropdown-item" href="list.php">Data Pengunjung</a></li>
                        </ul>
                    </li>
                </ul>
                <form class="d-flex" role="search" method="GET">
                    <input class="form-control me-2" type="search" value="<?= isset($cari) ? $cari : ''; ?>" id="search" name="cari" autocomplete="off" placeholder="Search" aria-label="Search">
                </form>
                <!-- <a href="./logout.php" class="btn btn-outline-primary justify-content-center align-items-center mb-4" type="submit"><i class="bi bi-box-arrow-left" style="display: inline-block; margin-top: 1px;"></i> Logout</a> -->
                <form action="./logout.php" onsubmit="return confirmLogout();">
                    <button class="btn btn-outline-primary justify-content-center align-items-center" type="submit"><i class="bi bi-box-arrow-left" style="display: inline-block; margin-top: 1px;"></i> Logout</button>
                </form>
                <a href="https://www.instagram.com/rpl2_59/?igshid=OGQ5ZDc2ODk2ZA%3D%3D"><img src="./assets/img/logo_pplg.png" width="41" height="40" class="mb-3 ms-5 me-5 justify-content-center align-items-center" style="margin-top: -5px;"></a>
            </div>
        </div>
    </nav>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
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