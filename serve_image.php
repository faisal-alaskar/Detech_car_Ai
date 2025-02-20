<?php
include 'db.php'; // Include your database connection

if (isset($_GET['car_id'])) {
    $car_id = intval($_GET['car_id']);
    
    // Fetch image data from the database
    $sql = "SELECT image1 FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $car_id);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($image);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && !empty($image)) {
        // Send appropriate headers and output the image
        header("Content-Type: image/jpeg");
        echo $image;
    } else {
        // If no image is found, serve a default placeholder image
        header("Content-Type: image/jpeg");
        readfile("path_to_placeholder_image.jpg");
    }

    $stmt->close();
}
$conn->close();
?>
