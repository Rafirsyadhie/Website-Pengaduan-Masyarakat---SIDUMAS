<?php

$title = 'Data Masyarakat';

require '../../public/app.php';

require '../layouts/header.php';

require '../layouts/navAdmin.php';

$result = mysqli_query($conn, "SELECT * FROM masyarakat");

?>

<table class="table table-bordered text-center shadow">
  <thead class="thead-dark">
    <tr>
      <th scope="col">No</th>
      <th scope="col">NIK</th>
      <th scope="col">Nama</th>
      <th scope="col">Username</th>
      <th scope="col">Password</th>
      <th scope="col">Telepon</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php if (mysqli_num_rows($result) > 0) : ?>
      <?php while ($row = mysqli_fetch_assoc($result)) : ?>
        <tr>
          <th scope="row"><?= $i; ?>.</th>
          <td><?= $row['nik']; ?></td>
          <td><?= $row['nama']; ?></td>
          <td><?= $row['username']; ?></td>
          <td>*****</td>
          <td><?= $row['telp']; ?></td>
          <td>
            <a href="edit_masyarakat.php?id=<?= $row['nik']; ?>" class="btn btn-outline-success">Edit</a> |
            <a href="hapus_masyarakat.php?id=<?= $row['nik']; ?>" class="btn btn-outline-danger">Hapus</a>
          </td>
        </tr>
        <?php $i++; ?>
      <?php endwhile; ?>
    <?php else : ?>
      <tr>
        <td colspan="6">No data available.</td>
      </tr>
    <?php endif; ?>
  </tbody>
</table>

<?php require '../layouts/footer.php';?>
