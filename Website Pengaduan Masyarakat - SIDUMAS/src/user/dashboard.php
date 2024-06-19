<?php
$title = 'Dashboard';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navUser.php';

if (!isset($_SESSION['nik'])) {
    header("Location: login.php");
}

$justLoggedIn = false;
if (isset($_SESSION['just_logged_in']) && $_SESSION['just_logged_in'] == true) {
    $justLoggedIn = true;
    unset($_SESSION['just_logged_in']);
}

$nik = $_SESSION['nik'];

$query = "SELECT * FROM pengaduan WHERE nik = '{$nik}' ORDER BY id_pengaduan DESC LIMIT 5";
$result = mysqli_query($conn, $query);
$statuses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $statuses[] = $row;
}

$unreadQuery = "SELECT COUNT(*) as unread_count FROM pengaduan WHERE nik = '{$nik}' AND status = 'terkirim'";
$unreadResult = mysqli_query($conn, $unreadQuery);
$unreadCount = mysqli_fetch_assoc($unreadResult)['unread_count'];

function getAdminMessage($status) {
    switch (strtolower($status)) {
        case 'selesai':
            return "Terimakasih telah melaporkan keluh kesah Anda.";
        case 'terkirim':
        case 'proses':
            return "Pengaduan Anda sedang diproses. Terima kasih atas kesabarannya.";
        default:
            return "Status laporan tidak dikenal.";
    }
}
?>

<div class="notification-bell-container">
  <button id="notificationBell" class="btn btn-secondary position-relative">
    <i class="fas fa-bell"></i>
    <?php if ($unreadCount > 0) : ?>
      <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
        <?= $unreadCount ?>
      </span>
    <?php endif; ?>
  </button>
</div>

<div class="row py-5">
  <div class="col-6 py-5 mt-3">
    <div class="desc ml-5">
      <h2 class="text-gray-800" data-aos="fade-down">Selamat datang di SIDUMAS</h2>
      <p data-aos="fade-down">Website ini dibuat untuk melihat laporan atau keluh kesah masyarakat dan menjawab
        nya dengan satu platform.</p>
      <a href="buatLaporan.php" class="btn btn-primary shadow" data-aos="fade-up">Buat Laporan</a>
      <a href="lihatLaporan.php" class="btn btn-outline-primary ml-2" data-aos="fade-up" data-aos-duration="500">Lihat Laporan</a>
    </div>
  </div>
  <div class="col-6">
    <div class="image" data-aos="fade-left">
      <img src="../../assets/img/img-dashboard-user.svg" width="450" alt="">
    </div>
  </div>
</div>

<div id="notificationPopup" class="notification-popup">
  <div class="notification-header">
    <h4 class="custom-font">Progress Status Pengaduan</h4>
    <span class="close-notification">&times;</span>
  </div>
  <div class="notification-body">
    <ul id="notificationList">
      <?php foreach ($statuses as $row) : ?>
        <li>
          <strong>Laporan:</strong> <strong style="font-weight: bold; color: black;"><?= $row["isi_laporan"]; ?></strong> 
          <span class="badge <?= ($row["status"] == 'terkirim') ? 'badge-info' : (($row["status"] == 'proses') ? 'badge-warning' : 'badge-success'); ?>"><?= ucfirst($row["status"]); ?></span>
          <p class="admin-message"><strong>Pesan Admin:</strong> <?= getAdminMessage($row["status"]); ?></p>
        </li>
      <?php endforeach; ?>
    </ul>
  </div>
</div>

<div id="welcomePopup" class="notification-popup welcome-popup">
  <div class="notification-header">
    <h4 class="colorful-text">Hello!</h4>
    <span class="close-notification">&times;</span>
  </div>
  <div class="notification-body">
    <p class="colorful-text">Selamat datang!</p>
  </div>
</div>

<?php require '../layouts/footer.php'; ?>

<style>
.notification-bell-container {
  position: fixed;
  top: 80px;
  right: 20px;
  z-index: 1000;
}

.notification-bell-container .btn {
  background-color: #6c757d;
  color: white;
}

.notification-bell-container .position-relative {
  position: relative;
}

.notification-bell-container .badge {
  position: absolute;
  top: -10px;
  right: -10px;
  padding: 5px 10px;
  border-radius: 50%;
  background-color: #dc3545;
  color: white;
}

.notification-popup, .welcome-popup {
  display: none;
  position: fixed;
  right: 20px;
  top: 100px;
  background: #fff;
  border: 1px solid #ccc;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  width: 300px;
  z-index: 1000;
  border-radius: 8px;
  overflow: hidden;
  opacity: 0;
  transform: translateX(100%);
  transition: opacity 0.5s ease, transform 0.5s ease;
}

.notification-popup.show, .welcome-popup.show {
  opacity: 1;
  transform: translateX(0);
}

.notification-popup.hide, .welcome-popup.hide {
  opacity: 0;
  transform: translateX(100%);
}

.notification-header {
  padding: 10px;
  background: #f5f5f5;
  border-bottom: 1px solid #ddd;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.notification-header h4 {
  margin: 0;
}

.custom-font {
  font-family: 'Arial', sans-serif;
  font-size: 24px;
  font-weight: bold;
}

.notification-body {
  padding: 10px;
}

.notification-body ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.notification-body ul li {
  padding: 5px 0;
  border-bottom: 1px solid #ddd;
}

.notification-body ul li:last-child {
  border-bottom: none;
}

.notification-body .admin-message {
  margin-top: 5px;
  padding: 10px;
  background-color: #e8f4fc;
  border-left: 4px solid #007bff;
  border-radius: 5px;
  font-size: 0.9em;
  color: #004085;
  font-weight: bold;
  font-family: Arial, sans-serif;
}

.close-notification {
  color: #000;
  font-size: 20px;
  font-weight: bold;
  cursor: pointer;
  transition: 0.3s;
}

.close-notification:hover {
  color: #bbb;
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

.colorful-text {
  font-weight: bold;
  background: linear-gradient(45deg, #ff6b6b, #f94d6a, #c84e89, #6a4d94, #4d69d9, #4db1d9, #4dd991, #a7d94d);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  font-size: 2em;
  animation: rainbow-text 3s ease-in-out infinite;
}

@keyframes rainbow-text {
  0%, 100% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
}
</style>

<script>
var bell = document.getElementById("notificationBell");
var notificationPopup = document.getElementById("notificationPopup");
var welcomePopup = document.getElementById("welcomePopup");
var closeNotification = document.getElementsByClassName("close-notification");

bell.onclick = function() {
  notificationPopup.style.display = "block";
  setTimeout(function() {
    notificationPopup.classList.add("show");
    notificationPopup.classList.remove("hide");
  }, 10);
}

Array.prototype.forEach.call(closeNotification, function(element) {
  element.onclick = function() {
    var popup = this.parentElement.parentElement;
    popup.classList.add("hide");
    popup.classList.remove("show");
    
    setTimeout(function() {
      popup.style.display = "none";
    }, 500);
  }
});

window.onclick = function(event) {
  if (event.target == notificationPopup) {
    notificationPopup.classList.add("hide");
    notificationPopup.classList.remove("show");

    setTimeout(function() {
      notificationPopup.style.display = "none";
    }, 500);
  }
}

<?php if ($justLoggedIn) : ?>
welcomePopup.style.display = "block";
setTimeout(function() {
  welcomePopup.classList.add("show");
  welcomePopup.classList.remove("hide");
}, 10);

setTimeout(function() {
  welcomePopup.classList.add("hide");
  welcomePopup.classList.remove("show");
  setTimeout(function() {
    welcomePopup.style.display = "none";
  }, 500);
}, 3000);
<?php endif;?>
</script>