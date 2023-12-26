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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <title>Room Details</title>

    <style>
        #carouselExample {
            width: 640px;
            margin: 0.5rem 0rem 3rem 0rem;
        }

        .container h1 {
            margin: 3rem 0rem 0rem 0rem;
        }

        nav {
            margin: 0rem 0rem 0rem 0rem;
        }

        @media (max-width: 900px) {
            .container #carouselExample .carousel-item img {
                width: 90%;
                height: 100%;
                margin-right: auto;
            }

            .row .col-md-6 {
                margin-bottom: 30px;
            }
        }


        @media (max-width: 600px) {
            #carouselExample .carousel-item img {
                width: 100% !important;
                height: 100% !important;
                margin: auto !important;
            }

            .row .col-md-6 {
                margin-bottom: 30px;
            }

            .row {
                margin-bottom: 30px;
                background-color: #f3f4f6;
            }
        }
    </style>
</head>

<body>
    <?php
    $no_kamar = $_GET['no_kamar'] ?? null;

    if ($no_kamar) {
        $query = "SELECT k.*, t.harga_kamar, t.kapasitas_pengunjung, t.rating FROM kamar k
              INNER JOIN type_kamar t ON k.type_kamar = t.type_kamar
              WHERE k.no_kamar = '$no_kamar'";

        $result = mysqli_query($con, $query);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);

            echo '<div class="container">';
            echo '<h1>' . $row['type_kamar'] . ' Room</h1>';
        }
    }
    ?>
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb mt-3 mb-4">
            <li class="breadcrumb-item"><a href="welcome.php" class="text-decoration-none text-dark">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Details</li>
        </ol>
    </nav>
    <div class="row">
        <div id="carouselExample" class="col-md-6">
            <div class="carousel slide">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <?php echo '<img src="' . $row['foto_kamar'] . '" alt="foto kamar" height="383,8" class="d-block w-100 rounded"/>'; ?>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mt-2">
                <div class="card-body">
                    <?php echo '<h5 class="card-title">Rp. ' . number_format($row['harga_kamar']) . '<p style="margin-top: 10px; font-size: 13px;">Permalam</p></h5>'; ?>

                    <?php
                    for ($i = 0; $i < $row['rating']; $i++) {
                        echo '<i class="bi bi-star-fill text-warning me-1"></i>';
                    }
                    ?>

                    <p style="margin-bottom: 15px; margin-top: 20px;">Fasilitas</p>
                    <?php $fasilitas = explode(',', $row['fasilitas_kamar']);
                    foreach ($fasilitas as $fasilitas_item) {
                        echo '<b class="me-2" style="background-color: #f3f4f6; font-size: 12px; padding: 5px 5px 5px 5px; border-radius: 5px;">' . $fasilitas_item . '</b>';
                    }
                    ?>

                    <p style="margin-top: 1.4rem;">Kapasitas tamu</p>
                    <div class="d-flex">
                        <?php echo '<b class="me-2" style="background-color: #f3f4f6; font-size: 12px; padding: 6px 7px 5px 7px; border-radius: 5px;">' . $row['kapasitas_pengunjung'] . ' orang dewasa</b>'; ?>
                        <p class="mx-2 my-1">atau</p>
                        <?php echo '<b class="ms-2" style="background-color: #f3f4f6; font-size: 12px; padding: 6px 7px 5px 7px; border-radius: 5px;">' . $row['kapasitas_pengunjung'] . ' orang anak</b>'; ?>
                    </div><br>

                    <?php echo '<a href="checkout.php?no_kamar=' . $row['no_kamar'] . '" class="btn btn-primary w-100 mt-3" style="padding-bottom: 10px;">Booking</a>'; ?>
                </div>
            </div>
        </div>
    </div>
    <h4>Deskripsi</h4>
    <p class="mb-5">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Necessitatibus, ullam quasi temporibus facere doloremque, excepturi nobis aliquam dolores similique, quaerat sit quis ea a ipsam enim? Rerum quas eligendi optio nobis temporibus illum officia culpa, vel quibusdam consequatur, architecto cumque esse eaque tempora unde perferendis assumenda fuga? Voluptates, modi excepturi? Aut blanditiis corrupti quae doloribus unde non voluptatum eaque quia, eum odio velit porro aliquid fuga. Beatae, atque adipisci nihil doloremque quo molestias ea veniam nulla molestiae aliquid dolore odit vel amet debitis rerum velit? Delectus rerum distinctio illum ratione saepe veritatis labore pariatur, nisi ipsum amet at adipisci assumenda.</p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>