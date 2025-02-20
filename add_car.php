<?php
include 'db.php'; // Include your database connection

// Enable error reporting for debugging purposes (optional: remove this once everything works)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$success_message = ""; // Variable to hold success message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $car_id = $_POST['car_id']; // Assuming you want to manually set car_id
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $color = $_POST['color'];
    $fuel_type = $_POST['fuel_type'];
    $price = $_POST['price'];

    // File upload handling
    $upload_dir = 'uploads/';
    $image1_path = $upload_dir . basename($_FILES['image1']['name']);
    $image2_path = $upload_dir . basename($_FILES['image2']['name']);
    $image3_path = $upload_dir . basename($_FILES['image3']['name']);

    // Move the uploaded files to the designated folder
    if (move_uploaded_file($_FILES['image1']['tmp_name'], $image1_path) &&
        move_uploaded_file($_FILES['image2']['tmp_name'], $image2_path) &&
        move_uploaded_file($_FILES['image3']['tmp_name'], $image3_path)) {

        // Insert car into the database
        $sql = "INSERT INTO cars (car_id, brand, model, year, mileage, color, fuel_type, price, image1, image2, image3) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("issiiisssss", $car_id, $brand, $model, $year, $mileage, $color, $fuel_type, $price, $image1_path, $image2_path, $image3_path);

        if ($stmt->execute()) {
            $success_message = "Car added successfully!";
        } else {
            $success_message = "Error adding car: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $success
