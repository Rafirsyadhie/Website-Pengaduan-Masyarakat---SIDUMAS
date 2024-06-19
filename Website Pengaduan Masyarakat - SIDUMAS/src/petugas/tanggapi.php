<?php

$title = 'Tanggapan';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navPetugas.php';

$id = $_GET["id_pengaduan"];
$result = mysqli_query($conn, "SELECT * FROM pengaduan WHERE id_pengaduan = $id");

if (isset($_POST["submit"])) {
    if (tanggapan($_POST) > 0) {
        $sukses = true;
    } else {
        $error = true;
    }
}

?>

<div class="d-flex justify-content-center">
    <div class="card w-75 shadow">
        <div class="card-body">
            <?php if (isset($sukses)) : ?>
                <div class="alert alert-dismissible fade show" data-aos="zoom-in" style="background-color: #3bb849;" role="alert">
                    <h6 class="text-gray-100 mt-2">Berhasil menanggapi, Terima kasih sudah menanggapi aduan masyarakat </h6>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if (isset($error)) : ?>
                <div class="alert alert-dismissible fade show" data-aos="zoom-in" style="background-color: #f64e60;" role="alert">
                    <h6 class="text-gray-100 mt-2">Gagal menanggapi aduan, pastikan Anda sudah didisposisikan untuk aduan ini.</h6>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="text-light">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <form method="post">
                <div class="form-group">
                    <label for="tgl_tanggapan">Tanggal Tanggapan</label>
                    <input type="date" class="form-control" id="tgl_tanggapan" name="tgl_tanggapan" required>
                </div>
                <div class="form-group">
                    <label for="tanggapan">Tanggapan</label>
                    <textarea class="form-control" id="tanggapan" name="tanggapan" rows="3" required></textarea>
                </div>
                <input type="hidden" name="id_pengaduan" value="<?php echo $id; ?>">
                <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php
require '../layouts/footer.php';
?>
