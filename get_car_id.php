<?php
include 'db.php'; // Include the database connection

$brand = $_GET['brand'];
$model = $_GET['model'];
$year = $_GET['year'];

$query = $conn->prepare("SELECT car_id FROM cars WHERE brand = ? AND model = ? AND year = ?");
$query->bind_param("sss", $brand, $model, $year);
$query->execute();
$result = $query->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(['car_id' => $row['car_id']]);
} else {
    echo json_encode(['error' => 'No car found']);
}
?>
