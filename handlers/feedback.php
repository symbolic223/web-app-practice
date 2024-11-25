<?php
global $pdo;
session_start();
require_once '../includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        header("Location: /views/login.php");
        exit();
    }

    $userId = $_SESSION['user_id'];
    $message = $_POST['feedback'];
    echo $message;
    $stmt = $pdo->prepare("INSERT INTO feedback (user_id, message) VALUES (:user_id, :message)");
    $stmt->execute(['user_id' => $userId, 'message' => $message]);

    header("Location: /views/dashboard.php");
    exit();
}
?>
