<?php
session_start();
include 'db.php'; // Include your database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];
        $car_id = $_POST['car_id'];
        $reservation_date = $_POST['reservation_date'];
        $return_date = $_POST['return_date'];

        // Check if the car is available for the specified date range
        $availability_check = $conn->prepare("
            SELECT COUNT(*) FROM reservations 
            WHERE car_id = ? 
            AND (
                (reservation_date <= ? AND return_date >= ?) OR 
                (reservation_date <= ? AND return_date >= ?)
            )
        ");
        $availability_check->bind_param("issss", $car_id, $return_date, $reservation_date, $reservation_date, $return_date);
        $availability_check->execute();
        $availability_check->bind_result($count);
        $availability_check->fetch();
        $availability_check->close();

        if ($count > 0) {
            echo "<script>alert('Sorry, this car is already reserved for the selected dates.'); window.location.href='car-list-fullWidth.php';</script>";
            exit();
        } else {
            // Insert the reservation if the car is available
            $stmt = $conn->prepare("INSERT INTO reservations (user_id, car_id, reservation_date, return_date) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("iiss", $user_id, $car_id, $reservation_date, $return_date);

            if ($stmt->execute()) {
                echo "<script>alert('Reservation successful!'); window.location.href='car-list-fullWidth.php';</script>";
            } else {
                echo "<script>alert('Error: Could not complete the reservation.'); window.location.href='car-list-fullWidth.php';</script>";
            }

            $stmt->close();
            $conn->close();
        }
    } else {
        header("Location: login.html");
        exit();
    }
}
?>
