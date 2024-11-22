<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

session_start();
if (!isset($_SESSION['user_id'])) {
    die("Вы не авторизованы.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $projectId = $_POST['project_id'];

    if (deleteProject($pdo, $projectId, $_SESSION['user_id'])) {
        header("Location: /views/dashboard.php?success=1");
    } else {
        header("Location: /views/dashboard.php?error=1");
    }
    exit();
}
?>
