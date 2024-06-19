<?php

$title = 'Data Petugas';

require '../../public/app.php';

require '../layouts/header.php';

require '../layouts/navAdmin.php';

$result = mysqli_query($conn, "SELECT * FROM petugas WHERE posisi IN ('RT', 'Sekretaris', 'Bendahara')");

?>


<table class="table table-bordered text-center shadow">
  <thead class="thead-dark">
    <tr>
      <th scope="col">No</th>
      <th scope="col">Nama</th>
      <th scope="col">Username</th>
      <th scope="col">Password</th>
      <th scope="col">Telepon</th>
      <th scope="col">Posisi</th>
      <th scope="col">
        <a href="tambah.php" class="btn btn-primary">Tambah Petugas</a>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php $i = 1; ?>
    <?php while ($row = mysqli_fetch_assoc($result)) : ?>
      <tr>
        <th scope="row"><?= $i; ?>.</th>
        <td><?= $row['nama_petugas']; ?></td>
        <td><?= $row['username']; ?></td>
        <td>*****</td>
        <td><?= $row['telp']; ?></td>
        <td><?= $row['posisi']; ?></td>
        <td>
          <a href="edit.php?id_petugas=<?= $row['id_petugas']; ?>" class="btn btn-outline-success">Edit</a> |
          <a href="hapus.php?id_petugas=<?= $row['id_petugas']; ?>" class="btn btn-outline-danger">Hapus</a>
        </td>
      </tr>
      <?php $i++; ?>
    <?php endwhile; ?>
  </tbody>
</table>

<?php require '../layouts/footer.php'; ?>
