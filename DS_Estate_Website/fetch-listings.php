<?php
require 'database.php';

header('Content-Type: application/json');

$response = array('success' => false, 'listings' => array());

try {
    $stmt = $pdo->query("SELECT * FROM listings");
    $listings = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    if ($listings) {
        $response['success'] = true;
        $response['listings'] = $listings;
    } else {
        $response['message'] = 'No listings found.';
    }
} catch (PDOException $e) {
    $response['message'] = 'Database error: ' . $e->getMessage();
}

echo json_encode($response);
?>