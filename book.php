<?php
include 'database.php'; // Include your database connection file

$data = json_decode(file_get_contents("php://input"), true);
$property_id = $data['property_id'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];
$name = $data['name'];
$surname = $data['surname'];
$email = $data['email'];

try {
    // Prepare SQL statement
    $stmt = $pdo->prepare('INSERT INTO bookings (property_id, start_date, end_date, name, surname, email) 
                           VALUES (?, ?, ?, ?, ?, ?)');
    
    // Bind parameters and execute
    $stmt->execute([$property_id, $start_date, $end_date, $name, $surname, $email]);

    // Response in JSON format
    echo json_encode(['status' => 'success', 'message' => 'Booking successful']);

} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['status' => 'error', 'message' => 'Booking failed: ' . $e->getMessage()]);
}
?>
