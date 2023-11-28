<?php
require_once "connection/conn.php";

$limit = 2;
$halaman = isset($_GET["halaman"]) ? $_GET["halaman"] : 1;

if (isset($_POST["cari"])) {
    $cari = htmlspecialchars($_POST["cari"]);
    $query = "SELECT * FROM user WHERE name LIKE '%$cari%' OR email LIKE '%$cari%' OR token LIKE '%$cari%'";
} else {
    $query = "SELECT * FROM user";
}

$result = $con->query($query);

$totalBaris = $result->num_rows;
$totalHalaman = ceil($totalBaris / $limit);

$imbang = ($halaman - 1) * $limit;
$query = $query . " LIMIT $limit OFFSET $imbang";
$result = $con->query($query);

$i = ($halaman - 1) * $limit;
if ($result->num_rows > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $i++;
        echo "<tr class='border'>";
        echo "<td>" . $i . "</td>";
        echo "<td>" . $row['id'] . "</td>";
        echo "<td>" . $row['name'] . "</td>";
        echo "<td>" . $row['email'] . "</td>";
        echo "<td>" . $row['verifiedEmail'] . "</td>";
        echo "<td>" . $row['token'] . "</td>";
        echo '<div class="container">
    <td class="d-flex text-center justify-content-center align-items-center mb-4" style="border: none;">
        <a href="crud_pengunjung/edit.php?editid=' . $row["id"] . '" style="margin-bottom: -10px;" class="justify-content-center"><button class="btn btn-primary mx-2 mt-0"><i class="bi bi-pencil-square text-white"></i></button></a>
        <button class="btn btn-danger mx-2 mt-0 tombol-hapus" data-id="' . $row["id"] . '" style="margin-bottom: -30px;"><i class="bi bi-trash text-white"></i></button>
    </td>
</div>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>Tidak ada data pengunjung.</td></tr>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <script>
        document.querySelectorAll('.tombol-hapus').forEach(function(button) {
            button.addEventListener('click', function() {
                const itemId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Yakin mau hapus data ini?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'crud_user/hapus.php?hapusid=' + itemId;
                    }
                });
            });
        });
    </script>
</body>

</html>