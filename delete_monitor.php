<?php
session_start();
include('koneksi.php');

if (!isset($_SESSION['id_user'])) {
    header('Location: login.php');
    exit;
}

$id = (int) ($_GET['id'] ?? 0);

$query = "DELETE FROM monitoring_air WHERE id_monitoring = $id";

if (mysqli_query($koneksi, $query)) {
    header('Location: main_petugas.php');
} else {
    header('Location: main_petugas.php');
}
exit;
?>