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

$stmt = $pdo->prepare("SELECT name, email, bio FROM users WHERE id = :id");
$stmt->execute(['id' => $userId]);
$user = $stmt->fetch();

$projectsStmt = $pdo->prepare("SELECT id, title, description, created_at FROM projects WHERE user_id = :user_id ORDER BY created_at DESC");
$projectsStmt->execute(['user_id' => $userId]);
$projects = $projectsStmt->fetchAll();


$successMessage = isset($_GET['success']) ? $_GET['success'] : '';
$errorMessage = isset($_GET['error']) ? $_GET['error'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
<div class = "dashboard">
    <header>
        <h1>Добро пожаловать, <?= htmlspecialchars($user['name']); ?>!</h1>
        <nav>
            <a href="/views/manage_projects.php" class="btn-secondary">Управление проектами</a>
            <a href="/handlers/logout.php" class="btn-danger">Выйти</a>
        </nav>
    </header>
    <main>
        <?php if ($successMessage === 'bio_updated'): ?>
            <div class="alert alert-success">Информация о себе успешно обновлена!</div>
        <?php elseif ($errorMessage === 'bio_update_failed'): ?>
            <div class="alert alert-danger">Ошибка при обновлении информации о себе.</div>
        <?php endif; ?>

        <section>
            <h2>О себе</h2>
            <p id="bio-text"><?= htmlspecialchars($user['bio']) ?: 'Вы еще не добавили информацию о себе.'; ?></p>
            <button class="btn-primary" onclick="openEditModal()">Изменить</button>
        </section>

        <section>
            <h2>Ваши проекты</h2>
            <?php if (!empty($projects)): ?>
                <?php foreach ($projects as $project): ?>
                    <div class="project-card">
                        <h3><?= htmlspecialchars($project['title']); ?></h3>
                        <p><?= htmlspecialchars($project['description']); ?></p>
                        <small>Добавлено: <?= htmlspecialchars($project['created_at']); ?></small>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>У вас пока нет проектов. <a href="/views/manage_projects.php">Добавьте первый проект.</a></p>
            <?php endif; ?>
        </section>
        <div class="section">
            <h2>Обратная связь</h2>
            <form action="../handlers/feedback.php" method="POST">
                <textarea name="feedback" rows="4" placeholder="Напишите ваш отзыв"></textarea>
                <button type="submit" class="btn-primary">Отправить</button>
            </form>
        </div>
    </main>
</div>


<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeEditModal()">&times;</span>
        <h3>Редактировать "О себе"</h3>
        <form method="POST" action="/handlers/update_bio.php">
            <textarea name="bio" rows="5" placeholder="Введите информацию о себе..."><?= htmlspecialchars($user['bio']); ?></textarea>
            <button type="submit" class="btn-primary">Сохранить</button>
        </form>
    </div>
</div>

<script>
    const modal = document.getElementById('editModal');

    function openEditModal() {
        modal.style.display = 'flex';
    }

    function closeEditModal() {
        modal.style.display = 'none';
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    }
</script>
</body>
</html>
