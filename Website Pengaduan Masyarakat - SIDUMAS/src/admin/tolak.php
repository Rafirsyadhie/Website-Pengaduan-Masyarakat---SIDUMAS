<?php
$title = 'Tolak Laporan';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navAdmin.php';

if (isset($_GET['id_pengaduan'])) {
    $id_pengaduan = $_GET['id_pengaduan'];

    $deleteQuery = "DELETE FROM pengaduan WHERE id_pengaduan = $id_pengaduan";
    if (mysqli_query($conn, $deleteQuery)) {
        $sukses = true;
    } else {
        $error = "Gagal menghapus laporan.";
    }
} else {
    header('Location: index.php');
    exit;
}
?>

<?php if (isset($sukses)) : ?>
    <div class="d-flex justify-content-center py-5 mt-5">
        <div class="card shadow bg-success">
            <div class="card-body">
                <h4 class="text-center text-light">Laporan berhasil ditolak!</h4>
                <hr>
                <img src="../../assets/img/sukses.svg" width="250" alt="" data-aos="zoom-in" data-aos-duration="700">
                <div class="button mt-3">
                    <a href="laporan.php" class="btn btn-primary text-light shadow">OK!</a>
                </div>
            </div>
        </div>
    </div>
<?php elseif (isset($error)) : ?>
    <div class="d-flex justify-content-center py-5 mt-5">
        <div class="card shadow bg-danger">
            <div class="card-body">
                <h4 class="text-center text-light"><?= $error; ?></h4>
                <hr>
                <div class="button mt-3">
                    <a href="index.php" class="btn btn-primary text-light shadow">OK!</a>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php require '../layouts/footer.php'; ?>
