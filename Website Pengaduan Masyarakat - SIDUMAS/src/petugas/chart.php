<?php
$title = 'Grafik';
require '../../public/app.php';
require '../layouts/header.php';
require '../layouts/navPetugas.php';

$query = "SELECT COUNT(*) AS total FROM pengaduan";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$totalReports = $data['total'];

$query = "SELECT COUNT(*) AS total FROM pengaduan WHERE status = 'proses'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$totalVerified = $data['total'];

$query = "SELECT COUNT(*) AS total FROM pengaduan WHERE status = 'terkirim'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$totalUnresponded = $data['total'];

$query = "SELECT COUNT(*) AS total FROM pengaduan WHERE status = 'selesai'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);
$totalCompleted = $data['total'];

$totalUnverified = $totalReports - $totalVerified;

$ratingQuery = "SELECT rating, COUNT(*) AS count FROM tanggapan WHERE rating IS NOT NULL GROUP BY rating";
$ratingResult = mysqli_query($conn, $ratingQuery);
$ratingData = [];
while ($row = mysqli_fetch_assoc($ratingResult)) {
    $ratingData[$row['rating']] = $row['count'];
}

$ratings = [0, 0, 0, 0, 0];
foreach ($ratingData as $rating => $count) {
    $ratings[$rating - 1] = $count;
}

?>

<div class="container" data-aos="fade-up">
    <div class="row">
        <div class="col-12">
            <h3 class="text-gray-800">Grafik Laporan</h3>
        </div>
    </div>

    <hr>

    <div id="reportContent">
        <div class="row">
            <div class="col-md-6 mb-4">
                <canvas id="barChart" width="300" height="400"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="pieChart" width="300" height="400"></canvas>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12">
                <h5 class="text-center">Grafik Kepuasan Masyarakat</h5>
                <div style="border: 1px solid #ccc; padding: 10px;">
                    <canvas id="ratingChart" width="300" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12 mb-4 text-center">
            <button id="printPdf" class="btn btn-primary">Cetak PDF</button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>
<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
<script>
    var ctxBar = document.getElementById('barChart').getContext('2d');
    var barChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Laporan Masuk', 'Laporan Terverifikasi', 'Laporan Belum Ditanggapi', 'Laporan Selesai'],
            datasets: [{
                label: 'Jumlah Laporan',
                data: [<?= $totalReports ?>, <?= $totalVerified ?>, <?= $totalUnresponded ?>, <?= $totalCompleted ?>],
                backgroundColor: ['#007bff', '#28a745', '#dc3545', '#ffc107']
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var ctxPie = document.getElementById('pieChart').getContext('2d');
    var pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: ['Laporan Terverifikasi', 'Laporan Belum Ditanggapi', 'Laporan Selesai'],
            datasets: [{
                data: [<?= $totalVerified ?>, <?= $totalUnresponded ?>, <?= $totalCompleted ?>],
                backgroundColor: ['#28a745', '#dc3545', '#ffc107']
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: {
                datalabels: {
                    formatter: (value, ctx) => {
                        let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                        let percentage = (value * 100 / sum).toFixed(2) + "%";
                        return percentage;
                    },
                    color: '#fff',
                    font: {
                        weight: 'bold'
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    var ctxRating = document.getElementById('ratingChart').getContext('2d');
    var ratingChart = new Chart(ctxRating, {
        type: 'bar',
        data: {
            labels: ['1 Star', '2 Stars', '3 Stars', '4 Stars', '5 Stars'],
            datasets: [{
                label: 'Jumlah Rating',
                data: [<?= implode(', ', $ratings) ?>],
                backgroundColor: ['#ff0000', '#ffff00', '#00ff00', '#800080', '#00ffff']
            }]
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    document.getElementById('printPdf').addEventListener('click', function() {
        var { jsPDF } = window.jspdf;
        var doc = new jsPDF('p', 'mm', 'a4');
        var content = document.getElementById('reportContent');

        html2canvas(content).then(canvas => {
            var imgData = canvas.toDataURL('image/png');
            var imgWidth = 210;
            var pageHeight = 295;
            var imgHeight = canvas.height * imgWidth / canvas.width;
            var heightLeft = imgHeight;
            var position = 0;

            doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
            heightLeft -= pageHeight;

            while (heightLeft >= 0) {
                position = heightLeft - imgHeight;
                doc.addPage();
                doc.addImage(imgData, 'PNG', 0, position, imgWidth, imgHeight);
                heightLeft -= pageHeight;
            }

            doc.save('report.pdf');
        });
    });
</script>

<?php require '../layouts/footer.php';?>
