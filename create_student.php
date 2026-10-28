<?php
// create_student.php
require_once 'config.php';
require_auth();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_number = trim($_POST['student_number'] ?? '');
    $first_name     = trim($_POST['first_name'] ?? '');
    $last_name      = trim($_POST['last_name'] ?? '');
    $email          = trim($_POST['email'] ?? '');
    $course         = trim($_POST['course'] ?? '');
    $year_level     = filter_var($_POST['year_level'] ?? '', FILTER_VALIDATE_INT);

    // Basic Server-Side Input Validation
    if (empty($student_number)) $errors[] = "Student number is required.";
    if (empty($first_name))     $errors[] = "First name is required.";
    if (empty($last_name))      $errors[] = "Last name is required.";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "A valid email address is required.";
    if (empty($course))         $errors[] = "Course is required.";
    if ($year_level === false || $year_level < 1 || $year_level > 6) $errors[] = "Valid year level (1-6) is required.";

    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO students (student_number, first_name, last_name, email, course, year_level) 
                                   VALUES (:student_number, :first_name, :last_name, :email, :course, :year_level)");
            $stmt->execute([
                'student_number' => $student_number,
                'first_name'     => $first_name,
                'last_name'      => $last_name,
                'email'          => $email,
                'course'         => $course,
                'year_level'     => $year_level
            ]);
            header('Location: index.php');
            exit();
        } catch (PDOException $e) {
            $errors[] = "Database error: Duplicate student number or email address.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Student</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container my-5" style="max-width: 600px;">
    <h2>Add New Student</h2>
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <?php foreach ($errors as $error): ?>
                <p class="mb-0"><?= sanitize($error); ?></p>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Student Number</label>
            <input type="text" name="student_number" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">First Name</label>
            <input type="text" name="first_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Last Name</label>
            <input type="text" name="last_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Course</label>
            <input type="text" name="course" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Year Level</label>
            <input type="number" name="year_level" class="form-control" min="1" max="6" required>
        </div>
        <button type="submit" class="btn btn-primary">Save Student</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>