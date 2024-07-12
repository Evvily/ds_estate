<?php
include 'database.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents('php://input'), true);
$start_date = $data['startDate'];
$end_date = $data['endDate'];
$listing_id = $data['listingId'];

$stmt = $pdo->prepare('SELECT * FROM reservations 
                    WHERE listing_id = ? AND 
                    (
                        (? BETWEEN start_date AND end_date) 
                        OR (? BETWEEN start_date AND end_date) 
                        OR (start_date BETWEEN ? AND ?)
                        OR (end_date BETWEEN ? AND ?)
                    )');
$stmt->execute([$listing_id, $start_date, $end_date, $start_date, $end_date, $start_date, $end_date]);
$reservation = $stmt->fetch(PDO::FETCH_ASSOC);

if ($reservation) {
    echo json_encode(['status' => 'unavailable']);
} else {
    echo json_encode(['status' => 'available']);
}
?>