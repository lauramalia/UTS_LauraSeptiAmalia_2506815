<?php
include('koneksi.php');

$id   = $_GET['id'];
$data = mysqli_fetch_assoc(mysqli_query($koneksi, "select * from monitoring_air where id_monitoring = '$id'"));
$tambak = mysqli_query($koneksi, "select * from tambak");
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Monitoring</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4" style="max-width:600px;">
    <h3>Edit Data Monitoring</h3>

    <form action="proses_update.php" method="POST">
        <input type="hidden" name="id_monitoring" value="<?= $data['id_monitoring'] ?>">

        Nama Tambak
        <select name="id_tambak" class="form-select mb-2">
            <?php while ($t = mysqli_fetch_assoc($tambak)) { ?>
                <option value="<?= $t['id_tambak'] ?>" <?= $t['id_tambak'] == $data['id_tambak'] ? 'selected' : '' ?>>
                    <?= $t['nama_tambak'] ?>
                </option>
            <?php } ?>
        </select>

        Tanggal
        <input type="datetime-local" name="tanggal" class="form-control mb-2" value="<?= date('Y-m-d\TH:i', strtotime($data['tanggal'])) ?>">

        Suhu
        <input type="number" step="0.01" name="suhu" class="form-control mb-2" value="<?= $data['suhu'] ?>">

        pH
        <input type="number" step="0.01" name="ph" class="form-control mb-2" value="<?= $data['ph'] ?>">

        Salinitas
        <input type="number" step="0.01" name="salinitas" class="form-control mb-2" value="<?= $data['salinitas'] ?>">

        Oksigen Terlarut
        <input type="number" step="0.01" name="oksigen_terlarut" class="form-control mb-2" value="<?= $data['oksigen_terlarut'] ?>">

        Keterangan
        <textarea name="keterangan" class="form-control mb-3"><?= $data['keterangan'] ?></textarea>

        <button type="submit" class="btn btn-warning">Simpan</button>
        <a href="main_petugas.php" class="btn btn-secondary">Batal</a>
    </form>
</body>
</html>