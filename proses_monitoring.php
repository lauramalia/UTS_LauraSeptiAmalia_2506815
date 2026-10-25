<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'petugas') {
    header("Location: login.php");
    exit;
}

function tampilkanError($pesan, $kembali)
{
    echo "<!DOCTYPE html>
<html lang='id'>
<head><meta charset='UTF-8'><title>Terjadi Kesalahan</title></head>
<body>
    <h3>" . htmlspecialchars($pesan) . "</h3>
    <a href='" . $kembali . "'>&laquo; Kembali</a>
</body>
</html>";
    exit;
}

$id_user          = (int) $_SESSION['id_user'];
$id_tambak        = (int) ($_POST['id_tambak'] ?? 0);
$tanggal          = mysqli_real_escape_string($koneksi, $_POST['tanggal'] ?? '');
$suhu             = mysqli_real_escape_string($koneksi, $_POST['suhu'] ?? '');
$ph               = mysqli_real_escape_string($koneksi, $_POST['ph'] ?? '');
$salinitas        = mysqli_real_escape_string($koneksi, $_POST['salinitas'] ?? '');
$oksigen_terlarut = mysqli_real_escape_string($koneksi, $_POST['oksigen_terlarut'] ?? '');
$keterangan       = mysqli_real_escape_string($koneksi, $_POST['keterangan'] ?? '');

if (
    $id_tambak === 0 ||
    empty($tanggal) ||
    $suhu === '' ||
    $ph === '' ||
    $salinitas === '' ||
    $oksigen_terlarut === ''
) {
    tampilkanError('Semua data wajib harus diisi!', 'form_monitoring.php');
}

$tanggal = str_replace('T', ' ', $tanggal) . ':00';

$query = "INSERT INTO monitoring_air
            (id_tambak, id_user, tanggal, suhu, ph, salinitas, oksigen_terlarut, keterangan)
          VALUES
            ($id_tambak, $id_user, '$tanggal', '$suhu', '$ph',
             '$salinitas', '$oksigen_terlarut', '$keterangan')";

if (mysqli_query($koneksi, $query)) {
    header("Location: main_petugas.php?status=sukses");
    exit;
}

tampilkanError('Gagal menyimpan data: ' . mysqli_error($koneksi), 'form_monitoring.php');
?>