<?php
header('Content-Type: application/json');

$subject = $_GET['subject'] ?? null;

if (!$subject) {
    echo json_encode(['error' => 'Subject not provided']);
    exit;
}

$servername = "localhost";
$username = "root";
$password = ""; // Replace with your DB password
$dbname = "9arini"; // Your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['error' => 'Database connection failed']));
}

$sql = "SELECT * FROM cours WHERE subject = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $subject);
$stmt->execute();
$result = $stmt->get_result();

$courses = [];
while ($row = $result->fetch_assoc()) {
    $courses[] = $row;
}

$stmt->close();
$conn->close();

echo json_encode(['subject' => $subject, 'courses' => $courses]);
exit;
