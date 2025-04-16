<?php
session_start();
$index = $_GET['index'] ?? -1;

if (isset($_SESSION['tasks'][$index])) {
    unset($_SESSION['tasks'][$index]);
    $_SESSION['tasks'] = array_values($_SESSION['tasks']); // Reset index
}

header("Location: index.php");
exit();
