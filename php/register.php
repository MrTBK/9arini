<?php
session_start();
$host = "localhost";
$dbname = "9arini";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $lastname = trim($_POST['lastname'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $section = $_POST['section'] ?? null;
    $password = trim($_POST['password'] ?? '');

    if (!$name || !$lastname || !$email || !$section || !$password) {
        alertAndRedirect('All fields are required.', '../html/signin.html');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        alertAndRedirect('Invalid email format.', '../html/signin.html');
    }

    $validSections = ['math', 'science', 'info', 'lettres', 'eco'];
    if (!in_array($section, $validSections)) {
        alertAndRedirect('Invalid section selected.', '../html/signin.html');
    }

    try {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->rowCount() > 0) {
            alertAndRedirect('Email is already registered.', '../html/login.html');
        }

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $pdo->prepare("INSERT INTO users (name, lastname, email, section, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $lastname, $email, $section, $hashedPassword]);

        alertAndRedirect('Registration successful!', '../html/login.html');
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function alertAndRedirect($message, $url) {
    echo "<script>alert('$message'); window.location.href = '$url';</script>";
    exit;
}
?>
