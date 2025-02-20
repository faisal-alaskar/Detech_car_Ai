<?php
include 'db.php'; // Include your database connection

if (isset($_GET['reservation_id']) && isset($_GET['status'])) {
    $reservation_id = intval($_GET['reservation_id']);
    $status = $_GET['status'];
    
    // Update the reservation status
    $sql = "UPDATE reservations SET status = ? WHERE reservation_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('si', $status, $reservation_id);

    if ($stmt->execute()) {
        echo "Reservation status updated successfully!";
        header("Location: admin_dashboard.php");
    } else {
        echo "Error updating reservation status.";
    }
}
?>
