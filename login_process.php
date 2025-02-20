<?php
session_start(); // Start the session

include 'db.php'; // Include your database connection

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Query the database to find the user
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Set the session variable
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role']; // Optional: if you want to store the user role as well

            // Redirect to the customer dashboard
            header("Location: index-4.php");
            exit();
        } else {
            echo "Invalid password!";
        }
    } else {
        echo "No user found with that email!";
    }
    
    $stmt->close();
    $conn->close();
}
?>
