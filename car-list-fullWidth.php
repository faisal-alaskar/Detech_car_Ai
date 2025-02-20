<?php
session_start(); // Start the session at the beginning of each page

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.html");
    exit();
}
?>

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
<div class="page_loader"></div>

<!-- Top header start -->

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
                       
                    </li>
                    <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="car-list-fullWidth.php" id="navbarDropdownMenuLink2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Fleet
                        </a>
                        
                    </li>
                    
                    
                    <li class="nav-item dropdown">
                        <?php
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        echo '<a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a>';
    } elseif ($_SESSION['role'] == 'customer') {
        echo '<a class="nav-link" href="customer.php">My Reservations</a>';
    }
}
?>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link" href="contact.php">Contact</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="login.html" class="nav-link h-icon">
                            <i class="flaticon-logout"></i>
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
<nav id="sidebar" class="nav-sidebar">
    <!-- Close btn-->
    <div id="dismiss">
        <i class="fa fa-close"></i>
    </div>
    <div class="sidebar-inner">
        <div class="sidebar-logo">
            <img src="img/logos/black-logo.png" alt="sidebarlogo">
        </div>
        <div class="sidebar-navigation">
            <h3 class="heading">Pages</h3>
            <ul class="menu-list">
                <li><a href="index-4.php" class="active pt0">home
                <li>
                    <a href="car-list-fullWidth.php">Fleet </em></a></li>
                
                        
                        
                    
              
                
                
                <li>
                    <a href="contact.php">Contact</a>
                </li>
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
    echo '<a href="login.html" class="nav-link h-icon"><i class="flaticon-login"></i> Login</a>';
}
?>

                        </li>
                
                <li>
                    
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
                    <a href="#">DeTech@gmail.com</a>
                </div>
            </div>
            <div class="get-in-touch-box d-flex mb-0">
                <i class="flaticon-earth"></i>
                <div class="detail">
                    <a href="#">DeTech@gmail.com</a>
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
</nav>
<!-- Sidenav end -->

<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container breadcrumb-area">
        <div class="breadcrumb-areas">
            <h1>Car List</h1>
            <ul class="breadcrumbs">
                <li><a href="index-4.php">Home</a></li>
                <li class="active">Car List</li>
            </ul>
        </div>
    </div>
</div>
<!-- Sub Banner end -->

<!-- Featured car start -->
<div class="featured-car content-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 offset-lg-1">
                <!-- Option bar start -->
                
                <!-- Car box 2 start -->
                <?php
include 'db.php'; // Include your database connection

// Query to fetch all cars
$sql = "SELECT * FROM cars";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Loop through each car and display the details
    while ($car = $result->fetch_assoc()) {
        echo '
        <div class="car-box-2">
            <div class="row g-0">
                <div class="col-lg-4 col-md-5">
                    <div class="car-thumbnail">
                        <a href="car-details.php?car_id=' . $car['car_id'] . '" class="car-img">
                            <div class="tag">Featured</div>
                            <div class="price-box-2"><sup>SAR</sup>' . number_format($car['price']) . '<span>/day</span></div>
                            <img class="d-block w-100" src="' . htmlspecialchars($car['image1']) . '" alt="' . htmlspecialchars($car['model']) . '">
                        </a>
                        <div class="carbox-overlap-wrapper">
                            <div class="overlap-box">
                                <div class="overlap-btns-area">
                                    
                                    
                                    <div class="car-magnify-gallery">
                                        <a href="' . htmlspecialchars($car['image1']) . '" class="overlap-btn" data-sub-html="<h4>' . htmlspecialchars($car['model']) . '</h4><p>A beautiful car....</p>">
                                            <i class="fa fa-expand"></i>
                                            <img class="hidden" src="' . htmlspecialchars($car['image1']) . '" alt="hidden-img">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 col-md-7 align-self-center">
                    <div class="detail">
                        <h3 class="title">
                            <a href="car-details.php?car_id=' . $car['car_id'] . '">' . htmlspecialchars($car['brand']) . ' ' . htmlspecialchars($car['model']) . '</a>
                        </h3>
                        <h5 class="location">
                            <a href="car-details.php?car_id=' . $car['car_id'] . '">
                               
                            </a>
                        </h5>
                        <ul class="facilities-list clearfix">
                            <li><i class="flaticon-way"></i> ' . number_format($car['mileage']) . ' km</li>
                            <li><i class="flaticon-calendar-1"></i> ' . $car['year'] . '</li>
                            <li><i class="flaticon-fuel"></i> ' . htmlspecialchars($car['fuel_type']) . '</li>
                            <li><i class="flaticon-gear"></i> ' . htmlspecialchars($car['color']) . '</li>
                        </ul>
                        <div class="btns mt-3">
                            <a href="#" class="btn btn-md btn-round btn-theme" data-bs-toggle="modal" data-bs-target="#reservationModal" data-car-id="' . $car['car_id'] . '">Reserve Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        ';
    }
} else {
    echo "<p>No cars available.</p>";
}

$conn->close();
?>

<!-- Reservation Modal -->
<div class="modal fade" id="reservationModal" tabindex="-1" role="dialog" aria-labelledby="reservationModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reservationModalLabel">Reserve Car</h5>
        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <form id="reservationForm" action="reservation_process.php" method="POST">
    <div class="mb-3">
        <label for="reservation_date" class="form-label">Reservation Date</label>
        <input type="date" class="form-control" id="reservation_date" name="reservation_date" required="">
    </div>
    <div class="mb-3">
        <label for="return_date" class="form-label">Return Date</label>
        <input type="date" class="form-control" id="return_date" name="return_date" required="">
    </div>
    <input type="hidden" id="car_id" name="car_id" value="1">
    <input type="hidden" id="user_id" name="user_id" value="1">
    <button type="submit" class="btn btn-primary">Reserve Now</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const carId = document.getElementById("car_id").value;
        const reservationInput = document.getElementById("reservation_date");
        const returnInput = document.getElementById("return_date");

        // Set minimum selectable date to today
        const today = new Date().toISOString().split("T")[0];
        reservationInput.setAttribute("min", today);
        returnInput.setAttribute("min", today);

        // Fetch reserved dates from the server
        fetch(`get_reserved_dates.php?car_id=${carId}`)
            .then(response => response.json())
            .then(dates => {
                disableReservedDates(dates, reservationInput);
                disableReservedDates(dates, returnInput);
            });

        function disableReservedDates(dates, input) {
            input.addEventListener("input", () => {
                if (dates.includes(input.value)) {
                    alert("This date is already reserved. Please select another date.");
                    input.value = "";  // Clear the input if the date is reserved
                }
            });

            // Set disabled dates as unavailable directly on the calendar
            dates.forEach(date => {
                const option = document.createElement("option");
                option.value = date;
                option.disabled = true;
                input.appendChild(option);
            });
        }
    });
</script>

      </div>
    </div>
  </div>
</div>

<!-- JavaScript to Pass Car ID to Modal -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    const reserveButtons = document.querySelectorAll(".btn-theme");

    reserveButtons.forEach(button => {
        button.addEventListener("click", function() {
            const carId = this.getAttribute("data-car-id");
            document.getElementById("car_id").value = carId;
        });
    });
});
</script>

                
            </div>
        </div>
    </div>
</div>
<!-- Featured car start -->

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
                            <i class="flaticon-pin"></i>Saudi Arabia
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
            <input class="search" type="search" value="" placeholder="type keyword(s) here"/>
            <button type="submit" class="btn btn-sm button-theme">Search</button>
        </form>
    </div>
</div>

<!-- Car Modal 2 -->
<div class="car-model-2">
    
</div>

<script src="js/jquery.min.js"></script>
<script src="js/popper.min.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script  src="js/bootstrap-submenu.js"></script>
<script  src="js/rangeslider.js"></script>
<script  src="js/jquery.mb.YTPlayer.js"></script>
<script  src="js/bootstrap-select.min.js"></script>
<script  src="js/jquery.easing.1.3.js"></script>
<script  src="js/jquery.scrollUp.js"></script>
<script  src="js/jquery.mCustomScrollbar.concat.min.js"></script>
<script  src="js/leaflet.js"></script>
<script  src="js/leaflet-providers.js"></script>
<script  src="js/leaflet.markercluster.js"></script>
<script  src="js/dropzone.js"></script>
<script  src="js/slick.min.js"></script>
<script  src="js/slick.min.js"></script>
<script  src="js/jquery.filterizr.js"></script>
<script  src="js/jquery.magnific-popup.min.js"></script>
<script  src="js/jquery.countdown.js"></script>
<script  src="js/jquery.mousewheel.min.js"></script>
<script  src="js/lightgallery-all.js"></script>
<script  src="js/jnoty.js"></script>
<script  src="js/maps.js"></script>
<script  src="js/sidebar.js"></script>
<script  src="js/app.js"></script>

<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script  src="js/ie10-viewport-bug-workaround.js"></script>
<!-- Custom javascript -->
<script  src="js/ie10-viewport-bug-workaround.js"></script>

</body>
</html>