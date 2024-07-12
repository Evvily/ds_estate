<?php
include 'database.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $name = $data['name'];
    $surname = $data['surname'];
    $username = $data['username'];
    $password = password_hash($data['password'], PASSWORD_BCRYPT); // Hash the password
    $email = $data['email'];

    // Basic validation
    if (!preg_match('/^[\p{L}]+$/u', $name) || !preg_match('/^[\p{L}]+$/u', $surname)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and surname must contain only letters']);
        exit();
    }

    if (strlen($data['password']) < 4 || strlen($data['password']) > 10 || !preg_match('/\d/', $data['password'])) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be between 4 and 10 characters long and contain at least one number']);
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email format']);
        exit();
    }

    // Validate uniqueness of username and email
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ? OR email = ?');
    $stmt->execute([$username, $email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        echo json_encode(['status' => 'error', 'message' => 'Username or email already exists']);
    } else {
        // Insert new user
        $stmt = $pdo->prepare('INSERT INTO users (name, surname, username, password, email) VALUES (?, ?, ?, ?, ?)');
        if ($stmt->execute([$name, $surname, $username, $password, $email])) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Failed to register user']);
        }
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
