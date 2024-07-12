<?php
require 'database.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if property_id is set in POST data
    if (isset($_POST['property_id'])) {
        // Get the property_id from POST data
        $property_id = $_POST['property_id'];

        // Set a cookie with the property_id
        setcookie('property_id', $property_id, time() + (86400 * 30), "/"); // 30 days expiry

        // Redirect to Book.html
        header('Location: Book.html');
        exit();
    }
}
?>
