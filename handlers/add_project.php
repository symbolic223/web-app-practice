<?php
global $pdo;
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Вы не авторизованы.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];

    if (addProject($pdo, $_SESSION['user_id'], $title, $description)) {
        header("Location: /views/dashboard.php?success=1");
    } else {
        header("Location: /views/dashboard.php?error=1");
    }
    exit();
}
?>
