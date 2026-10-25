<?php
include('koneksi.php');

$id_monitoring    = $_POST['id_monitoring'];
$id_tambak        = $_POST['id_tambak'];
$tanggal          = str_replace('T', ' ', $_POST['tanggal']) . ':00';
$suhu             = $_POST['suhu'];
$ph               = $_POST['ph'];
$salinitas        = $_POST['salinitas'];
$oksigen_terlarut = $_POST['oksigen_terlarut'];
$keterangan       = $_POST['keterangan'];

$query = "update monitoring_air set id_tambak = '$id_tambak', tanggal = '$tanggal', suhu = '$suhu', ph = '$ph', salinitas = '$salinitas', oksigen_terlarut = '$oksigen_terlarut', keterangan = '$keterangan'
          where id_monitoring = '$id_monitoring'";

if (mysqli_query($koneksi, $query)) {
    header('location:main_petugas.php');
} else {
    header('location:update.php?id=' . $id_monitoring);
}
?>