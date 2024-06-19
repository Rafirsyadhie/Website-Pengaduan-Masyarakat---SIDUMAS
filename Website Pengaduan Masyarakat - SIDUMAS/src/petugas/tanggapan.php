<?php
$title = 'Tanggapan';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navPetugas.php';

$query = "SELECT * FROM ( ( tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan )
          INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas ) ORDER BY id_tanggapan DESC";

$result = mysqli_query($conn, $query);

?>

<style>
    .table {
        width: 95%; /* Lebarkan tabel */
        margin: 20px auto;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .table th,
    .table td {
        padding: 15px;
        text-align: center;
        border-bottom: 1px solid #ddd;
    }

    .table tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    .rating {
        display: flex;
        justify-content: center;
        direction: rtl;
        unicode-bidi: bidi-override;
        font-size: 2.5rem; /* Besarkan bintang */
    }

    .rating label {
        cursor: pointer;
    }

    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
        color: #f5b301; /* Warna bintang saat di-hover atau terpilih */
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
    }

    .modal-content {
        background-color: #fefefe;
        margin: 15% auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-width: 500px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .button {
        background-color: #4CAF50;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin: 4px 2px;
        cursor: pointer;
        border-radius: 10px;
        transition: background-color 0.3s;
    }

    .button:hover {
        background-color: #45a049;
        color: white;
    }
</style>

<table class="table table-bordered shadow text-center" data-aos="fade-up" data-aos-duration="900">
    <thead class="thead-dark">
        <tr>
            <th scope="col">No</th>
            <th scope="col">NIK</th>
            <th scope="col">Tanggal Laporan</th>
            <th scope="col">Laporan</th>
            <th scope="col">Tanggal Tanggapan</th>
            <th scope="col">Tanggapan</th>
            <th scope="col">Nama Petugas</th>
            <th scope="col">Rating</th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 1; ?>
        <?php while ($row = mysqli_fetch_assoc($result)) : ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $row["nik"]; ?></td>
                <td><?= $row["tgl_pengaduan"]; ?></td>
                <td><?= $row["isi_laporan"]; ?></td>
                <td><?= $row["tgl_tanggapan"]; ?></td>
                <td><?= $row["tanggapan"]; ?></td>
                <td><?= $row["nama_petugas"]; ?></td>
                <td>
                    <?php if (isset($row["rating"])) : ?>
                        <?php if ($row["rating"] !== NULL) : ?>
                            <?php $starsHtml = ''; ?>
                            <div class="rating">
                                <?php for ($r = 5; $r >= 1; $r--) : ?>
                                    <?php $starsHtml .= '<label style="color: ' . (($row['rating'] >= $r) ? '#f5b301' : '#ddd') . '">★</label>'; ?>
                                <?php endfor; ?>
                                <?= $starsHtml; ?>
                            </div>
                        <?php else : ?>
                            No Rating
                        <?php endif; ?>
                    <?php else : ?>
                        No Rating
                    <?php endif; ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endwhile; ?>
    </tbody>
</table>

<?php require '../layouts/footer.php';?>