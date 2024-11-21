<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit();
}

echo "<h1>Добро пожаловать, " . $_SESSION['user_name'] . "!</h1>";
echo "<a href='/handlers/logout.php'>Выйти</a>";
?>
