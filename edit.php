<?php
session_start();
$index = $_GET['index'] ?? -1;

if (!isset($_SESSION['tasks'][$index])) {
    echo "Tugas tidak ditemukan.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['tasks'][$index] = [
        'nama' => $_POST['nama'],
        'waktu' => $_POST['waktu']
    ];
    header("Location: detail.php?index=$index");
    exit();
}

$tugas = $_SESSION['tasks'][$index];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Tugas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h2>Edit Tugas</h2>
    <form method="post">
        <input type="text" name="nama" value="<?= htmlspecialchars($tugas['nama']) ?>" required>
        <input type="number" name="waktu" value="<?= htmlspecialchars($tugas['waktu']) ?>" required>
        <button type="submit">Simpan Perubahan</button>
    </form>
</div>
</body>
</html>
