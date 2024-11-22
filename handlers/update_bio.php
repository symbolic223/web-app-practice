<?php
require_once '../includes/db.php';
global $pdo;
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bio = trim($_POST['bio']);
    $userId = $_SESSION['user_id'];

    try {
        $stmt = $pdo->prepare("UPDATE users SET bio = :bio WHERE id = :id");
        $stmt->execute(['bio' => $bio, 'id' => $userId]);

        header("Location: /views/dashboard.php?success=bio_updated");
        exit();
    } catch (Exception $e) {
        header("Location: /views/dashboard.php?error=bio_update_failed");
        exit();
    }
} else {
    header("Location: /views/dashboard.php");
    exit();
}
?>
