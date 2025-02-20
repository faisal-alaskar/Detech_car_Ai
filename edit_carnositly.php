<?php
include 'db.php'; // Include your database connection

// Fetch car details based on car_id
if (isset($_GET['car_id'])) {
    $car_id = $_GET['car_id'];

    // Prepare and execute the query to get the car details
    $sql = "SELECT * FROM cars WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $car = $result->fetch_assoc();

    // If car details were found, populate the form with the current values
    if (!$car) {
        echo "Car not found.";
        exit;
    }
} else {
    echo "No car_id provided.";
    exit;
}

// Update car details on form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $color = $_POST['color'];
    $fuel_type = $_POST['fuel_type'];
    $price = $_POST['price'];

    // Update query
    $sql_update = "UPDATE cars SET brand = ?, model = ?, year = ?, mileage = ?, color = ?, fuel_type = ?, price = ? WHERE car_id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("ssiiissi", $brand, $model, $year, $mileage, $color, $fuel_type, $price, $car_id);

    if ($stmt_update->execute()) {
        echo "Car details updated successfully!";
        // Redirect to another page if needed, e.g., the dashboard or car list
        // header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error updating car: " . $stmt_update->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Car</title>
</head>
<body>

<h2>Edit Car</h2>
<form action="" method="POST">
    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" value="<?php echo htmlspecialchars($car['brand']); ?>" required>
    <br>

    <label for="model">Model:</label>
    <input type="text" id="model" name="model" value="<?php echo htmlspecialchars($car['model']); ?>" required>
    <br>

    <label for="year">Year:</label>
    <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($car['year']); ?>" required>
    <br>

    <label for="mileage">Mileage (km):</label>
    <input type="number" id="mileage" name="mileage" value="<?php echo htmlspecialchars($car['mileage']); ?>" required>
    <br>

    <label for="color">Color:</label>
    <input type="text" id="color" name="color" value="<?php echo htmlspecialchars($car['color']); ?>" required>
    <br>

    <label for="fuel_type">Fuel Type:</label>
    <input type="text" id="fuel_type" name="fuel_type" value="<?php echo htmlspecialchars($car['fuel_type']); ?>" required>
    <br>

    <label for="price">Price per Day ($):</label>
    <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($car['price']); ?>" required>
    <br>

    <button type="submit">Update Car</button>
</form>

</body>
</html>
