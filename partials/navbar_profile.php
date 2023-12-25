<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">

<nav class="navbar navbar-expand-lg bg-dark" data-bs-theme="dark">
    <div class="container">
        <a href="#"><img src="./assets/img/WhatsApp_Image_2023-09-05_at_15.02.25-removebg-preview.png.png" alt="Logo" width="26" height="25" class="d-inline-block align-text-top m-2 mt-3 mb-3"></a>
        <a class="navbar-brand ms-2" href="#">Hotel PPLG</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="welcome.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="about.php">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="pesanan.php">Pesanan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Data (Hanya Admin)
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="user_list.php">Data User (Hanya Admin)</a></li>
                        <li><a class="dropdown-item" href="list.php">Data Pengunjung (Hanya Admin)</a></li>
                    </ul>
                </li>
            </ul>
            <p class="text-light my-3 me-4"><?= isset($_SESSION["userinfo"]) ? $_SESSION["userinfo"]["name"] : $_SESSION["login"]; ?></p>
            <form action="./logout.php" onsubmit="return confirmLogout();">
                <button class="btn btn-outline-primary justify-content-center align-items-center" type="submit" style="margin-bottom: -15px;"><i class="bi bi-box-arrow-left" style="display: inline-block; margin-top: 1px;"></i> Logout</button>
            </form>
        </div>
    </div>
</nav>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>