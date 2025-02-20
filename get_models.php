<?php
include 'db.php'; // Include the database connection

$brand = $_GET['brand'];
$query = $conn->prepare("SELECT model FROM cars WHERE brand = ?");
$query->bind_param("s", $brand);
$query->execute();
$result = $query->get_result();

$models = [];
while ($row = $result->fetch_assoc()) {
    $models[] = $row['model'];
}

echo json_encode($models); // Output models as JSON
?>
