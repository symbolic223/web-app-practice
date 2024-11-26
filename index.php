<?php
session_start();

if (isset($_SESSION['user_id'])) {
    header("Location: /views/dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добро пожаловать</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class="container-index">
    <h1>Добро пожаловать на персональную страницу</h1>
    <p>Пожалуйста, зарегистрируйтесь или войдите в систему, чтобы продолжить.</p>
    <div class="links">
        <a href="/views/register.php" class="btn">Регистрация</a>
        <a href="/views/login.php" class="btn">Вход</a>
    </div>
</div>
</body>
</html>
