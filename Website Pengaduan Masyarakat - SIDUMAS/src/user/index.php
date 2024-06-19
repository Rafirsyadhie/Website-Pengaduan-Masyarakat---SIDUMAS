<?php
$title = 'Aduan Masyarakat';

require '../../public/app.php';
require '../layouts/header.php';

$pengaduan = mysqli_query($conn, "SELECT * FROM pengaduan ORDER BY id_pengaduan DESC LIMIT 1");

$tanggapan = mysqli_query($conn, "SELECT * FROM tanggapan ORDER BY id_tanggapan DESC LIMIT 1");

$masyarakat = mysqli_query($conn, "SELECT * FROM masyarakat ORDER BY nik DESC LIMIT 1");

$pengaduanCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM pengaduan");
$tanggapanCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM tanggapan");
$masyarakatCount = mysqli_query($conn, "SELECT COUNT(*) as total FROM masyarakat");

$pengaduanCount = mysqli_fetch_assoc($pengaduanCount)['total'];
$tanggapanCount = mysqli_fetch_assoc($tanggapanCount)['total'];
$masyarakatCount = mysqli_fetch_assoc($masyarakatCount)['total'];
?>

<style>
  .fixed-top {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    z-index: 1030;
  }
  .main-content {
    margin-top: 70px;
  }
</style>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary py-3 shadow fixed-top">
  <div class="container" data-aos="fade-down">
    <a class="navbar-brand" href="#">
      <i class="fas fa-atlas"></i> SIDUMAS
    </a>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
        <a href="#" class="btn btn-outline-light mr-3" data-toggle="modal" data-target="#helpModal">
          <i class="fas fa-question-circle"></i> Bantuan
        </a>
        <a href="login.php" class="btn btn-light mr-3">Login</a>
        <a href="register.php" class="btn btn-outline-light">Registrasi</a>
      </ul>
    </div>
  </div>
</nav>

<div class="main-content">
  <div class="bg-gradient-primary" style="border-bottom-right-radius: 100px; border-bottom-left-radius: 100px; padding:150px;">
    <div class="container d-flex justify-content-center" data-aos="zoom-in">
      <div class="text-center col-8 text-light" style="margin-top: -25px;">
        <h1>SIDUMAS</h1>
        <p>Selamat datang di SIDUMAS, Sistem Informasi Pengaduan Masyarakat, platform interaktif yang memungkinkan Anda untuk melaporkan keluhan dan saran secara mudah dan cepat. Kami berkomitmen untuk mendengarkan dan menindaklanjuti setiap masukan demi perbaikan pelayanan publik.</p>
        <a href="login.php" class="btn btn-outline-light">Buat laporan sekarang!</a>
      </div>
    </div>
  </div>

  <div class="container" style="margin-top: -35px;">
    <div class="row mb-3">
      <?php while ($row = mysqli_fetch_assoc($pengaduan)) : ?>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="500">
          <div class="card border-left-info border-bottom-info shadow-lg h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col ml-3">
                  <div class="h5 mb-0 font-weight-bold text-info"><?= $pengaduanCount; ?> Pengaduan</div>
                </div>
                <i class="fas fa-comment fa-2x text-gray-500"></i>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

      <?php while ($row = mysqli_fetch_assoc($tanggapan)) : ?>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="700">
          <div class="card border-left-success border-bottom-success shadow-lg h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col ml-3">
                  <div class="h5 mb-0 font-weight-bold text-success"><?= $tanggapanCount; ?> Tanggapan</div>
                </div>
                <i class="fas fa-comments fa-2x text-gray-500"></i>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>

      <?php while ($row = mysqli_fetch_assoc($masyarakat)) : ?>
        <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-duration="900">
          <div class="card border-left-warning border-bottom-warning shadow-lg h-100 py-2">
            <div class="card-body">
              <div class="row no-gutters align-items-center">
                <div class="col ml-3">
                  <div class="h5 mb-0 font-weight-bold text-warning"><?= $masyarakatCount; ?> Akun masyarakat</div>
                </div>
                <i class="fas fa-users fa-2x text-gray-500"></i>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile ?>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-6" data-aos="fade-right">
          <div class="desc" style="margin-top: 130px;">
            <h4 class="text-justify text-gray-900">Buat laporan, aduan dan keluh kesah anda di website aduan masyarakat ini dan jangan meyebarkan berita hoax!</h4>
          </div>
        </div>
        <div class="col-6">
          <div class="img mt-5 ml-3" data-aos="fade-left">
            <img src="../../assets/img/landing3.svg" width="450" alt="">
          </div>
        </div>

        <div class="col-6" style="margin-top: -45px;">
          <div class="img" data-aos="fade-right">
            <img src="../../assets/img/landing2.svg" width="450" alt="">
          </div>
        </div>
        <div class="col-6" style="margin-top: -45px;">
          <div class="desc ml-3" style="margin-top: 130px;" data-aos="fade-left">
            <h4 class="text-justify text-gray-900">Jangan lupa mengirimkan foto anda saat menyampaikan laporan, aduan ataupun keluh kesah anda di web ini.</h4>
          </div>
        </div>

        <div class="col-6" style="margin-top: -45px;">
          <div class="desc" style="margin-top: 130px;" data-aos="fade-right">
            <h4 class="text-justify text-gray-900">Setelah menyampaikan laporan, aduan atau keluh kesah anda dapat menunggu tanggapan dengan santai.</h4>
          </div>
        </div>
        <div class="col-6" style="margin-top: -45px;" data-aos="fade-left">
          <div class="img ml-3">
            <img src="../../assets/img/landing1.svg" width="450" alt="">
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="container py-5">
    <h2 class="text-center text-uppercase text-gray-900" data-aos="zoom-in-up" style="font-weight: bold;">Frequently Asked Questions (FAQ)</h2>
    <hr>
    <div class="accordion" id="faqAccordion">
      <div class="card">
        <div class="card-header" id="faq1">
          <h5 class="mb-0">
            <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
              Apa itu Website Pengaduan Masyarakat?
            </button>
          </h5>
        </div>
        <div id="collapse1" class="collapse" aria-labelledby="faq1" data-parent="#faqAccordion">
          <div class="card-body">
            Website Pengaduan Masyarakat adalah platform online yang memungkinkan masyarakat untuk melaporkan keluhan, saran, dan masukan terkait pelayanan publik secara mudah dan cepat.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="faq2">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
              Bagaimana cara melaporkan pengaduan?
            </button>
          </h5>
        </div>
        <div id="collapse2" class="collapse" aria-labelledby="faq2" data-parent="#faqAccordion">
          <div class="card-body">
            Untuk melaporkan pengaduan, Anda perlu mendaftar atau login ke dalam sistem, kemudian pilih opsi "Buat laporan sekarang" dan isi form yang disediakan dengan detail pengaduan Anda.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="faq3">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
              Apakah saya bisa melihat tanggapan atas pengaduan saya?
            </button>
          </h5>
        </div>
        <div id="collapse3" class="collapse" aria-labelledby="faq3" data-parent="#faqAccordion">
          <div class="card-body">
            Ya, Anda bisa melihat tanggapan atas pengaduan Anda dengan login ke akun Anda dan melihat status pengaduan yang telah Anda buat.
          </div>
        </div>
      </div>
      <div class="card">
        <div class="card-header" id="faq4">
          <h5 class="mb-0">
            <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
              Apakah data saya aman di website ini?
            </button>
          </h5>
        </div>
        <div id="collapse4" class="collapse" aria-labelledby="faq4" data-parent="#faqAccordion">
          <div class="card-body">
            Kami berkomitmen untuk menjaga kerahasiaan dan keamanan data Anda. Semua informasi yang Anda berikan akan disimpan dengan aman dan hanya digunakan untuk tujuan penanganan pengaduan.
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-gradient-primary py-5">
    <div class="container text-center text-light">
      <h1 class="mb-3">Info Aduan Masyarakat</h1>
      <a href="mailto:irsyadhierafi03@gmail.com" class="btn btn-light mr-1">Chat admin</a>
      <a href="mailto:irsyadhierafi03@gmail.com" class="btn btn-outline-light ml-1">Contact Developer</a>
    </div>
  </div>

  <div class="container py-5">
    <h2 class="text-center text-uppercase text-gray-900" data-aos="zoom-in-up">Testimonial</h2>
    <hr>
    <div class="row">
      <div class="col-4">
        <div class="card shadow-sm" data-aos="fade-up" data-aos-duration="500">
          <div class="card-body">
            <img src="../../assets/img/tulis.svg" width="35" class="rounded-circle" alt="">
            <span>Ahmad Davin</span> |
            <span>Pelajar</span>
            <hr>
            <div class="card-text text-justify">"Website Pengaduan Masyarakat ini sangat membantu! Saya bisa dengan mudah melaporkan masalah yang saya hadapi dan mendapatkan tanggapan cepat dari pihak terkait."</div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card shadow-sm" data-aos="fade-up" data-aos-duration="700">
          <div class="card-body">
            <img src="../../assets/img/img-dashboard-user.svg" width="35" class="rounded-circle" alt="">
            <span>Adeline Wijaya</span> |
            <span>Guru SMA</span>
            <hr>
            <div class="card-text text-justify">"Sebagai seorang guru, saya sering menemui berbagai kendala. Dengan platform ini, saya bisa melaporkan keluhan saya dan melihat tindak lanjutnya secara transparan."</div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card shadow-sm" data-aos="fade-up" data-aos-duration="900">
          <div class="card-body">
            <img src="../../assets/img/login.svg" width="35" class="rounded-circle" alt="">
            <span>Daffa Ahmad</span> |
            <span>Mahasiswa</span>
            <hr>
            <div class="card-text text-justify">"Sangat puas dengan layanan website ini! Pengaduan saya ditanggapi dengan cepat dan solusi yang diberikan sangat memuaskan. Terima kasih atas pelayanannya!"</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="bg-gray-400 py-3">
    <footer>
      <div class="text-center mt-2 text-gray-700">
        <h6>Copyright &copy;2024 - Muhammad Rafi Irsyadhie.</h6>
      </div>
    </footer>
  </div>
</div>

<div class="modal fade" id="helpModal" tabindex="-1" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="helpModalLabel">Panduan Pengaduan Masyarakat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ol>
          <li>Daftar dan Login terlebih dahulu</li>
          <li>Pilih opsi "Buat laporan"</li>
          <li>Isi form dengan detail pengaduan Anda</li>
          <li>Sertakan foto jika diperlukan</li>
          <li>Kirim laporan dan tunggu tanggapan</li>
        </ol>
        <p>Pastikan semua informasi yang Anda berikan akurat dan jelas untuk memudahkan proses tindak lanjut.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<?php require '../layouts/footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
