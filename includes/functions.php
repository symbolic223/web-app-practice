<?php
function addProject($pdo, $userId, $title, $description) {
    try {
        $stmt = $pdo->prepare("INSERT INTO projects (user_id, title, description) VALUES (:user_id, :title, :description)");
        $stmt->execute([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Ошибка при добавлении проекта: " . $e->getMessage());
        return false;
    }
}


function deleteProject($pdo, $projectId, $userId) {
    try {
        $stmt = $pdo->prepare("DELETE FROM projects WHERE id = :project_id AND user_id = :user_id");
        $stmt->execute([
            'project_id' => $projectId,
            'user_id' => $userId
        ]);
        return $stmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Ошибка при удалении проекта: " . $e->getMessage());
        return false;
    }
}
