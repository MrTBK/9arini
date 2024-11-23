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
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        alertAndRedirect('Email and password are required.', '../html/login.html');
    }

    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['section'] = $user['section'];

            header("Location: ../html/matiere.html");
            exit;
        } else {
            alertAndRedirect('Invalid email or password.', '../html/login.html');
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function alertAndRedirect($message, $url) {
    echo "<script>alert('$message'); window.location.href = '$url';</script>";
    exit;
}
?>
<?php
session_start();

// After successful login
if ($login_successful) {
    // Set the session
    $_SESSION['section'] = $user_section;  // Make sure you have a variable $user_section that holds the section value
    header("Location: matiere.php");
    exit;
}
?>
