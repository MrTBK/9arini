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
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    if (empty($email) || empty($password)) {
        echo "<script>alert('Email and password are required.'); window.location.href = '../html/login.html';</script>";
        exit;
    }
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['section'] = $user['section'];
                switch ($user['section']) {
                    case 'math':
                        header("Location: ../html/math.html");break;
                    case 'science':
                        header("Location: ../html/science.html");break;
                    case 'info':
                        header("Location: ../html/info.html");break;
                    case 'lettres':
                        header("Location: ../html/lettres.html");break;
                    case 'eco':
                        header("Location: ../html/eco.html");break;
                    case 'tech':
                        header("Location: ../html/tech.html");break;
                }
                exit;
            } else {
                echo "<script>alert('Incorrect password.'); window.location.href = '../html/login.html';</script>";
                exit;
            }
        } else {
            echo "<script>alert('Email not found.'); window.location.href = '../html/login.html';</script>";
            exit;
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
