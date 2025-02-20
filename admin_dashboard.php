<?php
include 'db.php'; // Include the database connection

$success_message = ""; // Variable to hold success message

// Check if a message is set in the URL
if (isset($_GET['message'])) {
    $success_message = htmlspecialchars($_GET['message']); // Sanitize the message to avoid XSS attacks
}

// Fetch all cars to display in the table
$sql = "SELECT car_id, brand, model, year,color, mileage FROM cars";
$result = $conn->query($sql);

?>
<?php
include 'db.php'; // Include your database connection

$success_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $car_id = $_POST['car_id'];
    $brand = $_POST['brand'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $mileage = $_POST['mileage'];
    $color = $_POST['color']; 
    $fuel_type = $_POST['fuel_type'];
    $price = $_POST['price'];
    $license_plate = $_POST['license_plate']; // Capture license plate

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
        $sql = "INSERT INTO cars (car_id, brand, model, year, mileage, color, fuel_type, price, license_plate, image1, image2, image3) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            die('Prepare failed: ' . $conn->error);
        }

        $stmt->bind_param("issiiissssss", $car_id, $brand, $model, $year, $mileage, $color, $fuel_type, $price, $license_plate, $image1_path, $image2_path, $image3_path);

        if ($stmt->execute()) {
            $success_message = "Car added successfully!";
        } else {
            $success_message = "Error adding car: " . $stmt->error;
        }

        $stmt->close(); // Close the prepared statement
    } else {
        $success_message = "Error uploading images.";
    }

    // Close the database connection once
    $conn->close();
}

?>

<!-- Display success message (if any) -->
<?php if (!empty($success_message)): ?>
    <div class="alert alert-success">
        <?php echo $success_message; ?>
    </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="zxx">
<head>
    <title>Detch</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">

    <!-- External CSS libraries -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap-submenu.css">

    <link rel="stylesheet" type="text/css" href="css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="css/magnific-popup.css">
    <link rel="stylesheet" href="css/leaflet.css" type="text/css">
    <link rel="stylesheet" href="css/map.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome/css/font-awesome.min.css">
    <link type="text/css" rel="stylesheet" href="fonts/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="fonts/flaticon/font/flaticon.css">
    <link rel="stylesheet" type="text/css" href="fonts/linearicons/style.css">
    <link rel="stylesheet" type="text/css"  href="css/jquery.mCustomScrollbar.css">
    <link rel="stylesheet" type="text/css"  href="css/dropzone.css">
    <link rel="stylesheet" type="text/css"  href="css/lightbox.min.css">
    <link rel="stylesheet" type="text/css"  href="css/jnoty.css">
    <link rel="stylesheet" type="text/css"  href="css/slick.css">

    <!-- Custom stylesheet -->
    <link rel="stylesheet" type="text/css" href="css/initial.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" id="style_sheet" href="css/skins/midnight-blue.css">

    <!-- Favicon icon -->
    <link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" >

    <!-- Google fonts -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=OSans:400,300,600,700,800%7CPlayfair+Display:400,700%7CRoboto:100,300,400,400i,500,700">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Raleway:300,400,500,600,300,700">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@100;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link rel="stylesheet" type="text/css" href="css/ie10-viewport-bug-workaround.css">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script  src="js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script  src="js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script  src="js/html5shiv.min.js"></script>
    <script  src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <div class="page_loader" style="display: none;"></div>
    
    <!-- Top header start -->
    <header class="top-header" id="top-header-2">
        
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-7 col-7">
                    <div class="list-inline">
                        <a href="#"><i class="fa fa-map-marker"></i> Saudi Arabia,Riyadh</a>
                        <a href="tel:Detech@gmail.com" class="d-none-768"><i class="fa fa-envelope"></i>Detech@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-5 col-5">
                    <ul class="top-social-media pull-right">
                        <li>
<?php
// Check if session is not already active before starting it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and 'user_id' exists in the session
if (isset($_SESSION['user_id'])) {
    // The user is logged in, display the logout icon
    echo '<a href="logout.php" class="nav-link h-icon"><i class="flaticon-logout"></i> Logout</a>';
} else {
    // The user is not logged in, display the login icon
    echo '<a href="login.html" class="nav-link h-icon">
                                <i class="flaticon-logout"></i>
                            </a>';
}
?>                        </li>
                        <li>
                            
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </header>
    <!-- Top header end -->
    
    <!-- Main header start -->
    <header class="main-header sticky-header header-with-top" id="main-header-4">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="header-left">
                <a class="navbar-brand logos" href="index-4.php">
                    <img src="img/logos/black-logo.png" alt="logo">
                </a>
            </div>
            <button class="navbar-toggler" id="drawer" type="button">
                <span class="fa fa-bars"></span>
            </button>
            <div class="header-centar">
                <div class="navbar-collapse collapse" id="navbar">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="index-4.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Home
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                
                               
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="car-list-fullWidth.php" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Fleet
                            </a>
                            
                        </li>
                        
                        
                        
                        <li class="nav-item dropdown">
                            <a class="nav-link" href="contact.php">Contact</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="login.html" class="nav-link h-icon">
                                <i class="flaticon-logout"></i>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="#full-page-search" class="nav-link h-icon">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="header-right">
                <div class="contact-now">
                    <div class="left">
                        <i class="fa fa-phone"></i>
                    </div>
                    <div class="right">
                        <h5>Call Us</h5>
                        <h4><a href="tel:+55-4XX-634-7071">0555785595</a></h4>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- Main header end -->
    
    <!-- Sidenav start -->
    <nav id="sidebar" class="nav-sidebar mCustomScrollbar _mCS_1 mCS-autoHide mCS_no_scrollbar" style="overflow: visible;"><div id="mCSB_1" class="mCustomScrollBox mCS-minimal mCSB_vertical mCSB_outside" style="max-height: none;" tabindex="0"><div id="mCSB_1_container" class="mCSB_container mCS_y_hidden mCS_no_scrollbar_y" style="position:relative; top:0; left:0;" dir="ltr">
        <!-- Close btn-->
        <div id="dismiss">
            <i class="fa fa-close"></i>
        </div>
        <div class="sidebar-inner">
            <div class="sidebar-logo">
                <img src="img/logos/black-logo.png" alt="sidebarlogo" class="mCS_img_loaded">
            </div>
            <div class="sidebar-navigation">
                <h3 class="heading">Pages</h3>
                <ul class="menu-list">
                    <li><a href="index-4.php" class="pt0">Home</a>
                     
                    </li>
                    <li>
                        <a href="car-list-fullWidth.php">Fleet</a>
                        
                    </li>
                    <li><a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a></em></a>
                        
                    </li>
                    
                    
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    <li>
                        <a href="login.html" class="nav-link h-icon">
                            <i class="flaticon-logout"></i>
                        </a>
                    </li>
                    
                </ul>
            </div>
            <div class="get-in-touch">
                <h3 class="heading">Get in Touch</h3>
                <div class="get-in-touch-box d-flex">
                    <i class="flaticon-phone"></i>
                    <div class="detail">
                        <a href="tel:0477-0477-8556-552">0555785595</a>
                    </div>
                </div>
                <div class="get-in-touch-box d-flex">
                    <i class="flaticon-mail"></i>
                    <div class="detail">
                        <a href="#">Detech@gmail.com</a>
                    </div>
                </div>
                <div class="get-in-touch-box d-flex mb-0">
                    <i class="flaticon-earth"></i>
                    <div class="detail">
                        <a href="#">Detech@gmail.com</a>
                    </div>
                </div>
            </div>
            <div class="get-social">
                <h3 class="heading">Get Social</h3>
                <a href="#" class="facebook-bg">
                    <i class="fa fa-facebook"></i>
                </a>
                <a href="#" class="twitter-bg">
                    <i class="fa fa-twitter"></i>
                </a>
                <a href="#" class="google-bg">
                    <i class="fa fa-google"></i>
                </a>
                <a href="#" class="linkedin-bg">
                    <i class="fa fa-linkedin"></i>
                </a>
            </div>
        </div>
    </div></div><div id="mCSB_1_scrollbar_vertical" class="mCSB_scrollTools mCSB_1_scrollbar mCS-minimal mCSB_scrollTools_vertical" style="display: none;"><div class="mCSB_draggerContainer"><div id="mCSB_1_dragger_vertical" class="mCSB_dragger" style="position: absolute; min-height: 50px; height: 0px; top: 0px;"><div class="mCSB_dragger_bar" style="line-height: 50px;"></div></div><div class="mCSB_draggerRail"></div></div></div></nav>
    <!-- Sidenav end -->
    
    <!-- Sub banner start -->
    <div class="sub-banner">
        <div class="container breadcrumb-area">
            <div class="breadcrumb-areas">
                <h1>Reservations</h1>
                <ul class="breadcrumbs">
                    <li><a href="index-4.php">Home</a></li>
                    <li class="active">Reservations</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Sub Banner end -->
    
    <!-- Featured car start -->
    <div class="featured-car content-area-15">
    <?php
include 'db.php'; // Include your database connection

// Fetch all reservations and related car and customer details
$sql = "SELECT r.reservation_id, r.reservation_date, r.return_date, r.status, u.full_name, c.car_id, c.brand, c.model, c.mileage, c.price,c.color
        FROM reservations r
        JOIN cars c ON r.car_id = c.car_id
        JOIN users u ON r.user_id = u.user_id";
$result = $conn->query($sql);

?>
<div class="container mt-5">
    <h1 class="text-center mb-4">Admin Dashboard - All Reservations</h1>

    <!-- Display All Reservations as Cards for Mobile -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h2>All Reservations</h2>
        </div>
        <div class="card-body">
            <?php
            if ($result->num_rows > 0) {
                while ($reservation = $result->fetch_assoc()) {
                    // Calculate the total price based on the number of days
                    $start_date = new DateTime($reservation['reservation_date']);
                    $end_date = new DateTime($reservation['return_date']);
                    $interval = $start_date->diff($end_date);
                    $days = $interval->days + 1; // Include both start and end dates
                    $total_price = $days * $reservation['price'];

                    // Reservation card layout
                    echo '<div class="card mb-3">';
                    echo '  <div class="card-header bg-secondary text-white">';
                    echo '      <strong>Reservation ID:</strong> ' . htmlspecialchars($reservation['reservation_id']);
                    echo '  </div>';
                    echo '  <div class="card-body">';
                    echo '      <p><strong>Customer Name:</strong> ' . htmlspecialchars($reservation['full_name']) . '</p>';
                    echo '      <p><strong>Car:</strong> ' . htmlspecialchars($reservation['brand']) . ' ' . htmlspecialchars($reservation['model']) . '</p>';
                    echo '      <p><strong>Reservation Date:</strong> ' . htmlspecialchars($reservation['reservation_date']) . '</p>';
                    echo '      <p><strong>Return Date:</strong> ' . htmlspecialchars($reservation['return_date']) . '</p>';
                    echo '      <p><strong>Total Price:</strong> $' . number_format($total_price, 2) . '</p>';
                    echo '      <p><strong>Status:</strong> ' . htmlspecialchars($reservation['status']) . '</p>';

                    // Actions based on the reservation status
                    echo '      <div class="d-flex">';
                    $status = strtolower(trim($reservation['status']));
if ($status == 'approved') {
    echo '          <a href="delivery_car.php?reservation_id=' . $reservation['reservation_id'] . '" class="btn btn-primary btn-sm flex-fill me-1">Deliver</a>';
} elseif ($status == 'pending') {
    echo '          <a href="update_reservation_status.php?reservation_id=' . $reservation['reservation_id'] . '&status=Approved" class="btn btn-success btn-sm flex-fill me-1">Approve</a>';
    echo '          <a href="update_reservation_status.php?reservation_id=' . $reservation['reservation_id'] . '&status=Declined" class="btn btn-danger btn-sm flex-fill">Decline</a>';
} elseif ($status == 'delivered') {
    // Redirect to delivery_car.php with an additional parameter for "return"
    echo '          <a href="Returen_car.php?reservation_id=' . $reservation['reservation_id'] . '&action=return" class="btn btn-info btn-sm flex-fill me-1">Return</a>';
} else {
    echo '<a href="report.php?reservation_id=' . $reservation['reservation_id'] . '" class="btn btn-info btn-sm flex-fill me-1">Report</a>';

}
echo '      </div>'; // Close action div
echo '  </div>'; // Close card body
echo '</div>'; // Close card

                }
            } else {
                echo '<p class="text-center">No reservations found.</p>';
            }
            ?>
        </div>
    </div>
</div>
<?php
$conn->close();
?>





    
    <!-- Featured car end -->
    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard - Car Management</h1>
        <?php if (!empty($success_message)): ?>
        <div class="alert alert-success">
            <?php echo $success_message; ?>
        </div>
    <?php endif; ?>



                
                </tbody>
            </table>
        </div>
    </div>
</div>



    
        <!-- Add Car Form -->
        <div class="card mb-5 shadow-sm">
    <div class="card-header bg-primary text-white">
        <h2>Add a New Car</h2>
    </div>
    <div class="card-body">
        <form action="" method="POST" enctype="multipart/form-data">
            <!-- Row for Car ID and Brand -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="car_id">Car ID</label>
                    <input type="number" class="form-control" id="car_id" name="car_id" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="brand">Brand</label>
                    <input type="text" class="form-control" id="brand" name="brand" required>
                </div>
            </div>
            
            <!-- Row for Model and Year -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="model">Model</label>
                    <input type="text" class="form-control" id="model" name="model" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="year">Year</label>
                    <input type="number" class="form-control" id="year" name="year" required>
                </div>
            </div>
            
            <!-- Row for Mileage and Color -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="mileage">Mileage (km)</label>
                    <input type="number" class="form-control" id="mileage" name="mileage" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="color">Color</label>
                    <input type="text" class="form-control" id="color" name="color" required>
                </div>
            </div>
            
            <!-- Row for Fuel Type and Price -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="fuel_type">Fuel Type</label>
                    <input type="text" class="form-control" id="fuel_type" name="fuel_type" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="price">Price per Day ($)</label>
                    <input type="number" class="form-control" id="price" name="price" required>
                </div>
            </div>
            
            <!-- Row for License Plate -->
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="license_plate">License Plate</label>
                    <input type="text" class="form-control" id="license_plate" name="license_plate" required>
                </div>
            </div>
            
            <!-- Row for Car Images -->
            <div class="row">
                <div class="col-md-4 mb-3">
                    <label for="image1">Car Image 1</label>
                    <input type="file" class="form-control-file" id="image1" name="image1" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="image2">Car Image 2</label>
                    <input type="file" class="form-control-file" id="image2" name="image2" required>
                </div>
                <div class="col-md-4 mb-3">
                    <label for="image3">Car Image 3</label>
                    <input type="file" class="form-control-file" id="image3" name="image3" required>
                </div>
            </div>
            
            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit" class="btn btn-success btn-lg mt-3">Add Car</button>
            </div>
        </form>
    </div>
</div>


    
        <!-- Display All Cars -->
        <<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h2>All Cars</h2>
    </div>
    <div class="card-body p-0">
        <!-- Display table on larger screens and cards on smaller screens -->
        <div class="d-none d-md-block table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>Car ID</th>
                        <th>Brand</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Mileage (km)</th>
                        <th>Color</th>
                        <th>Fuel Type</th>
                        <th>Price (SAR/day)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include 'db.php'; // Include your database connection
                    $sql = "SELECT * FROM cars";
                    $result = $conn->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($car = $result->fetch_assoc()) {
                            echo "<tr>
                                <td>{$car['car_id']}</td>
                                <td>{$car['brand']}</td>
                                <td>{$car['model']}</td>
                                <td>{$car['year']}</td>
                                <td>" . number_format($car['mileage']) . "</td>
                                <td>{$car['color']}</td>
                                <td>{$car['fuel_type']}</td>
                                <td>{$car['price']} SAR/day</td>
                                <td>
                                    <a href='edit_car.php?car_id={$car['car_id']}' class='btn btn-warning btn-sm'>Edit</a>
                                    <a href='delete_car.php?car_id={$car['car_id']}' class='btn btn-danger btn-sm'>Delete</a>
                                </td>
                            </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='9' class='text-center'>No cars available</td></tr>";
                    }
                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Display as cards on small screens -->
        <div class="d-md-none">
            <?php
            include 'db.php';
            $sql = "SELECT * FROM cars";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($car = $result->fetch_assoc()) {
                    echo "<div class='card mb-3'>";
                    echo "  <div class='card-header bg-secondary text-white'>";
                    echo "      <strong>Car ID:</strong> {$car['car_id']}";
                    echo "  </div>";
                    echo "  <div class='card-body'>";
                    echo "      <p><strong>Brand:</strong> {$car['brand']}</p>";
                    echo "      <p><strong>Model:</strong> {$car['model']}</p>";
                    echo "      <p><strong>Year:</strong> {$car['year']}</p>";
                    echo "      <p><strong>Mileage:</strong> " . number_format($car['mileage']) . " km</p>";
                    echo "      <p><strong>Color:</strong> {$car['color']}</p>";
                    echo "      <p><strong>Fuel Type:</strong> {$car['fuel_type']}</p>";
                    echo "      <p><strong>Price per Day:</strong> {$car['price']} SAR</p>";
                    echo "      <div class='d-flex'>";
                    echo "          <a href='edit_car.php?car_id={$car['car_id']}' class='btn btn-warning btn-sm flex-fill me-1'>Edit</a>";
                    echo "          <a href='delete_car.php?car_id={$car['car_id']}' class='btn btn-danger btn-sm flex-fill'>Delete</a>";
                    echo "      </div>";
                    echo "  </div>";
                    echo "</div>";
                }
            } else {
                echo "<p class='text-center'>No cars available.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>
</div>

    </div>
    
    <!-- Compare info start -->
    
    <!-- Compare info end -->
    
    <!-- Footer start -->
    <footer class="footer">
        <div class="container footer-inner">
            <div class="row">
                <div class="col-xl-3 col-lg-3 col-md-6 col-sm-6">
                    <div class="footer-item clearfix">
                        <h4>
                            Contact Info
                        </h4>
                        <ul class="contact-info">
                            <li>
                                <i class="flaticon-pin"></i>Saudi Arabia,Riyadh
                            </li>
                            <li>
                                <i class="flaticon-mail"></i><a href="mailto:Detech@gmail.com">Detech@gmail.com</a>
                            </li>
                            <li>
                                <i class="flaticon-phone"></i><a href="tel:0555785595">0555785595</a>
                            </li>
                            
                        </ul>
                        <div class="clearfix"></div>
                        <div class="social-list-2">
                            <ul>
                                <li><a href="#" class="facebook-bg"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="#" class="twitter-bg"><i class="fa fa-twitter"></i></a></li>
                                
                               
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                    
                </div>
                
            </div>
        </div>
        <div class="copy sub-footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer end -->
    
    <!-- Full Page Search -->
    <div id="full-page-search">
        <button type="button" class="close">×</button>
        <div class="full-page-search-box">
            <form action="index-4.php#" class="search-boxs">
                <input class="search" type="search" value="" placeholder="type keyword(s) here">
                <button type="submit" class="btn btn-sm button-theme">Search</button>
            </form>
        </div>
    </div>
    
    <!-- Car Modal 2 -->
    <div class="car-model-2">
        <div class="modal fade" id="carOverviewModal" tabindex="-1" role="dialog" aria-labelledby="carOverviewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="carOverviewModalLabel">
                            Find Your Dream Car
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row modal-raw">
                            <div class="col-lg-6 modal-left">
                                <div class="modal-left-content">
                                    <div class="bs-example" data-example-id="carousel-with-captions">
                                        <div class="carousel slide" id="properties-carousel" data-ride="carousel">
                                            <div class="carousel-inner" role="listbox">
                                                <div class="item active">
                                                    <iframe src="https://www.youtube.com/embed/V7IrnC9MISU" allowfullscreen=""></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 modal-right">
                                <div class="modal-right-content">
                                    <section>
                                        <h3>Features</h3>
                                        <div class="features">
                                            <ul class="bullets">
                                                <li>Cruise Control</li>
                                                <li>Airbags</li>
                                                <li>Air Conditioning</li>
                                                <li>Alarm System</li>
                                                <li>Audio Interface</li>
                                                <li>CDR Audio</li>
                                                <li>Seat Heating</li>
                                                <li>ParkAssist</li>
                                            </ul>
                                        </div>
                                    </section>
                                    <section>
                                        <h3>Overview</h3>
                                        <dl>
                                            <dt>Model</dt>
                                            <dd>Audi</dd>
                                            <dt>Condition</dt>
                                            <dd>Brand New</dd>
                                            <dt>Year</dt>
                                            <dd>2020</dd>
                                            <dt>Price</dt>
                                            <dd>$178,000</dd>
                                        </dl>
                                    </section>
                                    <div class="dd">
                                        <div class="ratings-2">
                                            <span class="ratings-box">4.5/5</span>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star-o"></i>
                                            <span>( 7 Reviews )</span>
                                        </div>
                                        <div class="btns">
                                            <a href="car-details.html" class="btn btn-md btn-round btn-theme">Show Detail</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/bootstrap-submenu.js"></script>
    <script src="js/rangeslider.js"></script>
    <script src="js/jquery.mb.YTPlayer.js"></script>
    <script src="js/bootstrap-select.min.js"></script>
    <script src="js/jquery.easing.1.3.js"></script>
    <script src="js/jquery.scrollUp.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/leaflet.js"></script>
    <script src="js/leaflet-providers.js"></script>
    <script src="js/leaflet.markercluster.js"></script>
    <script src="js/dropzone.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/slick.min.js"></script>
    <script src="js/jquery.filterizr.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/jquery.countdown.js"></script>
    <script src="js/jquery.mousewheel.min.js"></script>
    <script src="js/lightgallery-all.js"></script>
    <script src="js/jnoty.js"></script>
    <script src="js/maps.js"></script>
    <script src="js/sidebar.js"></script>
    <script src="js/app.js"></script>
    
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    <!-- Custom javascript -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4omYJlOaP814WDcCG8eubXcbhB-44Uac"></script>
    <script>
        function LoadMap(propertes) {
            var defaultLat = 40.7110411;
            var defaultLng = -74.0110326;
            var mapOptions = {
                center: new google.maps.LatLng(defaultLat, defaultLng),
                zoom: 15,
                scrollwheel: false,
                styles: [
                    {
                        featureType: "administrative",
                        elementType: "labels",
                        stylers: [
                            {visibility: "off"}
                        ]
                    },
                    {
                        featureType: "water",
                        elementType: "labels",
                        stylers: [
                            {visibility: "off"}
                        ]
                    },
                    {
                        featureType: 'poi.business',
                        stylers: [{visibility: 'off'}]
                    },
                    {
                        featureType: 'transit',
                        elementType: 'labels.icon',
                        stylers: [{visibility: 'off'}]
                    },
                ]
            };
            var map = new google.maps.Map(document.getElementById("map"), mapOptions);
            var infoWindow = new google.maps.InfoWindow();
            var myLatlng = new google.maps.LatLng(40.7110411, -74.0110326);
    
            var marker = new google.maps.Marker({
                position: myLatlng,
                map: map
            });
            (function (marker) {
                google.maps.event.addListener(marker, "click", function (e) {
                    infoWindow.setContent("" +
                        "<div class='map-properties contact-map-content'>" +
                        "<div class='map-content'>" +
                        "<p class='address'>20-21 Kathal St. Tampa City, FL</p>" +
                        "<ul class='map-properties-list'> " +
                        "<li><i class='flaticon-phone'></i>  +0555785595</li> " +
                        "<li><i class='flaticon-phone'></i>  Detech@gmail.com</li> " +
                        "<li><a href='index-4.php'><i class='fa fa-globe'></i>  http://www.example.com</li></a> " +
                        "</ul>" +
                        "</div>" +
                        "</div>");
                    infoWindow.open(map, marker);
                });
            })(marker);
        }
        LoadMap();
    </script>
    
    
    <a id="page_scroller" href="#top" style="display: none; position: fixed; z-index: 2147483647;"><i class="fa fa-chevron-up"></i></a><div class="option-panel option-panel-collased">
        <h2>Change Color</h2>
        <div class="color-plate default-plate" data-color="default"></div>
        <div class="color-plate midnight-blue-plate" data-color="midnight-blue"></div>
        <div class="color-plate yellow-plate" data-color="yellow"></div>
        <div class="color-plate blue-plate" data-color="blue"></div>
        <div class="color-plate green-light-plate" data-color="green-light"></div>
        <div class="color-plate yellow-light-plate" data-color="yellow-light"></div>
        <div class="color-plate green-plate" data-color="green"></div>
        <div class="color-plate green-light-2-plate" data-color="green-light-2"></div>
        <div class="color-plate red-plate" data-color="red"></div>
        <div class="color-plate purple-plate" data-color="purple"></div>
        <div class="color-plate brown-plate" data-color="brown"></div>
        <div class="color-plate olive-plate" data-color="olive"></div>
        <div class="setting-button">
            <i class="fa fa-gear"></i>
        </div>
    </div></body>
</html>