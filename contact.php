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
                    <li class="nav-item dropdown">
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
                    <li class="nav-item dropdown active">
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
                <li><a href="index-4.php" class="pt0">Home<em class="fa fa-chevron-down"></em></a>
                   
                </li>
                <li>
                    <a href="car-list-fullWidth.php">Fleet <em class="fa fa-chevron-down"></em></a>
                    <ul>
                        
                        <li>
                            <a href="#">Grid Layout <em class="fa fa-chevron-down"></em></a>
                            <ul>
                                <li><a class="dropdown-item" href="car-grid-rightside.html">Grid Right Sidebar</a></li>
                                <li><a class="dropdown-item" href="car-grid-leftside.html">Grid Left Sidebar</a></li>
                                <li><a class="dropdown-item" href="car-grid-fullWidth.html">Grid FullWidth</a></li>
                            </ul>
                        </li>
                        <li>
                            <a href="#">Car Details <em class="fa fa-chevron-down"></em></a>
                            <ul>
                                <li><a class="dropdown-item" href="car-details.html">Car Details 1</a></li>
                                <li><a class="dropdown-item" href="car-details-2.html">Car Details 2</a></li>
                                <li><a class="dropdown-item" href="car-details-3.html">Car Details 3</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                
                        <li>
                            <a href="login.html">login</a>
                        </li>
                        
                    </ul>
                </li>
                
                
                <li>
                    <a href="contact.php" class="active">Contact</a>
                </li>
                <li>
                    <a href="login.html" class="nav-link h-icon">
                        <i class="flaticon-logout"></i>
                    </a>
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
</nav>
<!-- Sidenav end -->

<!-- Sub banner start -->
<div class="sub-banner">
    <div class="container breadcrumb-area">
        <div class="breadcrumb-areas">
            <h1>Contact Us</h1>
            <ul class="breadcrumbs">
                <li><a href="index-4.php">Home</a></li>
                <li class="active">Contact Us</li>
            </ul>
        </div>
    </div>
</div>
<!-- Sub Banner end -->

<!-- Contact 1 start -->
<div class="contact-1 content-area-5">
    <div class="container">
        <!-- Main title -->
        <div class="main-title text-center">
            <h1 class="mb-10">Get In Touch</h1>
            <div class="title-border">
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
                <div class="title-border-inner"></div>
            </div>
        </div>
        <div class="bg-white">
            <div class="row g-0">
                <div class="col-lg-7 col-md-12 col-sm-12 col-pad2">
                    <!-- Contact form start -->
                    <div class="contact-form contact-pad">
                        <h3>Send us a Message</h3>
                        <form id="contact_form" action="save_contact.php" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group name">
                <input type="text" name="name" class="form-control" placeholder="Name" aria-label="Full Name" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group email">
                <input type="email" name="email" class="form-control" placeholder="Email Address" aria-label="Email Address" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group subject">
                <input type="text" name="subject" class="form-control" placeholder="Subject" aria-label="Subject" required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group number">
                <input type="text" name="phone" class="form-control" placeholder="Phone" aria-label="Phone Number">
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group message">
                <textarea class="form-control" name="message" placeholder="Write message" aria-label="Write message" required></textarea>
            </div>
        </div>
        <div class="col-md-12">
            <div class="send-btn text-center">
                <button type="submit" class="btn-6">Send Message</button>
            </div>
        </div>
    </div>
</form>

                    </div>
                    <!-- Contact form end -->
                </div>
                <div class="col-lg-5 col-md-12 col-sm-12 col-pad2">
                    <!-- Contact details start -->
                    <div class="contact-details">
                        <h3>Opening Hours</h3>
                        <div class="ci-box d-flex">
                            <div class="icon">
                                <i class="fa fa-map-marker"></i>
                            </div>
                            <div class="detail align-self-center">
                                <h4>Office Address</h4>
                                <p>Saudi Arabia,Riyadh </p>
                            </div>
                        </div>
                        <div class="ci-box d-flex">
                            <div class="icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="detail align-self-center">
                                <h4>Phone Number</h4>
                                <p>
                                    <a href="tel:0477-0477-8556-552">Office: 0555785595</a>
                                </p>
                            </div>
                        </div>
                        <div class="ci-box d-flex">
                            <div class="icon">
                                <i class="fa fa-envelope"></i>
                            </div>
                            <div class="detail align-self-center">
                                <h4>Email Address</h4>
                                <p>
                                    <a href="mailto:Detech@gmail.com">Detech@gmail.com</a>
                                </p>
                            </div>
                        </div>
                        
                        <h3>Follow Us</h3>
                        <ul class="social-list clearfix">
                            <li>
                                <a href="#" class="facebook-bg">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li>
                                <a href="#" class="twitter-bg">
                                    <i class="fa fa-twitter"></i>
                                </a>
                            </li>
                         
                            
                           
                        </ul>
                    </div>
                    <!-- Contact details end -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Contact 1 end -->

<!-- Google map start -->
<div class="section">
    <div class="map">
        <div id="map" class="contact-map"></div>
    </div>
</div>
<!-- Google map end -->

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

<script  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD4omYJlOaP814WDcCG8eubXcbhB-44Uac"></script>
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

</body>
</html>