<?php
include 'db.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $reservation_id = $_POST['reservation_id'];
    $action = $_POST['action'];

    // Set status based on the action
    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'decline') {
        $status = 'declined';
    } else {
        // Invalid action
        header("Location: admin_dashboard.php?error=InvalidAction");
        exit();
    }

    // Update the reservation status in the database
    $stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE reservation_id = ?");
    $stmt->bind_param("si", $status, $reservation_id);

    if ($stmt->execute()) {
        // Success, redirect back to the admin dashboard
        header("Location: admin_dashboard.php?success=ReservationUpdated");
    } else {
        // Error
        header("Location: admin_dashboard.php?error=UpdateFailed");
    }

    $stmt->close();
}

$conn->close();
?>
