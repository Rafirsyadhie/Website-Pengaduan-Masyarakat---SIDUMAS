<?php
$title = 'Preview';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navAdmin.php';

$id = $_GET['id_tanggapan'];

$query = "SELECT * FROM (( tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan ) 
                            INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas) WHERE id_tanggapan = $id";

$result = mysqli_query($conn, $query);
?>

<div class="d-flex justify-content-center py-5">
  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div class="card shadow mb-4 w-50" data-aos="fade-up">
      <div class="card-header">
        <div class="row">
          <div class="col-6">
            <h6 class="m-0 font-weight-bold text-primary mt-2">NIK : <?= $row['nik']; ?></h6>
          </div>
        </div>
      </div>
      <div class="collapse show" id="generate">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <h6 class="text-primary font-weight-bold">Foto :
                <?php if ($row['foto']): ?>
                  <img src="../../uploads/<?= $row['foto']; ?>" alt="Foto Laporan" class="report-img" width="150">
                <?php endif; ?>
              </h6>
            </div>
            <div class="col-7">
              <h6> <span class="text-primary font-weight-bold">Tanggal Pengaduan :</span> <?= $row['tgl_pengaduan']; ?></h6>
              <h6> <span class="text-primary font-weight-bold">Tanggal Tanggapan :</span> <?= $row['tgl_tanggapan']; ?></h6>
            </div>
          </div>
          <hr class="bg-primary">
          <h6 class="mb-3"><span class="text-primary font-weight-bold">Laporan :</span> <?= $row['isi_laporan']; ?></h6>
          <h6><span class="text-primary font-weight-bold">Tanggapan :</span> <?= $row['tanggapan']; ?></h6>
          <hr class="bg-primary">
          <div class="row">
            <div class="col-8 mt-2">
              <h5> <span class="text-primary font-weight-bold">Ditanggapi oleh :</span> <?= $row['nama_petugas']; ?></h5>
            </div>
            <div class="col-4">
              <div class="d-flex justify-content-end">
                <a href="dashboard.php" class="btn btn-outline-primary">Kembali</a>
                <button id="printPDF" class="btn btn-primary ml-2">Cetak PDF</button>
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

document.getElementById('printPDF').addEventListener('click', function () {
  var { jsPDF } = window.jspdf;
  var doc = new jsPDF();

  var elementHTML = document.querySelector('.card');

  html2canvas(elementHTML, {
    onrendered: function(canvas) {
      var imageData = canvas.toDataURL('image/png');
      var imgWidth = 190;
      var pageHeight = 290;
      var imgHeight = canvas.height * imgWidth / canvas.width;
      var heightLeft = imgHeight;
      
      var position = 10;

      doc.addImage(imageData, 'PNG', 10, position, imgWidth, imgHeight);
      heightLeft -= pageHeight;

      while (heightLeft >= 0) {
        position = heightLeft - imgHeight;
        doc.addPage();
        doc.addImage(imageData, 'PNG', 10, position, imgWidth, imgHeight);
        heightLeft -= pageHeight;
      }
      doc.save('tanggapan.pdf');
    }
  });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
