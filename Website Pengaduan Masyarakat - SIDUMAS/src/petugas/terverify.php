<?php

$title = 'Laporan Terverifikasi';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navPetugas.php';

$posisi = $_SESSION['posisi'];

$searchQuery = isset($_GET['search']) ? $_GET['search'] : '';

if ($searchQuery) {
    $stmt = $conn->prepare("SELECT * FROM pengaduan WHERE status = 'proses' AND disposisi = ? AND nik LIKE ? ORDER BY id_pengaduan DESC");
    $likeSearchQuery = '%' . $searchQuery . '%';
    $stmt->bind_param('ss', $posisi, $likeSearchQuery);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = mysqli_query($conn, "SELECT * FROM pengaduan WHERE status = 'proses' AND disposisi = '$posisi' ORDER BY id_pengaduan DESC");
}
?>

<div class="row" data-aos="fade-up">
  <div class="col-6">
    <h3 class="text-gray-800">Daftar Laporan Yang Sudah Terverifikasi</h3>
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
      <th scope="col">action</th>
    </tr>
  </thead>
  <tbody>
    <?php $no = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <th scope="row"><?= $no++; ?></th>
        <td><?= $row["tgl_pengaduan"]; ?></td>
        <td><?= $row["nik"]; ?></td>
        <td><?= $row["isi_laporan"]; ?></td>
        <td>
          <?php if ($row['foto']): ?>
            <img src="../../uploads/<?= $row['foto']; ?>" alt="Foto Laporan" class="report-img" width="50">
          <?php endif; ?>
        </td>
        <td><a href="tanggapi.php?id_pengaduan=<?= $row["id_pengaduan"]; ?>" class="btn btn-outline-success">Tanggapi</a></td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>

<!-- Modal HTML -->
<div id="myModal" class="modal">
  <span class="close">&times;</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
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

#caption {
  margin: auto;
  display: block;
  width: 80%;
  max-width: 700px;
  text-align: center;
  color: #ccc;
  padding: 10px 0;
  height: 150px;
}

.modal-content, #caption {
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
var modal = document.getElementById("myModal");
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");

document.querySelectorAll('.report-img').forEach(img => {
  img.onclick = function() {
    modal.style.display = "block";
    modalImg.src = this.src;
    captionText.innerHTML = this.alt;
  }
});

var span = document.getElementsByClassName("close")[0];
span.onclick = function() {
  modal.style.display = "none";
}
</script>
