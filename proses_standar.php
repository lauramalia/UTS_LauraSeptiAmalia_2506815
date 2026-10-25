<?php
session_start();
include('koneksi.php');

// 1. Pemeriksaan hak akses admin
if (
    !isset($_SESSION['id_user']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'admin'
) {
    header("Location: login.php");
    exit;
}

// 2. Pastikan data dikirim melalui POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: form_standar.php");
    exit;
}

// 3. Ambil data dari formulir
$nama_parameter = trim($_POST['nama_parameter'] ?? '');
$nilai_min = $_POST['nilai_min'] ?? '';
$nilai_max = $_POST['nilai_max'] ?? '';
$sumber_acuan = trim($_POST['sumber_acuan'] ?? '');

// 4. Ketentuan parameter sesuai ERD
$parameter = [
    'Suhu' => [
        'satuan' => '°C',
        'min_diizinkan' => 0,
        'max_diizinkan' => 100
    ],
    'pH' => [
        'satuan' => 'pH',
        'min_diizinkan' => 0,
        'max_diizinkan' => 14
    ],
    'DO' => [
        'satuan' => 'mg/L',
        'min_diizinkan' => 0,
        'max_diizinkan' => 30
    ],
    'Salinitas' => [
        'satuan' => 'ppt',
        'min_diizinkan' => 0,
        'max_diizinkan' => 100
    ]
];

// 5. Validasi parameter dan nilai
if (
    !isset($parameter[$nama_parameter]) ||
    $nilai_min === '' ||
    $nilai_max === '' ||
    !is_numeric($nilai_min) ||
    !is_numeric($nilai_max) ||
    !is_finite((float)$nilai_min) ||
    !is_finite((float)$nilai_max) ||
    (float)$nilai_min > (float)$nilai_max ||
    (float)$nilai_min < $parameter[$nama_parameter]['min_diizinkan'] ||
    (float)$nilai_max > $parameter[$nama_parameter]['max_diizinkan'] ||
    $sumber_acuan === ''
) {
    header("Location: form_standar.php?status=gagal");
    exit;
}

$satuan = $parameter[$nama_parameter]['satuan'];

// 6. Cek apakah parameter sudah ada
$query_cek = "SELECT id_standar
              FROM standar_parameter
              WHERE nama_parameter = ?";

$stmt_cek = mysqli_prepare($koneksi, $query_cek);

if (!$stmt_cek) {
    header("Location: form_standar.php?status=gagal");
    exit;
}

mysqli_stmt_bind_param($stmt_cek, "s", $nama_parameter);
mysqli_stmt_execute($stmt_cek);
mysqli_stmt_store_result($stmt_cek);

if (mysqli_stmt_num_rows($stmt_cek) > 0) {
    mysqli_stmt_close($stmt_cek);
    header("Location: form_standar.php?status=sudah_ada");
    exit;
}

mysqli_stmt_close($stmt_cek);

// 7. Simpan standar parameter baru
$query = "INSERT INTO standar_parameter
          (nama_parameter, nilai_min, nilai_max,
           satuan, sumber_acuan, status_aktif)
          VALUES (?, ?, ?, ?, ?, 1)";

$stmt = mysqli_prepare($koneksi, $query);

if (!$stmt) {
    header("Location: form_standar.php?status=gagal");
    exit;
}

$nilai_min = (float)$nilai_min;
$nilai_max = (float)$nilai_max;

mysqli_stmt_bind_param(
    $stmt,
    "sddss",
    $nama_parameter,
    $nilai_min,
    $nilai_max,
    $satuan,
    $sumber_acuan
);

if (mysqli_stmt_execute($stmt)) {
    mysqli_stmt_close($stmt);
    header("Location: form_standar.php?status=berhasil");
    exit;
}

mysqli_stmt_close($stmt);
header("Location: form_standar.php?status=gagal");
exit;
?>
