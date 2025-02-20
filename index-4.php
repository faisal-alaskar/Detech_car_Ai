<?php
// Always start the session at the very top before any HTML output
if (session_status() == PHP_SESSION_NONE) {
    session_start();
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>


    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script  src="js/html5shiv.min.js"></script>
    <script  src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="page_loader"></div>

<!-- Main header start -->
<header class="main-header header-fixed sticky-header" id="main-header-3">
    <div class="container">
        <div class="header-inner">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand logos d-flex w-33 mr-auto" href="index-4.php">
                    <img src="img/logos/black-logo.png" alt="logo" class="logo-photo">
                </a>
                <button class="navbar-toggler" id="drawer" type="button">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="navbar-collapse collapse w-100 justify-content-end" id="navbar">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown active">
                            <a class="nav-link dropdown-toggle" href="index-4.php" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Home
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                              
                               
                              
                            </ul>
                        </li>
                        <li class="nav-item dropdown">
                        <a class="nav-link" href="car-list-fullWidth.php">
                             Fleet
                        </a>

                            
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
?>

                        </li>
                        <li class="nav-item dropdown">
                            <a href="#full-page-search" class="nav-link h-icon">
                                <i class="fa fa-search"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
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
if (isset($_SESSION['role'])) {
    if ($_SESSION['role'] == 'admin') {
        echo '<a class="nav-link" href="admin_dashboard.php">Admin Dashboard</a>';
    } elseif ($_SESSION['role'] == 'customer') {
        echo '<a class="nav-link" href="customer.php">My Reservations</a>';
    }
}
?>
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

<!-- Banner start -->
<div class="banner" id="banner4">
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner banner-slider-inner text-center">
            <div class="carousel-item banner-max-height active item-bg">
                <img class="d-block w-100 h-100" src="img\banner\img-5.png" alt="banner">
                <div class="carousel-content container banner-info-2 bi-2 text-left">
                    <div class="row bi5">
                        <div class="col-lg-7 align-self-center">
                            <div class="banner-content3">
                                <h3 class="mb-30">Explore Our Car</h3>
                                <div class="price">
                                    <div class="monthly">
                                        <h4>SAR120</h4>
                                        <h6>Day</h6>
                                    </div>
                                    <div class="fresh">
                                        <h5>Refreshed Style, <br>High Performance</h5>
                                    </div>
                                </div>
                                <div class="clearfix">
                                    <a href="car-list-fullWidth.php" class="btn btn-lg btn-round btn-theme">Rent now</a>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="search-box-4">
                                <form method="GET">
                                <div class="form-group">
            
            <select class="selectpicker search-fields" name="select-brand" id="select-brand">
                <option>Select Brand</option>
                <?php
                // Include your database connection
                include 'db.php'; 

                // Check if connection is successful
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Query to fetch distinct car brands
                $sql = "SELECT DISTINCT brand FROM cars";
                $result = $conn->query($sql);

                // Check if query was successful
                if (!$result) {
                    die("Query failed: " . $conn->error);
                }

                // Output number of brands found for debugging
                echo "Number of brands found: " . $result->num_rows . "<br>";

                // Check if there are results
                if ($result->num_rows > 0) {
                    // Loop through the results and output each brand as an option
                    while ($row = $result->fetch_assoc()) {
                        echo '<option value="' . htmlspecialchars($row['brand']) . '">' . htmlspecialchars($row['brand']) . '</option>';
                    }
                } else {
                    echo '<option>No Brands Available</option>';
                }

                $conn->close();  // Close the database connection
                ?>
            </select>
        </div>
                                    
                                    <div class="form-group">
           
                                        <select class="selectpicker search-fields" name="select-model" id="select-model">
                                        <option>Select Model</option>
                                        <?php
                                        // Include your database connection
                                        include 'db.php'; 

                                        // Query to fetch distinct car models
                                        $sql = "SELECT DISTINCT model FROM cars";
                                        $result = $conn->query($sql);

                                        // Check if there are results
                                        if ($result->num_rows > 0) {
                                            // Loop through the results and output each model as an option
                                            while ($row = $result->fetch_assoc()) {
                                                echo '<option value="' . htmlspecialchars($row['model']) . '">' . htmlspecialchars($row['model']) . '</option>';
                                            }
                                        } else {
                                            echo '<option>No Models Available</option>';
                                        }

                                        $conn->close();  // Close the database connection
                                        ?>
                                         </select>
                                    </div>
                                    
                                    <div class="form-group">
            
                                        <select class="selectpicker search-fields" name="select-year" id="select-year">
                                            <option>Select Year</option>
                                            <?php
                                            // Include your database connection
                                            include 'db.php'; 

                                            // Query to fetch distinct years from the 'cars' table
                                            $sql = "SELECT DISTINCT year FROM cars ORDER BY year DESC";
                                            $result = $conn->query($sql);

                                            // Check if there are results
                                            if ($result->num_rows > 0) {
                                                // Loop through the results and output each year as an option
                                                while ($row = $result->fetch_assoc()) {
                                                    echo '<option value="' . htmlspecialchars($row['year']) . '">' . htmlspecialchars($row['year']) . '</option>';
                                                }
                                            } else {
                                                echo '<option>No Years Available</option>';
                                            }

                                            $conn->close();  // Close the database connection
                                            ?>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <button class="btn w-100 button-theme btn-md">
                                            Find
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Banner end -->

<!-- Search box 3 start -->
<div class="search-box-3 d-lg-none d-xl-none">
    <div class="container">
        <form method="GET">
            <div class="form-group">
                <div class="dropdown bootstrap-select search-fields">
                    <select class="selectpicker search-fields" name="select-brand-mobile" id="select-brand-mobile">
                        <option>Select Brand</option>
                        <option value="BMW">BMW</option>
                        <option value="lucid">Lucid</option>
                        <option value="Audi">Audi</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="dropdown bootstrap-select search-fields">
                    <select class="selectpicker search-fields" name="select-model-mobile" id="select-model-mobile">
                        <option>Select Model</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="dropdown bootstrap-select search-fields">
                    <select class="selectpicker search-fields" name="select-year-mobile" id="select-year-mobile">
                        <option>Select Year</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                                        <button class="btn w-100 button-theme btn-md">
                                            Find
                                        </button>
                                    </div>
        </form>
    </div>
</div>

<!-- Search box 3 end -->



<!-- Advantages 2 start -->
<div class="advantages-2 content-area bg-grea-3">
    <div class="container">
        <!-- Main title -->
        <div class="main-title">
            <h1 class="mb-10">Our Advantages</h1>
            <div class="title-border">
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="advantages-box-2 df-box">
                    <div class="icon">
                        <i class="flaticon-shield"></i>
                    </div>
                    <div class="detail">
                        <h5>
                        Accurate Damage Detection

                        </h5>
                        <p>Our advanced AI system ensures precise detection of scratches and damages, giving you confidence that your vehicle’s condition is properly documented every time

                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="advantages-box-2 df-box">
                    <div class="icon">
                        <i class="flaticon-deal"></i>
                    </div>
                    <div class="detail">
                        <h5>
                            Transparency and Trust
                        </h5>
                        <p>Say goodbye to disputes! Our system provides clear, visual proof of the vehicle’s condition, ensuring trust and transparency  throughout your rental experience.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="advantages-box-2 df-box">
                    <div class="icon">
                        <i class="flaticon-money"></i>
                    </div>
                    <div class="detail">
                        <h5>
                            <a href="services.html">Time Efficiency
                            </a>
                        </h5>
                        <p>We value your time. Our automated inspection process significantly reduces waiting times, helping you get on the road faster with ease.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="advantages-box-2 df-box">
                    <div class="icon">
                        <i class="flaticon-support-2"></i>
                    </div>
                    <div class="detail">
                        <h5>
                        Free Support                        </h5>
                        <p>We’re always here to help. Our dedicated support team is available to answer any questions or assist with any issues, ensuring your rental experience is worry-free from start to finish.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Advantages 2 end -->

<!-- Latest offers Start -->

<!-- Latest offers end -->

<!-- Our team start -->

<!-- Our team end -->




<!-- Intro section start -->
<div class="intro-section">
    <div class="intro-section-inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 col-md-8 col-sm-12">
                    <div class="intro-text">
                        <h3>Do You Have Questions ?</h3>
                    </div>
                </div>
                <div class="col-lg-3 col-md-4 col-sm-12">
                    <a href="contact.php" class="btn btn-md">Get in Touch</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Intro section end -->

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
                            <i class="flaticon-pin"></i>Riyadh
                        </li>
                        <li>
                            <i class="flaticon-mail"></i><a href="mailto:Detech@gmail.com">DeTech@gmail.com</a>
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
    <div class="modal fade" id="carOverviewModal" tabindex="-1" role="dialog" aria-labelledby="carOverviewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="carOverviewModalLabel">
                        Find Your Dream Car
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
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
<script>
    $(document).ready(function() {
        // Initialize bootstrap-select for dropdowns
        $('.selectpicker').selectpicker();

        // Update the model dropdown when the brand is selected
        $('#select-brand').on('change', function() {
            var selectedBrand = $(this).val();
            if (selectedBrand) {
                // Fetch models based on selected brand
                $.ajax({
                    url: 'get_models.php', // API endpoint
                    type: 'GET',
                    data: { brand: selectedBrand },
                    success: function(models) {
                        $('#select-model').empty().append('<option>Select Model</option>');

                        // Populate models dynamically
                        $.each(JSON.parse(models), function(index, model) {
                            $('#select-model').append('<option value="' + model + '">' + model + '</option>');
                        });

                        // Refresh the model dropdown to apply changes
                        $('#select-model').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve models. Please try again.");
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize bootstrap-select for dropdowns
        $('.selectpicker').selectpicker();

        // Update the model dropdown when the brand is selected
        $('#select-brand').on('change', function() {
            var selectedBrand = $(this).val();
            if (selectedBrand) {
                // Fetch models based on selected brand
                $.ajax({
                    url: 'get_models.php', // API endpoint for models
                    type: 'GET',
                    data: { brand: selectedBrand },
                    success: function(models) {
                        $('#select-model').empty().append('<option>Select Model</option>');

                        // Populate models dynamically
                        $.each(JSON.parse(models), function(index, model) {
                            $('#select-model').append('<option value="' + model + '">' + model + '</option>');
                        });

                        // Refresh the model dropdown to apply changes
                        $('#select-model').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve models. Please try again.");
                    }
                });
            }
        });

        // Update the year dropdown when the model is selected
        $('#select-model').on('change', function() {
            var selectedModel = $(this).val();
            if (selectedModel) {
                // Fetch years based on selected model
                $.ajax({
                    url: 'get_years.php', // API endpoint for years
                    type: 'GET',
                    data: { model: selectedModel },
                    success: function(years) {
                        $('#select-year').empty().append('<option>Select Year</option>');

                        // Populate years dynamically
                        $.each(JSON.parse(years), function(index, year) {
                            $('#select-year').append('<option value="' + year + '">' + year + '</option>');
                        });

                        // Refresh the year dropdown to apply changes
                        $('#select-year').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve years. Please try again.");
                    }
                });
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.selectpicker').selectpicker();

        $('#select-brand').on('change', function() {
            var selectedBrand = $(this).val();
            if (selectedBrand) {
                $.ajax({
                    url: 'get_models.php',
                    type: 'GET',
                    data: { brand: selectedBrand },
                    success: function(models) {
                        $('#select-model').empty().append('<option>Select Model</option>');
                        $.each(JSON.parse(models), function(index, model) {
                            $('#select-model').append('<option value="' + model + '">' + model + '</option>');
                        });
                        $('#select-model').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve models. Please try again.");
                    }
                });
            }
        });

        $('#select-model').on('change', function() {
            var selectedModel = $(this).val();
            if (selectedModel) {
                $.ajax({
                    url: 'get_years.php',
                    type: 'GET',
                    data: { model: selectedModel },
                    success: function(years) {
                        $('#select-year').empty().append('<option>Select Year</option>');
                        $.each(JSON.parse(years), function(index, year) {
                            $('#select-year').append('<option value="' + year + '">' + year + '</option>');
                        });
                        $('#select-year').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve years. Please try again.");
                    }
                });
            }
        });

        $('.button-theme').on('click', function(event) {
            event.preventDefault();
            const brand = $('#select-brand').val();
            const model = $('#select-model').val();
            const year = $('#select-year').val();

            if (brand && model && year) {
                $.ajax({
                    url: 'get_car_id.php', // API endpoint to get car_id
                    type: 'GET',
                    data: { brand: brand, model: model, year: year },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.car_id) {
                            window.location.href = `car-details.php?car_id=${data.car_id}`;
                        } else {
                            alert("No car found for the selected criteria.");
                        }
                    },
                    error: function() {
                        alert("Failed to retrieve car details. Please try again.");
                    }
                });
            } else {
                alert("Please select Brand, Model, and Year.");
            }
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Initialize bootstrap-select for dropdowns
        $('.selectpicker').selectpicker();

        // Mobile search box (search-box-3) for updating model and year dynamically
        $('#select-brand-mobile').on('change', function() {
            var selectedBrand = $(this).val();
            if (selectedBrand) {
                $.ajax({
                    url: 'get_models.php',
                    type: 'GET',
                    data: { brand: selectedBrand },
                    success: function(models) {
                        $('#select-model-mobile').empty().append('<option>Select Model</option>');

                        $.each(JSON.parse(models), function(index, model) {
                            $('#select-model-mobile').append('<option value="' + model + '">' + model + '</option>');
                        });

                        $('#select-model-mobile').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve models. Please try again.");
                    }
                });
            } else {
                $('#select-model-mobile').empty().append('<option>Select Model</option>');
                $('#select-model-mobile').selectpicker('refresh');
            }
        });

        $('#select-model-mobile').on('change', function() {
            var selectedModel = $(this).val();
            if (selectedModel) {
                $.ajax({
                    url: 'get_years.php',
                    type: 'GET',
                    data: { model: selectedModel },
                    success: function(years) {
                        $('#select-year-mobile').empty().append('<option>Select Year</option>');

                        $.each(JSON.parse(years), function(index, year) {
                            $('#select-year-mobile').append('<option value="' + year + '">' + year + '</option>');
                        });

                        $('#select-year-mobile').selectpicker('refresh');
                    },
                    error: function() {
                        alert("Failed to retrieve years. Please try again.");
                    }
                });
            } else {
                $('#select-year-mobile').empty().append('<option>Select Year</option>');
                $('#select-year-mobile').selectpicker('refresh');
            }
            $('.search-box-3 .button-theme').on('click', function(event) {
            event.preventDefault();
            const brand = $('#select-brand-mobile').val();
            const model = $('#select-model-mobile').val();
            const year = $('#select-year-mobile').val();

            if (brand && model && year) {
                $.ajax({
                    url: 'get_car_id.php', // API endpoint to get car_id based on selections
                    type: 'GET',
                    data: { brand: brand, model: model, year: year },
                    success: function(response) {
                        const data = JSON.parse(response);
                        if (data.car_id) {
                            // Redirect to car details page with car_id
                            window.location.href = `car-details.php?car_id=${data.car_id}`;
                        } else {
                            alert("No car found for the selected criteria.");
                        }
                    },
                    error: function() {
                        alert("Failed to retrieve car details. Please try again.");
                    }
                });
            } else {
                alert("Please select Brand, Model, and Year.");
            }
        });
        });
    });
</script>

</body>
</html>