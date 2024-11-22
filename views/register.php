<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
global $pdo;
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /views/dashboard.php");
    exit();
}

$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="auth-container">
    <h1>Регистрация</h1>
    <form action="/handlers/register.php" method="POST">
        <input type="text" name="name" placeholder="Имя" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Пароль" required>
        <button type="submit" class="btn-primary">Зарегистрироваться</button>
    </form>
    <button onclick="window.location.href='/views/login.php'" class="btn-secondary">Уже есть аккаунт? Войти</button>
</div>

<div id="errorModal" class="modal" <?= $errorMessage ? 'style="display: flex;"' : ''; ?>>
    <div class="modal-content">
        <span class="close" onclick="closeErrorModal()">&times;</span>
        <p><?= htmlspecialchars($errorMessage); ?></p>
    </div>
</div>

<script>
    const errorModal = document.getElementById('errorModal');

    function closeErrorModal() {
        errorModal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === errorModal) {
            errorModal.style.display = 'none';
        }
    }
</script>
</body>
</html>
