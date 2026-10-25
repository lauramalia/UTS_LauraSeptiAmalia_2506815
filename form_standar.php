<?php
session_start();
include('koneksi.php');

// Hanya admin yang boleh mengakses halaman ini
if (!isset($_SESSION['id_user']) || $_SESSION['role'] !== 'admin') {
    header("Location: main.php");
    exit;
}

// Mengambil data standar yang sudah tersimpan
$query_standar = mysqli_query(
    $koneksi,
    "SELECT * FROM standar_parameter ORDER BY id_standar ASC"
);

if (!$query_standar) {
    die("Gagal mengambil data standar: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Standar Parameter | TambakCare</title>

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

    <!-- KONTEN -->
    <div class="container py-5">

        <div class="row justify-content-center">
            <div class="col-12 col-lg-8 col-xl-7">

                <!-- JUDUL -->
                <div class="mb-4 text-center">

                    <div class="d-flex align-items-center justify-content-center mx-auto mb-3"
                         style="width:70px; height:70px; border-radius:20px; background:#DCEEFF; color:#1675D1; font-size:32px;">

                        <i class="bi bi-sliders"></i>

                    </div>

                    <h2 class="fw-bold mb-2" style="color:#0B315B;">
                        Standar Parameter Air
                    </h2>

                    <p class="text-secondary mb-0">
                        Atur batas nilai minimum dan maksimum parameter kualitas air tambak.
                    </p>

                </div>

                <!-- CARD FORM -->
                <div class="card border-0 shadow-sm"
                     style="border-radius:20px; overflow:hidden;">

                    <div class="card-header border-0 p-4"
                         style="background:linear-gradient(135deg,#1675D1,#1687A8); color:white;">

                        <h5 class="fw-bold mb-1">
                            <i class="bi bi-clipboard-check me-2"></i>
                            Formulir Standar Parameter
                        </h5>

                        <p class="mb-0 small" style="opacity:0.9;">
                            Halaman khusus administrator.
                        </p>

                    </div>

                    <div class="card-body p-4 p-md-5">

                        <?php if (isset($_GET['status']) && $_GET['status'] === 'berhasil') { ?>
                            <div class="alert alert-success">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                Standar parameter berhasil diperbarui.
                            </div>
                        <?php } ?>

                        <?php if (isset($_GET['status']) && $_GET['status'] === 'gagal') { ?>
                            <div class="alert alert-danger">
                                <i class="bi bi-exclamation-circle-fill me-2"></i>
                                Data gagal disimpan. Periksa kembali input kamu.
                            </div>
                        <?php } ?>

                        <form action="proses_standar.php" method="post">

                            <!-- NAMA PARAMETER -->
                            <div class="mb-4">

                                <label for="nama_parameter"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Nama Parameter <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-droplet-half"></i>
                                    </span>

                                    <select class="form-select"
                                            id="nama_parameter"
                                            name="nama_parameter"
                                            required>

                                        <option value="">-- Pilih Parameter --</option>
                                        <option value="Suhu">Suhu</option>
                                        <option value="pH">pH</option>
                                        <option value="DO">DO (Oksigen Terlarut)</option>
                                        <option value="Salinitas">Salinitas</option>

                                    </select>

                                </div>
                            </div>

                            <!-- NILAI MINIMUM -->
                            <div class="mb-4">

                                <label for="nilai_min"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Nilai Minimum <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-arrow-down-circle"></i>
                                    </span>

                                    <input type="number"
                                           class="form-control"
                                           id="nilai_min"
                                           name="nilai_min"
                                           placeholder="Masukkan batas minimum"
                                           step="0.01"
                                           required>

                                </div>
                            </div>

                            <!-- NILAI MAKSIMUM -->
                            <div class="mb-4">

                                <label for="nilai_max"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Nilai Maksimum <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-arrow-up-circle"></i>
                                    </span>

                                    <input type="number"
                                           class="form-control"
                                           id="nilai_max"
                                           name="nilai_max"
                                           placeholder="Masukkan batas maksimum"
                                           step="0.01"
                                           required>

                                </div>
                            </div>

                            <!-- SATUAN -->
                            <div class="mb-4">

                                <label for="satuan"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Satuan <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-rulers"></i>
                                    </span>

                                    <select class="form-select"
                                            id="satuan"
                                            name="satuan"
                                            required>

                                        <option value="">-- Pilih Satuan --</option>
                                        <option value="°C">°C (Suhu)</option>
                                        <option value="pH">pH</option>
                                        <option value="mg/L">mg/L (DO)</option>
                                        <option value="ppt">ppt (Salinitas)</option>

                                    </select>

                                </div>
                            </div>

                            <!-- SUMBER ACUAN -->
                            <div class="mb-4">

                                <label for="sumber_acuan"
                                       class="form-label fw-semibold"
                                       style="color:#0B315B;">
                                    Sumber Acuan
                                </label>

                                <div class="input-group">

                                    <span class="input-group-text"
                                          style="background:#EFF6FF; color:#1675D1;">
                                        <i class="bi bi-journal-text"></i>
                                    </span>

                                    <input type="text"
                                           class="form-control"
                                           id="sumber_acuan"
                                           name="sumber_acuan"
                                           placeholder="Masukkan sumber referensi">

                                </div>

                                <small class="text-secondary">
                                    Kosongkan jika ingin mempertahankan sumber acuan sebelumnya.
                                </small>

                            </div>

                            <!-- INFORMASI -->
                            <div class="alert alert-info border-0 small"
                                 style="border-radius:10px;">

                                <i class="bi bi-info-circle-fill me-2"></i>

                                Masukkan nilai berdasarkan referensi standar kualitas air
                                yang dapat dipertanggungjawabkan. Pastikan satuan sesuai
                                dengan parameter yang dipilih.

                            </div>

                            <!-- TOMBOL -->
                            <div class="d-flex flex-column flex-sm-row gap-2 mt-4">

                                <button type="submit"
                                        class="btn fw-semibold text-white flex-fill"
                                        style="padding:12px; border:0; border-radius:10px; background:linear-gradient(135deg,#1675D1,#1687A8);">

                                    <i class="bi bi-save-fill me-2"></i>
                                    Simpan Perubahan

                                </button>

                                <button type="reset"
                                        class="btn btn-outline-secondary flex-fill fw-semibold"
                                        style="padding:12px; border-radius:10px;">

                                    <i class="bi bi-arrow-counterclockwise me-2"></i>
                                    Reset Form

                                </button>

                            </div>

                        </form>

                    </div>
                </div>

                <!-- TABEL STANDAR -->
                <div class="card border-0 shadow-sm mt-4"
                     style="border-radius:20px; overflow:hidden;">

                    <div class="card-header border-0 p-4"
                         style="background:linear-gradient(135deg,#1675D1,#1687A8); color:white;">

                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-table me-2"></i>
                            Data Standar Saat Ini
                        </h5>

                    </div>

                    <div class="card-body p-0">

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th class="text-center">No.</th>
                                        <th>Parameter</th>
                                        <th>Minimum</th>
                                        <th>Maksimum</th>
                                        <th>Satuan</th>
                                        <th>Sumber Acuan</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    <?php
                                    $no = 1;

                                    if (mysqli_num_rows($query_standar) > 0) {
                                        while ($data = mysqli_fetch_assoc($query_standar)) {
                                    ?>

                                        <tr>
                                            <td class="text-center">
                                                <?= $no++; ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['nama_parameter']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['nilai_min']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['nilai_max']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['satuan']); ?>
                                            </td>

                                            <td>
                                                <?= htmlspecialchars($data['sumber_acuan']); ?>
                                            </td>
                                        </tr>

                                    <?php
                                        }
                                    } else {
                                    ?>

                                        <tr>
                                            <td colspan="6" class="text-center py-3">
                                                Belum ada data standar parameter.
                                            </td>
                                        </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <div class="text-center mt-4">
                    <p class="text-secondary small">
                        <i class="bi bi-shield-check me-1"></i>
                        TambakCare &copy; <?= date('Y') ?>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>