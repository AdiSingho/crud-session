<?php
session_start();
if (!isset($_SESSION['tasks'])) {
    $_SESSION['tasks'] = [];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Daftar Tugas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Daftar Tugas</h1>
    <a href="add.php">➕ Tambah Tugas</a>
    <ol>
        <?php if (!empty($_SESSION['tasks'])): ?>
            <?php foreach ($_SESSION['tasks'] as $index => $task): ?>
                <li>
                    <?= htmlspecialchars($task['nama'] ?? 'Tidak diketahui') ?>
                    (<?= htmlspecialchars($task['waktu'] ?? '-') ?> jam)
                    <a href="detail.php?index=<?= $index ?>">Detail</a>
                    <a href="edit.php?index=<?= $index ?>">Edit</a>
                    <a href="delete.php?index=<?= $index ?>" onclick="return confirm('Yakin hapus tugas ini?')">Hapus</a>
                </li>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Tidak ada tugas tersimpan.</p>
        <?php endif; ?>
    </ol>
</div>
</body>
</html>
