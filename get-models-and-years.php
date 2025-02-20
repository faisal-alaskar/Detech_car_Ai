<?php
include 'db.php';  // Include your database connection

// Get the selected brand from the request
$brand = isset($_GET['brand']) ? $_GET['brand'] : '';

// Prepare and execute query to fetch models and years for the selected brand
$sql_models = "SELECT DISTINCT model FROM cars WHERE brand = ?";
$sql_years = "SELECT DISTINCT year FROM cars WHERE brand = ? ORDER BY year DESC";

$stmt_models = $conn->prepare($sql_models);
$stmt_years = $conn->prepare($sql_years);

$stmt_models->bind_param("s", $brand);
$stmt_years->bind_param("s", $brand);

$stmt_models->execute();
$stmt_years->execute();

$result_models = $stmt_models->get_result();
$result_years = $stmt_years->get_result();

$models = [];
$years = [];

// Fetch models
while ($row = $result_models->fetch_assoc()) {
    $models[] = $row['model'];
}

// Fetch years
while ($row = $result_years->fetch_assoc()) {
    $years[] = $row['year'];
}

$stmt_models->close();
$stmt_years->close();
$conn->close();

// Return data as JSON
echo json_encode(['models' => $models, 'years' => $years]);
?>
