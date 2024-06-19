<?php
$title = 'Preview';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navUser.php';


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
          <div class="col-6">
            <div class="d-sm-flex align-items-center justify-content-end">
            </div>
          </div>
        </div>
      </div>
      <div class="collapse show" id="generate">
        <div class="card-body">
          <div class="row">
            <div class="col-5">
              <h6 class="text-primary font-weight-bold">Foto : <?php if ($row['foto']): ?>
                <img src="../../uploads/<?= $row['foto']; ?>" alt="Foto Laporan" width="80" class="enlargeable">
                <?php endif; ?></h6>
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
                <a href="generate.php" class="btn btn-outline-primary">Kembali</a>
                <button id="printPDF" class="btn btn-primary ml-2">Cetak PDF</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>


<div id="imageModal" class="modal">
  <span class="close-modal">&times;</span>
  <img class="modal-content" id="modalImage">
</div>

<?php require '../layouts/footer.php';?>

<style>

.modal {
  display: none;
  position: fixed;
  z-index: 1000;
  padding-top: 60px;
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

.close-modal {
  position: absolute;
  top: 15px;
  right: 35px;
  color: #fff;
  font-size: 40px;
  font-weight: bold;
  transition: 0.3s;
}

.close-modal:hover,
.close-modal:focus {
  color: #bbb;
  text-decoration: none;
  cursor: pointer;
}
</style>

<script>
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


var modal = document.getElementById("imageModal");


var modalImg = document.getElementById("modalImage");

document.querySelectorAll('.enlargeable').forEach(item => {
  item.addEventListener('click', function(){
    modal.style.display = "block";
    modalImg.src = this.src;
  });
});


var span = document.getElementsByClassName("close-modal")[0];


span.onclick = function() { 
  modal.style.display = "none";
}
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>