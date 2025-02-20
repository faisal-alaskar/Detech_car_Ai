<?php
include 'db.php';

// Check if all required POST data is available
if (isset($_POST['email'], $_POST['password'], $_POST['fullname'])) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];  // Assuming phone is also being posted
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $role = 'customer';  // Automatically assign the role of 'customer'

    // Prepare the SQL statement to insert new user data
    $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone_number, password, role) VALUES (?, ?, ?, ?, ?)");
    // Bind parameters to the SQL query
    $stmt->bind_param("sssss", $fullname, $email, $phone, $password, $role);

    // Execute the statement and handle the execution result
    if ($stmt->execute()) {
        // Redirect to index-4.php on successful registration
        header("Location: index-4.php");
        exit();  // Ensure no further code is run after redirect
    } else {
        echo "Error: " . $stmt->error;  // Output errors if the execution fails
    }

    $stmt->close();  // Close the statement to free up resources
} else {
    echo "All fields are required.";  // usersPrompt user if any field is missing
}

$conn->close();  // Close the database connection
?>
