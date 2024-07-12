<?php
require 'database.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $property_id = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM listings WHERE id = ?");
        $stmt->execute([$property_id]);
        $property = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($property) {
            echo json_encode(['success' => true, 'property' => $property]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Property not found.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'No property ID provided.']);
}
?>
