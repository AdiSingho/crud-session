<?php
session_start();

// Inisialisasi session
if (!isset($_SESSION['tugas'])) {
    $_SESSION['tugas'] = [];
}

// Handle POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $method = $_GET['method'] ?? '';
    switch ($method) {
        case 'tambah':
            $nama = $_POST['nama'] ?? '';
            $waktu = $_POST['waktu'] ?? '';
            if ($nama && $waktu) {
                $_SESSION['tugas'][] = ['nama' => $nama, 'waktu' => $waktu];
            }
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        case 'hapus':
            $id = $_POST['id'] ?? -1;
            if (isset($_SESSION['tugas'][$id])) {
                unset($_SESSION['tugas'][$id]);
                $_SESSION['tugas'] = array_values($_SESSION['tugas']); // reset index
            }
            header("Location: " . $_SERVER['PHP_SELF']);
            exit;
        case 'update':
            $id = $_POST['id'] ?? -1;
            $nama = $_POST['nama'] ?? '';
            $waktu = $_POST['waktu'] ?? '';
            if (isset($_SESSION['tugas'][$id]) && $nama && $waktu) {
                $_SESSION['tugas'][$id] = ['nama' => $nama, 'waktu' => $waktu];
            }
            header("Location: " . $_SERVER['PHP_SELF'] . "?method=detail&id=$id");
            exit;
    }
}

// Handle GET
$method = $_GET['method'] ?? '';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Work Tracker</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 30px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
        }
        form input, form button {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        form button {
            background: #28a745;
            color: white;
            font-weight: bold;
        }
        a {
            color: #007bff;
            margin-right: 10px;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
        ol {
            padding-left: 20px;
        }
        .actions {
            display: inline;
        }
        .delete-form {
            display: inline;
        }
        .btn-hapus-semua {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 6px;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="container">
<?php
switch ($method) {
    case 'edit':
        $id = $_GET['id'] ?? -1;
        if (!isset($_SESSION['tugas'][$id])) {
            echo "<p>Tugas tidak ditemukan.</p><a href='?'>← Kembali</a>";
            break;
        }
        $data = $_SESSION['tugas'][$id];
        ?>
        <h2>Edit Tugas</h2>
        <form method="post" action="?method=update">
            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" required>
            <input type="number" name="waktu" value="<?= htmlspecialchars($data['waktu']) ?>" required>
            <button type="submit">Simpan Perubahan</button>
        </form>
        <p><a href="?">← Kembali ke daftar</a></p>
        <?php
        break;

    case 'detail':
        $id = $_GET['id'] ?? -1;
        if (!isset($_SESSION['tugas'][$id])) {
            echo "<p>Tugas tidak ditemukan.</p><a href='?'>← Kembali</a>";
            break;
        }
        $data = $_SESSION['tugas'][$id];
        ?>
        <h2>Detail Tugas</h2>
        <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama']) ?></p>
        <p><strong>Waktu:</strong> <?= htmlspecialchars($data['waktu']) ?> jam</p>
        <p><a href="?">← Kembali ke daftar</a></p>
        <?php
        break;

    case 'hapus-semua':
        session_destroy();
        header("Location: " . $_SERVER['PHP_SELF']);
        exit;
        break;

    default:
        ?>
        <h1>Work Tracker</h1>
        <h2>Tambah Tugas</h2>
        <form method="post" action="?method=tambah">
            <input type="text" name="nama" placeholder="Nama Tugas" required>
            <input type="number" name="waktu" placeholder="Waktu (jam)" required>
            <button type="submit">Simpan</button>
        </form>

        <h2>Daftar Tugas</h2>
        <?php if (!empty($_SESSION['tugas'])): ?>
            <ol>
                <?php foreach ($_SESSION['tugas'] as $i => $t): ?>
                    <li>
                        <?= htmlspecialchars($t['nama']) ?> (<?= htmlspecialchars($t['waktu']) ?> jam)
                        <a href="?method=detail&id=<?= $i ?>">Detail</a>
                        <a href="?method=edit&id=<?= $i ?>">Edit</a>
                        <form class="delete-form" method="post" action="?method=hapus" onsubmit="return confirm('Yakin ingin menghapus tugas ini?')">
                            <input type="hidden" name="id" value="<?= $i ?>">
                            <button type="submit">Hapus</button>
                        </form>
                    </li>
                <?php endforeach; ?>
            </ol>
            <form method="get" action="">
                <input type="hidden" name="method" value="hapus-semua">
                <button class="btn-hapus-semua" type="submit" onclick="return confirm('Hapus semua tugas?')">Hapus Semua</button>
            </form>
        <?php else: ?>
            <p>Belum ada tugas.</p>
        <?php endif; ?>
        <?php
        break;
}
?>
</div>
</body>
</html>
