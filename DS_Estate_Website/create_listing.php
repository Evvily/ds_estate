<?php
include 'database.php';

header('Content-Type: application/json');

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $region = $_POST['region'];
    $rooms = $_POST['rooms'];
    $price = $_POST['price'];
    $photo = $_FILES['photo'];

    // Basic validation
    if (!preg_match('/^[A-Za-z\s]+$/', $title)) {
        $response['message'] = 'Title must contain only characters';
        echo json_encode($response);
        exit();
    }

    if (!preg_match('/^[A-Za-z\s]+$/', $region)) {
        $response['message'] = 'Region must contain only characters';
        echo json_encode($response);
        exit();
    }

    if (!filter_var($rooms, FILTER_VALIDATE_INT)) {
        $response['message'] = 'Number of rooms must be an integer';
        echo json_encode($response);
        exit();
    }

    if (!filter_var($price, FILTER_VALIDATE_INT)) {
        $response['message'] = 'Price per night must be an integer';
        echo json_encode($response);
        exit();
    }

    // Photo handling
    if ($photo['error'] === UPLOAD_ERR_OK) {
        $targetDir = 'images/';
        $filePath = $targetDir . basename($photo['name']);

        if (move_uploaded_file($photo['tmp_name'], $filePath)) {
            // File upload successful
            try {
                $stmt = $pdo->prepare("INSERT INTO listings (photo, title, region, rooms, price) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$filePath, $title, $region, $rooms, $price]);

                $response['success'] = true;
                $response['message'] = 'Listing created successfully!';
            } catch (PDOException $e) {
                $response['message'] = 'Database error: ' . $e->getMessage();
            }
        } else {
            $response['message'] = 'Failed to upload photo.';
        }
    } else {
        $response['message'] = 'Photo upload error: ' . $photo['error'];
    }
} else {
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
?>
