<?php

$title = 'Edit Masyarakat';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navAdmin.php';

if (!isset($_GET['id'])) {
    header('Location: masyarakat.php');
    exit;
}

$nik = $_GET['id'];
$result = mysqli_query($conn, "SELECT * FROM masyarakat WHERE nik = '$nik'");
$data = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $nama = htmlspecialchars($_POST['nama']);
    $username = htmlspecialchars($_POST['username']);
    $telp = htmlspecialchars($_POST['telp']);
    $password = htmlspecialchars($_POST['password']);

    $query = "UPDATE masyarakat SET nama = '$nama', username = '$username', telp = '$telp', password = '$password' WHERE nik = '$nik'";
    if (mysqli_query($conn, $query)) {
        $sukses = true;
    } else {
        $error = mysqli_error($conn);
    }
}

?>

<?php if (isset($sukses)) : ?>
  <div class="alert alert-dismissible fade show" style="background-color: #3bb849;" role="alert">
    <h5 class="text-gray-100 mt-2">Akun Masyarakat Berhasil Diubah!</h5>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" class="text-light">&times;</span>
    </button>
  </div>
<?php endif; ?>

<?php if (isset($error)) : ?>
  <div class="alert alert-dismissible fade show" style="background-color: #b52d2d;" role="alert">
    <h6 class="text-light mt-2">Maaf akun masyarakat gagal diubah: <?= $error; ?></h6>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true" class="text-light">&times;</span>
    </button>
  </div>
<?php endif; ?>

<div class="p-5">
  <div class="row">
    <div class="col-6">
      <div class="image">
        <img src="../../assets/img/officer.svg" width="450" alt="">
      </div>
    </div>
    <div class="col-6">
      <form action="" method="POST">
        <div class="form-group">
          <input type="hidden" class="form-control py-4 shadow-sm" value="<?= $data['nik']; ?>" style="border-radius: 25px;" name="nik">
        </div>
        <div class="form-group">
          <input type="text" class="form-control py-4 shadow-sm" value="<?= $data['nama']; ?>" style="border-radius: 25px;" name="nama" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control py-4 shadow-sm" value="<?= $data['username']; ?>" style="border-radius: 25px;" name="username" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control py-4 shadow-sm" value="<?= $data['password']; ?>" style="border-radius: 25px;" name="password" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control py-4 shadow-sm" value="<?= $data['telp']; ?>" style="border-radius: 25px;" name="telp" required>
        </div>
        <div class="button">
          <button class="btn btn-primary shadow-sm py-2 col-12" name="submit" style="border-radius: 25px;">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require '../layouts/footer.php'; ?>
