<?php
include 'database.php';
session_start();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    
	$username = $data['username'];
    $password = $data['password'];

    // Fetch user data from the database
    $stmt = $pdo->prepare('SELECT * FROM users WHERE username = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $username;	// Set session variable
		
		// Set a cookie to indicate the user is logged in
		$cookie_name = "user_logged_in";
		$cookie_value = "true";
		setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/"); // 30 days expiration, "/" path
		
		// Set a cookie for the user_id
        $user_id_cookie_name = "user_id";
        $user_id_cookie_value = $user['id'];
        setcookie($user_id_cookie_name, $user_id_cookie_value, time() + (86400 * 30), "/"); // 30 days expiration, "/" path
		
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username or password']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>