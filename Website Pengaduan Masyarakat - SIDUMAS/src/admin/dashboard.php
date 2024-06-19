<?php

$title = 'Dashboard';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navAdmin.php';

$pengaduanCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan");
$tanggapanCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM tanggapan");
$masyarakatCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM masyarakat");

$pengaduanCount = mysqli_fetch_assoc($pengaduanCount)['total'];
$tanggapanCount = mysqli_fetch_assoc($tanggapanCount)['total'];
$masyarakatCount = mysqli_fetch_assoc($masyarakatCount)['total'];

$query = "SELECT * FROM ((tanggapan 
                          INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan)
                          INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas)
                          ORDER BY tanggapan.tgl_tanggapan DESC";
$result = mysqli_query($conn, $query);

?>

<div class="row mb-3">
  <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="300">
    <div class="card border-left-info shadow h-100 py-2">
      <div class="card-body d-flex flex-column">
        <div class="row no-gutters align-items-center flex-grow-1">
          <div class="col ml-3">
            <div class="h5 mb-0 font-weight-bold text-info"><?= $pengaduanCount; ?> Pengaduan</div>
          </div>
          <i class="fas fa-comment fa-2x text-gray-500 ml-auto"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="700">
    <div class="card border-left-primary shadow h-100 py-2">
      <div class="card-body d-flex flex-column">
        <div class="row no-gutters align-items-center flex-grow-1">
          <div class="col ml-3">
            <div class="h5 mb-0 font-weight-bold text-primary"><?= $tanggapanCount; ?> Tanggapan</div>
          </div>
          <i class="fas fa-comments fa-2x text-gray-500 ml-auto"></i>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="700">
    <div class="card border-left-dark shadow h-100 py-2">
      <div class="card-body d-flex flex-column">
        <div class="row no-gutters align-items-center flex-grow-1">
          <div class="col ml-3">
            <div class="h5 mb-0 font-weight-bold text-dark"><?= $masyarakatCount; ?> Akun masyarakat</div>
          </div>
          <i class="fas fa-users fa-2x text-gray-500 ml-auto"></i>
        </div>
      </div>
    </div>
  </div>

  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div class="col-6 d-flex align-items-stretch mb-4">
      <div class="card shadow w-100" data-aos="fade-up">
        <div class="card-header">
          <div class="row">
            <div class="col-6">
              <h6 class="m-0 font-weight-bold text-primary mt-2">NIK : <?= htmlspecialchars($row['nik']); ?></h6>
            </div>
          </div>
        </div>
        <div class="collapse show" id="generate">
          <div class="card-body d-flex flex-column">
            <div class="row">
              <div class="col-4">
                <h6 class="text-primary font-weight-bold">Foto : 
                  <?php if ($row['foto']): ?>
                    <img src="../../uploads/<?= htmlspecialchars($row['foto']); ?>" alt="Foto Laporan" class="report-img" width="100">
                  <?php endif; ?>
                </h6>
              </div>
              <div class="col-8">
                <h6><span class="text-primary font-weight-bold">Tanggal Pengaduan :</span> <?= htmlspecialchars($row['tgl_pengaduan']); ?></h6>
                <h6><span class="text-primary font-weight-bold">Tanggal Tanggapan :</span> <?= htmlspecialchars($row['tgl_tanggapan']); ?></h6>
              </div>
            </div>
            <hr class="bg-primary">
            <h6><span class="text-primary font-weight-bold">Laporan :</span> <?= htmlspecialchars($row['isi_laporan']); ?></h6>
            <h6><span class="text-primary font-weight-bold">Tanggapan :</span> <?= htmlspecialchars($row['tanggapan']); ?></h6>
            <hr class="bg-primary">
            <div class="row mt-auto">
              <div class="col-8 mt-2">
                <h5><span class="text-primary font-weight-bold">Ditanggapi oleh :</span> <?= htmlspecialchars($row['nama_petugas']); ?></h5>
              </div>
              <div class="col-4">
                <div class="d-flex justify-content-end">
                  <a href="preview.php?id_tanggapan=<?= htmlspecialchars($row['id_tanggapan']); ?>" class="btn btn-outline-primary">Preview</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

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
