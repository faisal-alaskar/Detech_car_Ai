<?php
// Check if session is not already active before starting it
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in and 'user_id' exists in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Proceed with the query to fetch the user's reservations
    include 'db.php'; // Include your database connection

    $sql = "SELECT reservations.*, cars.brand, cars.model, cars.year, cars.mileage, cars.color, cars.fuel_type, cars.price, cars.image1
            FROM reservations
            JOIN cars ON reservations.car_id = cars.car_id
            WHERE reservations.user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    // If no user is logged in, redirect to login page
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
                        <li class="nav-item dropdown megamenu-li active">
                            
                            <div class="dropdown-menu megamenu" aria-labelledby="dropdown01">
                                <div class="megamenu-area">
                                    <div class="row">
                                        <div class="col-sm-6 col-md-4 col-lg-4">
                                            <div class="megamenu-section">
                                                <h6 class="megamenu-title">Pages</h6>
                                                <a class="dropdown-item" href="about.html">About Us</a>
                                                <a class="dropdown-item" href="services.html">Services</a>
                                                <a class="dropdown-item" href="agent.html">Agent</a>
                                                <a class="dropdown-item" href="car-comparison.html">Car Compare</a>
                                                <a class="dropdown-item" href="car-reviews.html">Car Reviews</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-4">
                                            <div class="megamenu-section">
                                                <h6 class="megamenu-title">Pages</h6>
                                                <a class="dropdown-item" href="gallery.html">Gallery</a>
                                                <a class="dropdown-item" href="typography.html">Typography</a>
                                                <a class="dropdown-item" href="pricing-tables.html">Pricing Tables</a>
                                                <a class="dropdown-item" href="elements.html">Elements</a>
                                                <a class="dropdown-item" href="faq.html">Faq</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-md-4 col-lg-4">
                                            <div class="megamenu-section">
                                                <h6 class="megamenu-title">Pages</h6>
                                                <a class="dropdown-item" href="icon.html">Icons</a>
                                                <a class="dropdown-item" href="coming-soon.html">Coming Soon</a>
                                                <a class="dropdown-item" href="404.html">Error Page</a>
                                                <a class="dropdown-item" href="login.html">login</a>
                                                <a class="dropdown-item" href="signup.html">Register</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                       
                        <li class="nav-item dropdown">
                        
<!-- Navbar HTML -->
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
                    <li><a href="index-4.php" class="pt0">Home<em class="fa fa-chevron-down"></em></a>
                        <ul>
                            <li class="selected--last"><a href="index-4.php" style="padding-left: 30px;">Index 1</a></li>
                            <li class="selected--last"><a href="index-2.html" style="padding-left: 30px;">Index 2</a></li>
                            <li class="selected--last"><a href="index-3.html" style="padding-left: 30px;">Index 3</a></li>
                            <li class="selected--last"><a href="index-4.php" style="padding-left: 30px;">Index 4</a></li>
                            <li class="selected--last"><a href="index-5.html" style="padding-left: 30px;">Index 5</a></li>
                            <li class="selected--last"><a href="index-6.html" style="padding-left: 30px;">Index 6</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="car-list-fullWidth.php">Fleet <em class="fa fa-chevron-down"></em></a>
                        <ul>
                            <li>
                                <a href="#" style="padding-left: 30px;">List Layout <em class="fa fa-chevron-down"></em></a>
                                <ul>
                                    <li class="selected--last"><a class="dropdown-item" href="car-list-rightside.html" style="padding-left: 50px;">List Right Sidebar</a></li>
                                    <li class="selected--last"><a class="dropdown-item" href="car-list-leftsidebar.html" style="padding-left: 50px;">List Left Sidebar</a></li>
                                    <li class="selected--last"><a class="dropdown-item" href="car-list-fullWidth.php" style="padding-left: 50px;">List FullWidth</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" style="padding-left: 30px;">Grid Layout <em class="fa fa-chevron-down"></em></a>
                                <ul>
                                    <li class="selected--last"><a class="dropdown-item" href="car-grid-rightside.html" style="padding-left: 50px;">Grid Right Sidebar</a></li>
                                    <li class="selected--last"><a class="dropdown-item" href="car-grid-leftside.html" style="padding-left: 50px;">Grid Left Sidebar</a></li>
                                    <li class="selected--last"><a class="dropdown-item" href="car-grid-fullWidth.html" style="padding-left: 50px;">Grid FullWidth</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#" style="padding-left: 30px;">Car Details <em class="fa fa-chevron-down"></em></a>
                                <ul>
                                    <li class="selected--last"><a class="dropdown-item" href="car-details.html" style="padding-left: 50px;">Car Details 1</a></li>
                                    <li class="selected--last"><a class="dropdown-item" href="car-details-2.html" style="padding-left: 50px;">Car Details 2</a></li>
                                    <li class="selected--last"><a class="dropdown-item" href="car-details-3.html" style="padding-left: 50px;">Car Details 3</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li><a href="#" class="active">Pages <em class="fa fa-chevron-down"></em></a>
                        <ul>
                            <li class="selected--last">
                                <a href="about.html" style="padding-left: 30px;">About Us</a>
                            </li>
                            <li class="selected--last">
                                <a href="services.html" style="padding-left: 30px;">Services</a>
                            </li>
                            <li class="selected--last">
                                <a href="agent.html" style="padding-left: 30px;">Agent</a>
                            </li>
                            <li class="selected--last">
                                <a href="car-comparison.html" style="padding-left: 30px;">Car Compare</a>
                            </li>
                            <li class="selected--last">
                                <a href="car-reviews.html" style="padding-left: 30px;">Car Reviews</a>
                            </li>
                            <li class="selected--last">
                                <a href="gallery.html" style="padding-left: 30px;">Gallery</a>
                            </li>
                            <li class="selected--last">
                                <a href="typography.html" style="padding-left: 30px;">Typography</a>
                            </li>
                            <li class="selected--last">
                                <a href="pricing-tables.html" style="padding-left: 30px;">Pricing Tables</a>
                            </li>
                            <li class="selected--last">
                                <a href="elements.html" style="padding-left: 30px;">Elements</a>
                            </li>
                            <li class="selected--last">
                                <a href="faq.html" style="padding-left: 30px;">Faq</a>
                            </li>
                            <li class="selected--last">
                                <a href="icon.html" style="padding-left: 30px;">Icons</a>
                            </li>
                            <li class="selected--last">
                                <a href="coming-soon.html" style="padding-left: 30px;">Coming Soon</a>
                            </li>
                            <li class="selected--last">
                                <a href="404.html" style="padding-left: 30px;">Error Page</a>
                            </li>
                            <li class="selected--last">
                                <a href="login.html" style="padding-left: 30px;">login</a>
                            </li>
                            <li class="selected--last">
                                <a href="signup.html" style="padding-left: 30px;">Register</a>
                            </li>
                        </ul>
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
    <div class="container">
        <h2>Your Reservations</h2>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="row">
                <?php while ($reservation = $result->fetch_assoc()): ?>
                    <div class="col-md-4">
                        <div class="card mb-4 shadow-sm">
                            <img src="<?php echo $reservation['image1']; ?>" class="card-img-top" alt="Car Image">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $reservation['brand'] . " " . $reservation['model']; ?></h5>
                                <p class="card-text">
                                    <strong>Year:</strong> <?php echo $reservation['year']; ?><br>
                                    <strong>Mileage:</strong> <?php echo number_format($reservation['mileage']); ?> km<br>
                                    <strong>Color:</strong> <?php echo $reservation['color']; ?><br>
                                    <strong>Fuel Type:</strong> <?php echo $reservation['fuel_type']; ?><br>
                                    <strong>Price per Day:</strong> $<?php echo number_format($reservation['price'], 2); ?><br>
                                    <strong>Reservation Date:</strong> <?php echo $reservation['reservation_date']; ?><br>
                                    <strong>Return Date:</strong> <?php echo $reservation['return_date']; ?><br>
                                </p>
                                <a href="car-details.php?car_id=<?php echo $reservation['car_id']; ?>" class="btn btn-primary">View Car Details</a>
                                <a href="report.php?reservation_id=<?php echo $reservation['reservation_id']; ?>" class="btn btn-primary">View Report</a>

            

            
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#damage-detection-form').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submission

        var formData = new FormData(this); // Create FormData object with the uploaded image

        $.ajax({
            url: 'http://127.0.0.1:5000/upload', // Replace with your Flask server URL
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            success: function(data) {
                if (data.error) {
                    $('#damage-detection-result').html('<p class="text-danger">' + data.error + '</p>');
                } else {
                    // Show the processed image in the result div
                    $('#damage-detection-result').html('<img src="http://127.0.0.1:5000/uploads/' + data.filename + '" class="img-fluid" alt="Detected Damage Image">');
                }
            },
           

        });
    });
});
</script>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p>No reservations found.</p>
        <?php endif; ?>
    </div>
</div>

<?php
// Close the database connection only once, after everything is done
if (!$conn->connect_errno) {
    $conn->close();
}
?>
   
    
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