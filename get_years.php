<?php
include 'db.php'; // Include the database connection

$model = $_GET['model'];
$query = $conn->prepare("SELECT DISTINCT year FROM cars WHERE model = ?");
$query->bind_param("s", $model);
$query->execute();
$result = $query->get_result();

$years = [];
while ($row = $result->fetch_assoc()) {
    $years[] = $row['year'];
}

echo json_encode($years); // Output years as JSON
?>
