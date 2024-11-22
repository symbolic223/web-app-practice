<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
global $pdo;
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /views/login.php");
    exit();
}

$userId = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id, title, description, created_at FROM projects WHERE user_id = :user_id ORDER BY created_at DESC");
$stmt->execute(['user_id' => $userId]);
$projects = $stmt->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление проектами</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<header>
    <h1>Управление проектами</h1>
    <a href="/views/dashboard.php" class="btn-secondary">Вернуться на главную</a>
</header>
<main>
    <section>
        <h2>Добавить проект</h2>
        <form method="POST" action="/handlers/add_project.php" class="form-horizontal">
            <input type="text" name="title" placeholder="Название проекта" required>
            <textarea name="description" placeholder="Описание проекта" required></textarea>
            <button type="submit" class="btn-primary">Добавить</button>
        </form>
    </section>


    <section>
        <h2>Ваши проекты</h2>
        <?php if (count($projects) > 0): ?>
            <div class="projects-list">
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <h3><?= htmlspecialchars($project['title']); ?></h3>
                        <p><?= htmlspecialchars($project['description']); ?></p>
                        <small>Добавлено: <?= htmlspecialchars($project['created_at']); ?></small>
                        <form method="POST" action="/handlers/delete_project.php" style="margin-top: 10px;">
                            <input type="hidden" name="project_id" value="<?= $project['id']; ?>">
                            <button type="submit" class="btn-danger">Удалить</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <p>У вас пока нет проектов. Добавьте свой первый проект!</p>
        <?php endif; ?>
    </section>
</main>
</body>
</html>
