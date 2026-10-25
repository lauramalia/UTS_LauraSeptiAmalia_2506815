<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['id_user']) || ($_SESSION['role'] ?? '') !== 'petugas') {
    header("Location: login.php");
    exit;
}

$id_user_login = (int) $_SESSION['id_user'];

$hasil = mysqli_query(
    $koneksi,
    "SELECT ma.id_monitoring, ma.id_user, ma.tanggal, t.nama_tambak,
            ma.suhu, ma.ph, ma.salinitas, ma.oksigen_terlarut,
            ma.keterangan, u.nama AS nama_petugas
     FROM monitoring_air AS ma
     INNER JOIN tambak AS t ON ma.id_tambak = t.id_tambak
     INNER JOIN users AS u ON ma.id_user = u.id_user
     ORDER BY ma.tanggal DESC"
);

if (!$hasil) {
    die("Query gagal: " . mysqli_error($koneksi));
}

$status = $_GET['status'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Monitoring | TambakCare</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#F3F8FD; font-family:'Segoe UI',Arial,sans-serif;">
<div class="container-fluid px-3 px-md-4 py-4">

    <h3 class="fw-bold" style="color:#0B315B;">Data Monitoring Kualitas Air</h3>

    <?php if ($status === 'diupdate') { ?>
        <div class="alert alert-success">Data monitoring berhasil diupdate!</div>
    <?php } elseif ($status === 'dihapus') { ?>
        <div class="alert alert-success">Data monitoring berhasil dihapus!</div>
    <?php } ?>

    <a href="form_monitoring.php" class="btn btn-success mb-3">Tambah Data</a>
    <a href="main_petugas.php" class="btn btn-secondary mb-3">Kembali</a>

    <div class="card border-0 shadow-sm" style="border-radius:15px; overflow:hidden;">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead style="background:#EFF6FF; color:#0B315B;">
                    <tr>
                        <th class="px-3">Tanggal</th>
                        <th>Nama Tambak</th>
                        <th>Suhu (°C)</th>
                        <th>pH</th>
                        <th>Salinitas (ppt)</th>
                        <th>Oksigen (mg/L)</th>
                        <th>Keterangan</th>
                        <th>Petugas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($m = mysqli_fetch_assoc($hasil)) { ?>
                    <tr>
                        <td class="px-3"><?= htmlspecialchars(date('d-m-Y H:i', strtotime($m['tanggal']))) ?></td>
                        <td class="fw-semibold"><?= htmlspecialchars($m['nama_tambak']) ?></td>
                        <td><?= htmlspecialchars($m['suhu']) ?></td>
                        <td><?= htmlspecialchars($m['ph']) ?></td>
                        <td><?= htmlspecialchars($m['salinitas']) ?></td>
                        <td><?= htmlspecialchars($m['oksigen_terlarut']) ?></td>
                        <td><?= htmlspecialchars($m['keterangan']) ?></td>
                        <td><?= htmlspecialchars($m['nama_petugas']) ?></td>
                        <td>
                            <a href="update_monitoring.php?id=<?= (int) $m['id_monitoring'] ?>"
                               class="btn btn-warning btn-sm d-block mb-1">Edit</a>
                            <a href="delete_monitoring.php?id=<?= (int) $m['id_monitoring'] ?>"
                               class="btn btn-danger btn-sm d-block">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</body>
</html>