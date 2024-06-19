<?php
if (!isset($_SESSION)) { session_start();}
$conn = mysqli_connect("localhost", "root", "", "laporan_pengaduan");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

function tambahAduan($data) {
    global $conn;

    $tgl = htmlspecialchars($data["tgl_pengaduan"]);
    $nik = htmlspecialchars($data["nik"]);
    $isi = htmlspecialchars($data["isi_laporan"]);
    $status = htmlspecialchars($data["status"]);

    $foto = $_FILES['foto']['name'];
    $tmp_name = $_FILES['foto']['tmp_name'];
    $error = $_FILES['foto']['error'];

    if ($error === 0) {
        $file_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $allowed_exts = array('jpg', 'jpeg', 'png');

        if (in_array($file_ext, $allowed_exts)) {
            $upload_dir = '../../uploads/';
            $new_file_name = uniqid('', true) . '.' . $file_ext;
            $file_destination = $upload_dir . $new_file_name;
            
            if (move_uploaded_file($tmp_name, $file_destination)) {
                $foto = $new_file_name;
            } else {
                return -1;
            }
        } else {
            return -1;
        }
    } else {
        $foto = null;
    }

    $query = "INSERT INTO pengaduan (tgl_pengaduan, nik, isi_laporan, foto, status) VALUES ('$tgl', '$nik', '$isi', '$foto', '$status')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function verify($data)
{

    global $conn;

    $id = htmlspecialchars($data["id_pengaduan"]);
    $tgl = htmlspecialchars($data["tgl_pengaduan"]);
    $nik = htmlspecialchars($data["nik"]);
    $isi = htmlspecialchars($data["isi_laporan"]);
    $foto = htmlspecialchars($data["foto"]);
    $status = htmlspecialchars($data["status"]);
    $disposisi = htmlspecialchars($data["disposisi"]);

    $query = "UPDATE pengaduan SET
                id_pengaduan = '$id',
                tgl_pengaduan = '$tgl',
                nik = '$nik',
                isi_laporan = '$isi',
                foto = '$foto',
                status = '$status',
                disposisi = '$disposisi'
                WHERE id_pengaduan = '$id' ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}
if (!function_exists('tanggapan')) {
    function tanggapan($data)
    {
        global $conn;

        $id_pengaduan = htmlspecialchars($data["id_pengaduan"]);
        $tgl_tanggapan = htmlspecialchars($data["tgl_tanggapan"]);
        $tanggapan = htmlspecialchars($data["tanggapan"]);

        if (!isset($_SESSION['id_petugas'])) {
            return 0;
        }

        $id_petugas = $_SESSION['id_petugas'];

        $petugasCheckQuery = "SELECT * FROM petugas WHERE id_petugas = '$id_petugas'";
        $petugasResult = mysqli_query($conn, $petugasCheckQuery);

        if(mysqli_num_rows($petugasResult) > 0) {
            $query = "INSERT INTO tanggapan (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas) 
                      VALUES ('$id_pengaduan', '$tgl_tanggapan', '$tanggapan', '$id_petugas')";

            mysqli_query($conn, $query);

            $updateStatusQuery = "UPDATE pengaduan SET status='selesai' WHERE id_pengaduan = '$id_pengaduan'";
            mysqli_query($conn, $updateStatusQuery);

            return mysqli_affected_rows($conn);
        } else {
            return 0;
        }
    }
}

function regisUser($data) {
    global $conn;

    $nik = htmlspecialchars($data["nik"]);
    $nama = htmlspecialchars($data["nama"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $telp = htmlspecialchars($data["telp"]);

    if (strlen($nik) > 16) {
        return -1;
    }

    if (strlen($telp) > 13) {
        return -1;
    }

    $query = "INSERT INTO masyarakat (nik, nama, username, password, telp) VALUES ('$nik', '$nama', '$username', '$password', '$telp')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function addPetugas($data)
{
    global $conn;

    $nama = htmlspecialchars($data["nama_petugas"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $telp = htmlspecialchars($data["telp"]);
    $posisi = htmlspecialchars($data["posisi"]);

    $query = "INSERT INTO petugas (nama_petugas, username, password, telp, posisi) VALUES ('$nama', '$username', '$password', '$telp', '$posisi')";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function editPetugas($data)
{
    global $conn;

    $id = htmlspecialchars($data["id_petugas"]);
    $nama = htmlspecialchars($data["nama_petugas"]);
    $username = htmlspecialchars($data["username"]);
    $password = htmlspecialchars($data["password"]);
    $telp = htmlspecialchars($data["telp"]);
    $posisi = htmlspecialchars($data["posisi"]);

    $query = "UPDATE petugas SET
                nama_petugas = '$nama',
                username = '$username',
                password = '$password',
                telp = '$telp',
                posisi = '$posisi'
                WHERE id_petugas = '$id'";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deletePetugas($id)
{
    global $conn;

    $checkQuery = "SELECT * FROM tanggapan WHERE id_petugas = $id";
    $result = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($result) > 0) {
        return -1;
    }

    $query = "DELETE FROM petugas WHERE id_petugas = $id";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function deleteMasyarakat($nik) {
    global $conn;
    $query = "DELETE FROM masyarakat WHERE nik = '$nik'";
    if (mysqli_query($conn, $query)) {
        return 1;
    } else {
        if (mysqli_errno($conn) == 1451) {
            return -1; // related entry exists
        } else {
            return 0; // general error
        }
    }
}

?>