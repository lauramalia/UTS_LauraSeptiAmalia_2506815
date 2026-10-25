<?php
include 'koneksi.php';

$username = 'abiocean07';
$password = 'bisean47564';

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT password_hash FROM users WHERE username = ?"
);

mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    echo "Username tidak ditemukan.";
} elseif (password_verify($password, $data['password_hash'])) {
    echo "Password cocok.";
} else {
    echo "Password tidak cocok dengan hash di database.";
}
?>