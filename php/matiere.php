<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

// Ensure session variables are set
if (!isset($_SESSION['section']) || !isset($_SESSION['role'])) {
    die(json_encode(['error' => 'Session variables not set']));
}

$icons = [
    'info' => ['arb', 'fr', 'eng', 'philo', 'mathinfo', 'phyinfo', 'prog', 'sti'],
    'math' => ['arb', 'fr', 'eng', 'philo', 'math', 'phy', 'info'],
    'science' => ['arb', 'fr', 'eng', 'philo', 'mathsc', 'physc', 'info', 'sc'],
    'lettres' => ['arbl', 'frl', 'engl', 'philol', 'info'],
    'eco' => ['arb', 'fr', 'eng', 'eco', 'gestion', 'philo', 'matheco', 'infoeco'],
    'tech' => ['arb', 'fr', 'eng', 'philo', 'mathtech', 'tech', 'phytech', 'info'],
    'admin' => ['arb', 'fr', 'eng', 'philo', 'tech', 'eco', 'gestion', 'arbl', 'frl', 'engl', 'philol', 'mathtech', 'phytech', 'info', 'mathinfo', 'phyinfo', 'prog', 'sti', 'math', 'phy', 'mathsc', 'physc', 'matheco', 'infoeco']
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
