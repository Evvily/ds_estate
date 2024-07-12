<?php
include 'database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$user_id = $_COOKIE['user_id'];

$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if ($user) {
    echo json_encode(['name' => $user['name'], 'surname' => $user['surname'], 'email' => $user['email']]);
} else {
    echo json_encode(['status' => 'error']);
}
?>
