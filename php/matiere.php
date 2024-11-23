<?php
session_start();
if (!isset($_SESSION['section'])) {
    header("Location: login.php");
    exit;
}
$icons = [
    'info' => ['arb', 'fr', 'eng', 'philo', 'mathinfo', 'phyinfo', 'prog', 'sti'],
    'math' => ['arb', 'fr', 'eng', 'philo', 'mathmath', 'phymath', 'info'],
    'science' => ['arb', 'fr', 'eng', 'philo', 'mathmath', 'phymath', 'info'],
    'lettres' => ['arb', 'fr', 'eng', 'philo', 'mathsc', 'physc', 'info'],
    'eco' => ['arb', 'fr', 'eng', 'philo', 'matheco', 'infoeco'],
    'tech' => ['arb', 'fr', 'eng', 'philo', 'mathtech', 'phytech', 'info']
];
$section = $_SESSION['section'];
$subjects = $icons[$section] ?? [];
header('Content-Type: application/json');
echo json_encode([
    'section' => $section,
    'subjects' => $subjects
]);
exit;
