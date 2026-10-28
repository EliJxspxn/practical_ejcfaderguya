<?php
require_once 'config.php';
require_auth();

$stmt = $pdo->query("SELECT * FROM students ORDER BY id DESC");
$students = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Directory</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Student Portal</a>
        <div class="d-flex align-items-center text-white">
            <span class="me-3">Welcome, <strong><?= sanitize($_SESSION['username']); ?></strong></span>
            <a href="logout.php" class="btn btn-outline-light btn-sm">Logout</a>
        </div>
    </div>
</nav>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Enrolled Students</h2>
        <a href="create_student.php" class="btn btn-success">+ Add New Student</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Student No.</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Course</th>
                <th>Year Level</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (count($students) > 0): ?>
                <?php foreach ($students as $student): ?>
                    <tr>
                        <td><?= sanitize($student['student_number']); ?></td>
                        <td><?= sanitize($student['first_name'] . ' ' . $student['last_name']); ?></td>
                        <td><?= sanitize($student['email']); ?></td>
                        <td><?= sanitize($student['course']); ?></td>
                        <td><?= sanitize((string)$student['year_level']); ?></td>
                        <td>
                            <a href="edit_student.php?id=<?= $student['id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                            <a href="delete_student.php?id=<?= $student['id']; ?>" 
                               class="btn btn-danger btn-sm" 
                               onclick="return confirm('Are you sure you want to delete this record?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No student records found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>