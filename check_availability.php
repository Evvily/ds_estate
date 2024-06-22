<?php
include 'database.php'; // Include your database connection file

$data = json_decode(file_get_contents("php://input"), true);
$property_id = $data['property_id'];
$start_date = $data['start_date'];
$end_date = $data['end_date'];

try {
    // Prepare SQL statement
    $stmt = $pdo->prepare('SELECT * FROM bookings WHERE property_id = ? AND start_date <= ? AND end_date >= ?');
    
    // Execute SQL statement with parameters
    $stmt->execute([$property_id, $end_date, $start_date]);
    
    // Fetch the first row (if any)
    $booking = $stmt->fetch();

    // Check if there's a booking that overlaps
    if ($booking) {
        echo json_encode(['status' => 'unavailable']);
    } else {
        echo json_encode(['status' => 'available']);
    }

} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
