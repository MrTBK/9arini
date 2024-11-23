<?php
session_start();
if (!isset($_SESSION['section']) || !isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}
$icons = [
    'info' => ['arb', 'fr', 'eng', 'philo', 'mathinfo', 'phyinfo', 'prog', 'sti'],
    'math' => ['arb', 'fr', 'eng', 'philo', 'mathmath', 'phymath', 'info'],
    'science' => ['arb', 'fr', 'eng', 'philo', 'mathmasc', 'phymasc', 'info'],
    'lettres' => ['arbl', 'frl', 'engl', 'philol', 'info'],
    'eco' => ['arb', 'fr', 'eng', 'philo', 'matheco', 'infoeco'],
    'tech' => ['arb', 'fr', 'eng', 'philo', 'mathtech', 'phytech', 'info'],
    'admin' => ['arb', 'fr', 'eng', 'philo','arbl', 'frl', 'engl', 'philol', 'mathtech', 'phytech', 'info', 'mathinfo', 'phyinfo', 'prog', 'sti', 'mathmath', 'phymath', 'mathmasc', 'phymasc', 'matheco', 'infoeco']
];
$role = $_SESSION['role'];
$section = $_SESSION['section'];
if ($role === 'admin') {
    $subjects = $icons['admin'];
} else {
    $subjects = $icons[$section] ?? [];
}
header('Content-Type: application/json');
echo json_encode([
    'section' => $section,
    'subjects' => $subjects
]);
exit;
