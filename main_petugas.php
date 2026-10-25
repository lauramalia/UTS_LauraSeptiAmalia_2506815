<?php
session_start();
include('koneksi.php');

// Memastikan hanya petugas yang dapat mengakses halaman ini.
if (
    !isset($_SESSION['id_user']) ||
    !isset($_SESSION['role']) ||
    $_SESSION['role'] !== 'petugas'
) {
    header("Location: login.php");
    exit;
}

// Identitas pengguna dari session.
$nama = $_SESSION['nama'] ?? 'Pengguna';
$role = $_SESSION['role'];

// Status pesan setelah simpan / update / hapus.
$status = $_GET['status'] ?? '';

// Menghitung total tambak.
$sql_tambak = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM tambak"
);

if (!$sql_tambak) {
    die("Query total tambak gagal: " . mysqli_error($koneksi));
}

$total_tambak = (int) mysqli_fetch_assoc($sql_tambak)['total'];

// Menghitung total catatan monitoring air.
$sql_monitoring = mysqli_query(
    $koneksi,
    "SELECT COUNT(*) AS total FROM monitoring_air"
);

if (!$sql_monitoring) {
    die("Query total monitoring gagal: " . mysqli_error($koneksi));
}

$total_monitoring = (int) mysqli_fetch_assoc($sql_monitoring)['total'];

// Mengambil lima catatan monitoring terbaru sesuai ERD.
$query_terbaru = mysqli_query(
    $koneksi,
    "SELECT
        ma.id_monitoring,
        ma.id_user,
        ma.tanggal,
        t.nama_tambak,
        ma.suhu,
        ma.ph,
        ma.salinitas,
        ma.oksigen_terlarut,
        u.nama AS nama_petugas
    FROM monitoring_air AS ma
    INNER JOIN tambak AS t
        ON ma.id_tambak = t.id_tambak
    INNER JOIN users AS u
        ON ma.id_user = u.id_user
    ORDER BY ma.tanggal DESC
    LIMIT 5"
);

if (!$query_terbaru) {
    die("Query monitoring terbaru gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Petugas | TambakCare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body style="margin:0; background:#F3F8FD; font-family:'Segoe UI',Arial,sans-serif;">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark shadow-sm"
         style="background:linear-gradient(135deg,#0B315B,#1675D1);">

        <div class="container-fluid px-3 px-md-4">

            <a href="main_petugas.php" class="navbar-brand fw-bold">
                <i class="bi bi-water me-2"></i>
                TambakCare
            </a>

            <div class="d-flex align-items-center gap-2">

                <span class="text-white small d-none d-sm-inline">
                    <i class="bi bi-person-circle me-1"></i>
                    <?= htmlspecialchars($nama) ?>
                </span>

                <a href="logout.php"
                   class="btn btn-outline-light btn-sm"
                   onclick="return confirm('Yakin ingin keluar?')">
                    <i class="bi bi-box-arrow-right me-1"></i>
                    Logout
                </a>

            </div>
        </div>
    </nav>

    <!-- KONTEN DASHBOARD -->
    <div class="container-fluid px-3 px-md-4 py-4">

        <!-- PESAN STATUS -->
        <?php if ($status === 'sukses') { ?>
            <div class="alert alert-success">Data monitoring berhasil disimpan!</div>
        <?php } ?>

        <!-- SAPAAN -->
        <div class="p-4 p-md-5 mb-4"
             style="background:linear-gradient(120deg,#0B315B,#1675D1,#1687A8); border-radius:18px; color:white;">

            <div class="row align-items-center">

                <div class="col-md-8">

                    <p class="mb-2" style="opacity:0.85;">
                        DASHBOARD MONITORING PETUGAS
                    </p>

                    <h2 class="fw-bold mb-2">
                        Selamat datang, <?= htmlspecialchars($nama) ?>!
                    </h2>

                    <p class="mb-0" style="max-width:600px; line-height:1.7;">
                        Pantau dan catat kualitas air tambak ikan bandeng melalui
                        pengukuran suhu, pH, salinitas, dan oksigen terlarut.
                    </p>

                    <span class="badge mt-3"
                          style="background:#FFFFFF; color:#0B315B;">
                        <i class="bi bi-person-check me-1"></i>
                        Petugas
                    </span>

                </div>

                <div class="col-md-4 text-center d-none d-md-block">
                    <i class="bi bi-water"
                       style="font-size:100px; opacity:0.8;"></i>
                </div>

            </div>
        </div>

        <!-- RINGKASAN DATA -->
        <div class="row g-3 mb-4">

            <!-- TOTAL TAMBAK -->
            <div class="col-12 col-md-6">

                <div class="card border-0 shadow-sm h-100"
                     style="border-radius:15px;">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <p class="text-secondary mb-2">Total Tambak</p>

                                <h2 class="fw-bold mb-0" style="color:#0B315B;">
                                    <?= $total_tambak ?>
                                </h2>
                            </div>

                            <div class="d-flex align-items-center justify-content-center"
                                 style="width:58px;height:58px;border-radius:15px;background:#DCEEFF;color:#1675D1;font-size:27px;">
                                <i class="bi bi-geo-alt-fill"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <!-- TOTAL MONITORING -->
            <div class="col-12 col-md-6">

                <div class="card border-0 shadow-sm h-100"
                     style="border-radius:15px;">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>
                                <p class="text-secondary mb-2">Data Monitoring</p>

                                <h2 class="fw-bold mb-0" style="color:#0B315B;">
                                    <?= $total_monitoring ?>
                                </h2>
                            </div>

                            <div class="d-flex align-items-center justify-content-center"
                                 style="width:58px;height:58px;border-radius:15px;background:#DDF7EC;color:#16845B;font-size:27px;">
                                <i class="bi bi-clipboard-data-fill"></i>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- MENU UTAMA -->
        <h5 class="fw-bold mb-3" style="color:#0B315B;">
            <i class="bi bi-grid-fill me-2"></i>
            Menu Utama
        </h5>

        <div class="row g-3 mb-4">

            <!-- MENU MONITORING -->
            <div class="col-12 col-md-6">

                <div class="card border-0 shadow-sm h-100"
                     style="border-radius:15px;">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-start gap-3">

                            <div class="d-flex align-items-center justify-content-center flex-shrink-0"
                                 style="width:55px;height:55px;border-radius:14px;background:#DCEEFF;color:#1675D1;font-size:26px;">
                                <i class="bi bi-droplet-half"></i>
                            </div>

                            <div>

                                <h5 class="fw-bold" style="color:#0B315B;">
                                    Monitoring Kualitas Air
                                </h5>

                                <p class="text-secondary small">
                                    Catat hasil pengukuran kualitas air pada tambak.
                                </p>

                                <a href="form_monitoring.php"
                                   class="btn btn-sm text-white fw-semibold"
                                   style="background:#1675D1;border-radius:7px;">
                                    <i class="bi bi-plus-circle me-1"></i>
                                    Input Monitoring
                                </a>

                                <a href="data_monitoring.php"
                                   class="btn btn-sm btn-outline-primary fw-semibold ms-1"
                                   style="border-radius:7px;">
                                    <i class="bi bi-table me-1"></i>
                                    Kelola Semua Data
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- RIWAYAT MONITORING -->
        <div class="card border-0 shadow-sm mb-4"
             style="border-radius:15px;overflow:hidden;">

            <div class="card-header border-0 p-4"
                 style="background:#FFFFFF;">

                <h5 class="fw-bold mb-1" style="color:#0B315B;">
                    <i class="bi bi-clock-history me-2"></i>
                    Monitoring Terbaru
                </h5>

                <p class="text-secondary small mb-0">
                    Lima catatan pengukuran terakhir yang tersimpan.
                </p>

            </div>

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead style="background:#EFF6FF;color:#0B315B;">
                            <tr>
                                <th class="px-3 py-3">Tanggal</th>
                                <th class="py-3">Nama Tambak</th>
                                <th class="py-3">Suhu (°C)</th>
                                <th class="py-3">pH</th>
                                <th class="py-3">Salinitas (ppt)</th>
                                <th class="py-3">Oksigen (mg/L)</th>
                                <th class="py-3">Petugas</th>
                                <th class="py-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php if (mysqli_num_rows($query_terbaru) > 0) { ?>

                                <?php while ($m = mysqli_fetch_assoc($query_terbaru)) { ?>

                                    <tr>

                                        <td class="px-3">
                                            <?= htmlspecialchars(
                                                date('d-m-Y H:i', strtotime($m['tanggal']))
                                            ) ?>
                                        </td>

                                        <td class="fw-semibold">
                                            <?= htmlspecialchars($m['nama_tambak']) ?>
                                        </td>

                                        <td><?= htmlspecialchars($m['suhu']) ?></td>

                                        <td><?= htmlspecialchars($m['ph']) ?></td>

                                        <td><?= htmlspecialchars($m['salinitas']) ?></td>

                                        <td><?= htmlspecialchars($m['oksigen_terlarut']) ?></td>

                                        <td><?= htmlspecialchars($m['nama_petugas']) ?></td>

                                        <td>
                                            <?php if ((int) $m['id_user'] === (int) $_SESSION['id_user']) { ?>
                                                <a href="update.php?id=<?= $m['id_monitoring'] ?>" 
                                                class="btn btn-warning btn-sm">Edit</a>
                                                <a href="delete.php?id=<?= (int) $m['id_monitoring'] ?>"
                                                class="btn btn-danger btn-sm">Delete</a>
                                            <?php } else { ?>
                                                <span class="text-secondary small">-</span>
                                            <?php } ?>
                                        </td>

                                    </tr>

                                <?php } ?>

                            <?php } else { ?>

                                <tr>
                                    <td colspan="8" class="text-center py-5 text-secondary">
                                        <i class="bi bi-inbox d-block mb-2"
                                           style="font-size:35px;"></i>
                                        Belum ada data monitoring yang tersimpan.
                                    </td>
                                </tr>

                            <?php } ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <div class="text-center py-3">
            <p class="text-secondary small mb-0">
                <i class="bi bi-water me-1"></i>
                TambakCare &copy; <?= date('Y') ?>
                | Sistem Monitoring Kualitas Air Tambak
            </p>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
