<?php
$title = 'Tanggapan';

require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navUser.php';

if (!isset($_SESSION['nik']) || !$_SESSION['nik']) {
    header("Location: login.php");
    exit;
}

$nik = $_SESSION['nik'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['rating'], $_POST['id_tanggapan'])) {
    $rating = (int)$_POST['rating'];
    $id_tanggapan = (int)$_POST['id_tanggapan'];

    $updateQuery = "UPDATE tanggapan SET rating = ? WHERE id_tanggapan = ? AND EXISTS (SELECT 1 FROM pengaduan WHERE pengaduan.id_pengaduan = tanggapan.id_pengaduan AND pengaduan.nik = ?)";
    $stmt = $conn->prepare($updateQuery);
    if ($stmt) {
        $stmt->bind_param('iii', $rating, $id_tanggapan, $nik);
        $stmt->execute();
        $stmt->close();
    } else {
        echo "Error preparing statement: " . $conn->error;
    }
}

$query = "SELECT * FROM ( ( tanggapan INNER JOIN pengaduan ON tanggapan.id_pengaduan = pengaduan.id_pengaduan and pengaduan.nik = $nik )
        INNER JOIN petugas ON tanggapan.id_petugas = petugas.id_petugas ) ORDER BY id_tanggapan DESC";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<style>
    .table {
        border-collapse: collapse;
        width: 90%;
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
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 2rem;
        color: #ddd;
        cursor: pointer;
    }

    .rating label:hover,
    .rating label:hover ~ label,
    .rating input:checked ~ label {
        color: #f5b301;
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
        padding: 7px 18px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 14px;
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

<script>
    function showRatingModal(tanggapanId) {
        var modal = document.getElementById("ratingModal");
        modal.style.display = "block";

        document.getElementById("tanggapanId").value = tanggapanId;
    }

    function closeModal() {
        var modal = document.getElementById("ratingModal");
        modal.style.display = "none";
    }

    function submitRating() {
        var tanggapanId = document.getElementById("tanggapanId").value;
        var rating = document.querySelector('input[name="modal-rating"]:checked').value;

        var xhr = new XMLHttpRequest();
        xhr.open("POST", "", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var starsHtml = '';
                for (var r = 5; r >= 1; r--) {
                    starsHtml += '<label style="color: ' + (rating >= r ? '#f5b301' : '#ddd') + '">★</label>';
                }
                document.querySelector('button[data-id="' + tanggapanId + '"]').outerHTML = '<div class="rating">' + starsHtml + '</div>';
                closeModal();
            }
        };

        xhr.send("rating=" + rating + "&id_tanggapan=" + tanggapanId);
    }
</script>

<table class="table shadow text-center" data-aos="fade-up" data-aos-duration="900">
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
                <th scope="row"><?= $i; ?>.</th>
                <td><?= $row["nik"]; ?></td>
                <td><?= $row["tgl_pengaduan"]; ?></td>
                <td><?= $row["isi_laporan"]; ?></td>
                <td><?= $row["tgl_tanggapan"]; ?></td>
                <td><?= $row["tanggapan"]; ?></td>
                <td><?= $row["nama_petugas"]; ?></td>
                <td>
                    <?php if (isset($row["rating"]) && $row["rating"] !== NULL) : ?>
                        <div class="rating">
                            <?php for ($r = 5; $r >= 1; $r--) : ?>
                                <label style="color: <?= ($row['rating'] >= $r) ? '#f5b301' : '#ddd'; ?>">★</label>
                            <?php endfor; ?>
                        </div>
                    <?php else : ?>
                        <button class="button" data-id="<?= $row['id_tanggapan']; ?>" onclick="showRatingModal(<?= $row['id_tanggapan']; ?>)">Beri Rating</button>
                    <?php endif; ?>
                </td>
            </tr>
            <?php $i++; ?>
        <?php endwhile; ?>
    </tbody>
</table>

<div id="ratingModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <h2>Apakah Anda puas dengan tanggapan kami?</h2>
        <div class="rating">
            <?php for ($r = 5; $r >= 1; $r--) : ?>
                <input type="radio" name="modal-rating" value="<?= $r; ?>" id="modal-rating-<?= $r; ?>">
                <label for="modal-rating-<?= $r; ?>">★</label>
            <?php endfor; ?>
        </div>
        <input type="hidden" id="tanggapanId">
        <button class="button" onclick="submitRating()">Submit</button>
    </div>
</div>

<?php require '../layouts/footer.php';?>