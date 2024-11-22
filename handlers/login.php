<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
global $pdo;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        header("Location: /views/dashboard.php");
        exit();
    } else {
        header("Location: /views/login.php?error=Неверный логин или пароль");
        exit();
    }
}
