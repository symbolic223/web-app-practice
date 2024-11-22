<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
global $pdo;
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

    try {
        $stmt->execute([
            'name' => $name,
            'email' => $email,
            'password' => $hashedPassword
        ]);
        $userId = $pdo->lastInsertId();
        $_SESSION['user_id'] = $userId;
        header("Location: /views/dashboard.php");
        exit();
    } catch (Exception $e) {
        header("Location: /views/register.php?error=Ошибка регистрации, попробуйте снова");
        exit();
    }
}
