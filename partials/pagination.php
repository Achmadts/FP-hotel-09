<div class="pagination-container">
    <nav aria-label="Page navigation example">
        <ul class="pagination justify-content-center">
            <?php if ($halaman > 1) { ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halaman - 1 ?>">&laquo;</a></li>
            <?php } ?>
            <?php for ($i = 1; $i <= $totalHalaman; $i++) { ?>
                <li class="page-item <?= ($halaman == $i) ? 'active' : "" ?>"><a class="page-link" href="?halaman=<?= $i ?>"><?= $i ?></a></li>
            <?php } ?>
            <?php if ($halaman < $totalHalaman) { ?>
                <li class="page-item"><a class="page-link" href="?halaman=<?= $halaman + 1 ?>">&raquo;</a></li>
            <?php } ?>
        </ul>
    </nav>
</div>