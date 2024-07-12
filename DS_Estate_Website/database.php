<?php
$servername = "localhost";
$username = "root";
$password = "";

$dbname = "ds_estate";
$dsn = "mysql:host=$servername;dbname=$dbname;charset=utf8mb4";

// PDO will work on 12 different database systems, whereas MySQLi will only work with MySQL databases (chose it for flexibility)
try {
    $pdo = new PDO($dsn, $username, $password);
	// set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
    exit();
}
?>