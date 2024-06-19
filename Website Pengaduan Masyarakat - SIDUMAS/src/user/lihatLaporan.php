<?php
$title = 'Laporan';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navUser.php';

if (!isset($_SESSION['nik'])) {
    header("Location: login.php");
    exit();
}

$nik = $_SESSION['nik'];

$query = "SELECT * FROM pengaduan WHERE nik = '{$nik}' ORDER BY id_pengaduan DESC";
$result = mysqli_query($conn, $query);
?>

<div class="row" data-aos="fade-up">
  <div class="col-6">
    <h3 class="text-gray-800">Daftar Laporan Saya</h3>
  </div>
  <div class="col-6 d-flex justify-content-end">
    <a href="buatLaporan.php" class="btn btn-primary btn-icon-split">
      <span class="icon text-white-50">
        <i class="fas fa-plus"></i>
      </span>
      <span class="text">Buat Laporan</span>
    </a>
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
      <th scope="col">Status</th>
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
            <img src="../../uploads/<?= $row['foto']; ?>" alt="Foto Laporan" class="report-img" width="150">
          <?php endif; ?>
        </td>
        <td>
          <?php if ($row["status"] == 'terkirim') : ?>
            <span class="badge badge-info">Terkirim</span>
          <?php elseif ($row["status"] == 'proses') : ?>
            <span class="badge badge-warning">Proses</span>
          <?php elseif ($row["status"] == 'selesai') : ?>
            <span class="badge badge-success">Selesai</span>
          <?php endif; ?>
        </td>
      </tr>
      <?php $i++; ?>
    <?php endwhile; ?>
  </tbody>
</table>

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

.badge {
  padding: 5px 10px;
  border-radius: 5px;
}

.badge-info {
  background-color: #17a2b8;
  color: white;
}

.badge-warning {
  background-color: #ffc107;
  color: black;
}

.badge-success {
  background-color: #28a745;
  color: white;
}

table {
  border-collapse: collapse;
  border: 5px solid black;
}

th, td {
  padding: 8px;
  border: 1px solid black;
}

tbody {
  padding-bottom: 10px;
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