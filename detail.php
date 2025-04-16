<?php
session_start();
$index = $_GET['index'] ?? -1;

if (!isset($_SESSION['tasks'][$index])) {
    echo "Tugas tidak ditemukan.";
    exit();
}

$tugas = $_SESSION['tasks'][$index];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Detail Tugas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Detail Tugas</h2>
    <p><strong>Nama:</strong> <?= htmlspecialchars($tugas['nama']) ?></p>
    <p><strong>Waktu:</strong> <?= htmlspecialchars($tugas['waktu']) ?> jam</p>
    <a href="index.php">← Kembali ke daftar</a>
</div>
</body>
</html>
