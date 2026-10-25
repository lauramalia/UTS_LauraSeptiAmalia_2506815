<?php
session_start();
include('koneksi.php');

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($koneksi, 
    "SELECT * FROM users 
     WHERE username = '$username' 
     AND password_hash = MD5('$password')"
);

$data = mysqli_fetch_assoc($query);

if ($data) {
    $_SESSION['id_user'] = $data['id_user'];
    $_SESSION['nama'] = $data['nama'];
    $_SESSION['username'] = $data['username'];
    $_SESSION['role'] = $data['role'];

    if ($data['role'] == 'admin') {
        header("Location: main_admin.php");
    } else {
        header("Location: main_petugas.php");
    }
    exit;
} 
?>