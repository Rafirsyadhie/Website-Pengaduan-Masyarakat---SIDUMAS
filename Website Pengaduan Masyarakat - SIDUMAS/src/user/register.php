<?php
$title = 'Register';

require '../../public/app.php';
require '../layouts/header.php';

if (isset($_POST['submit'])) {
    if (empty($_POST['nik']) || empty($_POST['nama']) || empty($_POST['username']) || empty($_POST['password']) || empty($_POST['telp'])) {
        echo "<script>alert('Please fill in all fields.');</script>";
    } else {
        $result = regisUser($_POST);
        if ($result > 0) {
            header("location: sukses.php");
        } elseif ($result === -1) {
            echo "<script>alert('NIK or Phone Number length is invalid.');</script>";
        } else {
            echo "<script>alert('Registration failed.');</script>";
        }
    }
}
?>

<div class="d-flex justify-content-center py-5">
  <div class="card w-25 shadow" data-aos="zoom-in">
    <div class="card-body border-bottom-primary">
      <h5 class="text-primary text-center">Registrasi</h5>
      <hr class="bg-primary">
      <form action="" method="post">
        <div class="form-group">
          <input type="text" class="form-control py-4 shadow-sm" placeholder="NIK" style="border-radius: 25px;" name="nik" maxlength="16" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control py-4 shadow-sm" placeholder="Nama" style="border-radius: 25px;" name="nama" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control py-4 shadow-sm" placeholder="Username" style="border-radius: 25px;" name="username" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control py-4 shadow-sm" placeholder="Password" style="border-radius: 25px;" name="password" required>
        </div>
        <div class="form-group">
          <input type="number" class="form-control py-4 shadow-sm" placeholder="No telepon" style="border-radius: 25px;" name="telp" maxlength="13" required>
        </div>
        <div class="mb-2 text-center">
          <a href="login.php" class="text-gray-600" style="text-decoration: none;">Sudah Punya Akun?</a>
        </div>
        <div class="button">
          <button class="btn btn-primary shadow-sm py-2 col-12" name="submit" style="border-radius: 25px;">Registrasi</button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php require '../layouts/footer.php';?>
