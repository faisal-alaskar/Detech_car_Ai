<?php
include 'db.php';  // Include your database connection file

// Prepare SQL query to retrieve distinct car brands
$sql = "SELECT DISTINCT brand FROM cars";
$result = $conn->query($sql);

$brands = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $brands[] = $row['brand'];
    }
}

$conn->close();

// Output the brands as JSON
echo json_encode($brands);
?>
