<?php
include 'database.php';
header('Content-Type: application/json');

// Get data from book-handle.js
$data = json_decode(file_get_contents('php://input'), true);
$user_id = $data['userId'];
$listing_id = $data['listingId'];
$start_date = $data['startDate'];
$end_date = $data['endDate'];
$final_amount = $data['finalAmount'];


// Insert into database
$stmt = $pdo->prepare('INSERT INTO reservations (user_id, listing_id, start_date, end_date, final_amount) VALUES (?, ?, ?, ?, ?)');
$success = $stmt->execute([$user_id, $listing_id, $start_date, $end_date, $final_amount]);

if ($success) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error']);
}
?>
