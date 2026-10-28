<?php
// delete_student.php
require_once 'config.php';
require_auth();

$id = filter_var($_GET['id'] ?? '', FILTER_VALIDATE_INT);

if ($id) {
    // Prepared Statement for Safe Deletion
    $stmt = $pdo->prepare("DELETE FROM students WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header('Location: index.php');
exit();
?>