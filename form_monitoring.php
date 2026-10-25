<?php
session_start();
include('koneksi.php');

// Memastikan pengguna sudah login
if (!isset($_SESSION['id_user'])) {
    header("Location: login.php");
    exit;
}

// Mengambil daftar tambak dari database
$query_tambak = mysqli_query(
    $koneksi,
    "SELECT id_tambak, nama_tambak FROM tambak ORDER BY nama_tambak"
);

if (!$query_tambak) {
    die("Gagal mengambil data tambak.");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Input Monitoring Air | TambakCare</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body style="margin:0; min-height:100vh; background:#F3F8FD; font-family:'Segoe UI',Arial,sans-serif;">

    <!-- NAVBAR -->
    <nav class="navbar navbar-dark shadow-sm"
         style="background:linear-gradient(135deg,#0B315B,#1675D1);">

        <div class="container-fluid px-4">

            <a href="main.php" class="navbar-brand fw-bold">
                <i class="bi bi-water me-2"></i>
                TambakCare
            </a>

            <a href="main.php" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>
                Kembali
            </a>

        </div>
    </nav>


    <!-- KONTEN FORM -->
    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-12 col-lg-8 col-xl-7">

                <!-- JUDUL -->
                <div class="mb-4 text-center">

                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:70px; height:70px; border-radius:20px; background:#DCEEFF; color:#1675D1; font-size:32px;">

                        <i class="bi bi-droplet-half"></i>

                    </div>

                    <h2 class="fw-bold mb-2" style="color:#0B315B;">
                        Input Monitoring Kualitas Air
                    </h2>

                    <p class="text-secondary mb-0">
                        Masukkan hasil pengukuran kualitas air tambak ikan bandeng.
                    </p>

                </div>


                <!-- CARD FORM -->
                <div class="card border-0 shadow-sm"
                     style="border-radius:20px; overflow:hidden;">

                    <div class="card-header border-0 p-4"
                         style="background:linear-gradient(135deg,#1675D1,#1687A8); color:white;">

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-clipboard-data me-2"></i>
                            Formulir Data Monitoring
                        </h5>

                        <p class="mb-0 small" style="opacity:0.9;">
                            Pastikan hasil pengukuran yang dimasukkan sudah benar.
                        </p>

                    </div>


                    <div class="card-body p-4 p-md-5">

                        <form action="proses_monitoring.php" method="post">

                            <!-- NAMA TAMBAK -->
                            <div class="mb-4">

                                <label for="id_tambak" class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Nama Tambak <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-geo-alt-fill"></i>
                                    </span>

                                    <select
                                        name="id_tambak"
                                        id="id_tambak"
                                        class="form-select"
                                        required>

                                        <option value="">-- Pilih Tambak --</option>

                                        <?php while ($t = mysqli_fetch_assoc($query_tambak)) { ?>
                                            <option value="<?= (int)$t['id_tambak'] ?>">
                                                <?= htmlspecialchars($t['nama_tambak']) ?>
                                            </option>
                                        <?php } ?>

                                    </select>

                                </div>

                            </div>


                            <!-- TANGGAL PENGUKURAN -->
                            <div class="mb-4">

                                <label for="tanggal" class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Tanggal dan Waktu Pengukuran
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-calendar-event"></i>
                                    </span>

                                    <input
                                        type="datetime-local"
                                        class="form-control"
                                        id="tanggal"
                                        name="tanggal"
                                        value="<?= date('Y-m-d\TH:i') ?>"
                                        required>

                                </div>

                            </div>


                            <!-- SUHU AIR -->
                            <div class="mb-4">

                                <label for="suhu" class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Suhu Air (°C) <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-thermometer-half"></i>
                                    </span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="suhu"
                                        name="suhu"
                                        placeholder="Contoh: 29.50"
                                        step="0.01"
                                        min="0"
                                        max="99.99"
                                        required>

                                </div>

                            </div>


                            <!-- pH AIR -->
                            <div class="mb-4">

                                <label for="ph" class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    pH Air <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-moisture"></i>
                                    </span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="ph"
                                        name="ph"
                                        placeholder="Contoh: 7.50"
                                        step="0.01"
                                        min="0"
                                        max="14"
                                        required>

                                </div>

                            </div>


                            <!-- SALINITAS -->
                            <div class="mb-4">

                                <label for="salinitas" class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Salinitas (ppt) <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-water"></i>
                                    </span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="salinitas"
                                        name="salinitas"
                                        placeholder="Contoh: 15.00"
                                        step="0.01"
                                        min="0"
                                        max="9999.99"
                                        required>

                                </div>

                            </div>


                            <!-- OKSIGEN TERLARUT -->
                            <div class="mb-4">

                                <label for="oksigen_terlarut"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Oksigen Terlarut (mg/L)
                                    <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-wind"></i>
                                    </span>

                                    <input
                                        type="number"
                                        class="form-control"
                                        id="oksigen_terlarut"
                                        name="oksigen_terlarut"
                                        placeholder="Contoh: 5.00"
                                        step="0.01"
                                        min="0"
                                        max="9999.99"
                                        required>

                                </div>

                            </div>


                            <!-- KETERANGAN -->
                            <div class="mb-4">

                                <label for="keterangan"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Keterangan
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text align-items-start pt-3"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-chat-left-text"></i>
                                    </span>

                                    <textarea
                                        name="keterangan"
                                        id="keterangan"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Catatan kondisi air atau hasil pengamatan petugas"></textarea>

                                </div>

                            </div>


                            <!-- INFORMASI -->
                            <div class="alert alert-info border-0 small"
                                 style="border-radius:10px;">

                                <i class="bi bi-info-circle-fill me-2"></i>

                                Kolom bertanda
                                <span class="text-danger">*</span>
                                wajib diisi. Pastikan satuan pengukuran sudah sesuai.

                            </div>


                            <!-- TOMBOL -->
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">

                                <button
                                    type="submit"
                                    class="btn fw-semibold text-white flex-fill"
                                    style="padding:12px; border:0; border-radius:10px; background:linear-gradient(135deg,#1675D1,#1687A8);">

                                    <i class="bi bi-save-fill me-2"></i>
                                    Simpan Data

                                </button>

                                <button
                                    type="reset"
                                    class="btn btn-outline-secondary flex-fill fw-semibold"
                                    style="padding:12px; border-radius:10px;">

                                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                                    Reset Form

                                </button>

                            </div>

                        </form>

                    </div>
                </div>


                <!-- FOOTER -->
                <div class="text-center mt-4">

                    <p class="text-secondary small">
                        <i class="bi bi-shield-check me-1"></i>
                        TambakCare &copy; <?= date('Y') ?>
                        | Sistem Monitoring Kualitas Air Tambak
                    </p>

                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>