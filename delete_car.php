<?php
include 'db.php'; // Include the database connection

// Check if car_id is provided in the URL
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Prepare SQL statement to delete the car
    $sql = "DELETE FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);

    if ($stmt->execute()) {
        // Redirect back to the dashboard with a success message
        header("Location: admin_dashboard.php?message=Car+deleted+successfully");
    } else {
        // Redirect back with an error message
        header("Location: admin_dashboard.php?message=Error+deleting+car");
    }

    $stmt->close();
    $conn->close();
} else {
    // Redirect back with an error if car_id is not provided
    header("Location: admin_dashboard.php?message=No+car+ID+provided");
}
