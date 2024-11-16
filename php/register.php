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
    $name = trim($_POST['name']);
    $lastname = trim($_POST['lastname']);
    $email = trim($_POST['email']);
    $section = isset($_POST['section']) ? $_POST['section'] : null;
    $password = trim($_POST['password']);
    if (empty($name) || empty($lastname) || empty($email) || empty($section) || empty($password)) {
        echo "<script>alert('All fields are required.'); window.location.href = '../html/signin.html';</script>";
        exit;
    }
    if (!in_array($section, ['math', 'science', 'info', 'lettres', 'eco'])) {
        echo "<script>alert('Invalid section selected.'); window.location.href = '../html/signin.html';</script>";
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format.')";
        exit;
    }
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "<script>alert('Email is already registered'); window.location.href = '../html/login.html';</script>";
            exit;
        }
        $stmt = $pdo->prepare("INSERT INTO users (name, lastname, email, section, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$name, $lastname, $email, $section, $hashedPassword]);
        echo "<script>alert('Registration is done!'); window.location.href = '../html/login.html';</script>";
        exit;
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
