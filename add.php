<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $_POST['nama'];
    $waktu = $_POST['waktu'];

    $_SESSION['tasks'][] = ['nama' => $nama, 'waktu' => $waktu];
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tambah Tugas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Tambah Tugas</h2>
    <form method="post">
        <input type="text" name="nama" placeholder="Nama Tugas" required>
        <input type="number" name="waktu" placeholder="Waktu (jam)" required>
        <button type="submit">Simpan</button>
    </form>
</div>
</body>
</html>
