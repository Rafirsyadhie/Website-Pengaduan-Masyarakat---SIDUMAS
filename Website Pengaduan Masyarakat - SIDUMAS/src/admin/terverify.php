<?php

$title = 'Laporan Terverifikasi';

require '../../public/app.php';

require '../layouts/header.php';

require '../layouts/navAdmin.php';

$result = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = 'proses' ORDER BY id_pengaduan DESC");

?>

<div class="row" data-aos="fade-up">
  <div class="col-6">
    <h3 class="text-gray-800">Daftar Laporan Yang sudah terverifikasi</h3>
  </div>
</div>

<hr>

<table class="table table-bordered shadow-sm text-center" data-aos="fade-up" data-aos-duration="700">
  <thead class="thead-dark">
    <tr class="text-center">
      <th scope="col">No</th>
      <th scope="col">Tanggal</th>
      <th scope="col">NIK</th>
      <th scope="col">Isi Laporan</th>
      <th scope="col">Foto</th>
      <th scope="col">Disposisi</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <th scope="row"><?= $i; ?>.</th>
        <td><?= $row["tgl_pengaduan"]; ?></td>
        <td><?= $row["nik"]; ?></td>
        <td><?= $row["isi_laporan"]; ?></td>
        <td>
          <?php if ($row['foto']): ?>
            <img class="report-img" src="../../uploads/<?= $row['foto']; ?>" alt="Foto Laporan" width="50" onclick="showImageModal('<?= $row['foto']; ?>')">
          <?php endif; ?>
        </td>
        <td><?= $row["disposisi"]; ?></td>
      </tr>
      <?php $i++; ?>
    <?php endwhile; ?>
  </tbody>
</table>

<div id="imageModal" class="modal">
  <span class="close" onclick="closeImageModal()">&times;</span>
  <img class="modal-content" id="img01">
</div>

<?php require '../layouts/footer.php'; ?>

<style>
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgb(0,0,0);
  background-color: rgba(0,0,0,0.9);
}

.modal-content {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
}

.modal-content { 
  animation-name: zoom;
  animation-duration: 0.6s;
}

@keyframes zoom {
  from {transform:scale(0)} 
  to {transform:scale(1)}
}

.close {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #f1f1f1;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close:hover,
.close:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
</style>

<script>
function showImageModal(imageSrc) {
  var modal = document.getElementById("imageModal");
  var modalImg = document.getElementById("img01");
  modal.style.display = "block";
  modalImg.src = "../../uploads/" + imageSrc;
}

function closeImageModal() {
  var modal = document.getElementById("imageModal");
  modal.style.display = "none";
}
</script>
