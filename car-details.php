<?php
include 'db.php'; // الاتصال بقاعدة البيانات

//  التحقق من وجود car_id في الرابط
if (isset($_GET['car_id'])) {
    $car_id = intval($_GET['car_id']); // تأمين المتغير من الإدخالات الضارة

    //  استعلام لجلب بيانات السيارة
    $sql = "SELECT brand, model, year, mileage, color, fuel_type, price, image1, image2, image3 
            FROM cars 
            WHERE car_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $car_id);
    $stmt->execute();
    $result = $stmt->get_result();

    //  التحقق مما إذا كانت السيارة موجودة
    if ($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {
        echo "🚨 Car not found.";
        exit;
    }
 

    //  استعلام لجلب الملاحظات المرتبطة بالسيارة
    $sql_notes = "SELECT note, created_at FROM car_notes WHERE car_id = ? ORDER BY created_at DESC";
    $stmt_notes = $conn->prepare($sql_notes);
    $stmt_notes->bind_param("i", $car_id);
    $stmt_notes->execute();
    $result_notes = $stmt_notes->get_result();

    $car_notes = [];
    while ($row = $result_notes->fetch_assoc()) {
        $car_notes[] = $row;
    }
    $stmt_notes->close();

    //  إغلاق الاتصال الآن بعد تنفيذ كل الاستعلامات
    $conn->close();
} else {
    echo "🚨 No car selected.";
    exit;
}

session_start(); //  تشغيل الجلسة
if (!isset($_SESSION['user_id'])) {
    //  إعادة التوجيه إلى صفحة تسجيل الدخول في حالة عدم تسجيل الدخول
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
<header class="top-header" id="top-header-2">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-7 col-7">
                <div class="list-inline">
                    <a href="#"><i class="fa fa-map-marker"></i> Riyadh</a>
                    <a href="tel:DeTech@gmail.com" class="d-none-768"><i class="fa fa-envelope"></i>DeTech@gmail.com</a>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-5 col-5">
                <ul class="top-social-media pull-right">
                    <li>
                        <a href="login.html" class="sign-in"><i class="fa fa-sign-in"></i> Login</a>
                    </li>
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
            <a class="navbar-brand logos" href="index.html">
                <img src="img/logos/black-logo.png" alt="logo">
            </a>
        </div>
        <button class="navbar-toggler" id="drawer" type="button">
            <span class="fa fa-bars"></span>
        </button>
        <div class="navbar-collapse collapse w-100 justify-content-end" id="navbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown active">
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
                <li><a href="#" class="pt0">Index <em class="fa fa-chevron-down"></em></a>
                    <ul>
                                                <li><a href="index-4.php">Index 4</a></li>
                       
                    </ul>
                </li>
                <li>
                    <a href="#" class="active">Fleet <em class="fa fa-chevron-down"></em></a>
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
                    <a href="contact.php">Contact</a>
                </li>
                <li>
                    <a href="login.html" class="nav-link h-icon">
                        <i class="flaticon-logout"></i>
                    </a>
                </li>
                <li>
                    <a href="#full-page-search" class="nav-link h-icon">
                        <i class="fa fa-search"></i>
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
            <h1>Car Details</h1>
            <ul class="breadcrumbs">
                <li><a href="index.html">Home</a></li>
                <li class="active">Car Details</li>
            </ul>
        </div>
    </div>
</div>
<!-- Sub Banner end -->
<!-- Car details page start -->
<div class="car-details-page content-area-6">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-12 col-xs-12">
                <div class="car-details-section">
                    <!-- Cardetailsslider 2 start -->
                    <div class="cardetailsslider-2 mb-40">
                        <div class="main clearfix">
                            <div class="slider slider-fors">
                                <div class="slider-slider-for-photo"><img src="<?php echo htmlspecialchars($car['image1']); ?>" class="img-fluid w-100" alt="slider-car"></div>
                                <div class="slider-slider-for-photo"><img src="<?php echo htmlspecialchars($car['image2']); ?>" class="img-fluid w-100" alt="slider-car"></div>
                                <div class="slider-slider-for-photo"><img src="<?php echo htmlspecialchars($car['image3']); ?>" class="img-fluid w-100" alt="slider-car"></div>
                            </div>
                            <div class="slider-navs-box">
                                <div class="slider slider-navs">
                                    <div><img src="<?php echo htmlspecialchars($car['image1']); ?>" class="slider-photo" alt="slider-car"></div>
                                    <div><img src="<?php echo htmlspecialchars($car['image2']); ?>" class="slider-photo" alt="slider-car"></div>
                                    <div><img src="<?php echo htmlspecialchars($car['image3']); ?>" class="slider-photo" alt="slider-car"></div>
                                </div>
                            </div>
                            <div class="heading-car-2">
                                <div class="pull-left">
                                    <h3><?php echo htmlspecialchars($car['model']); ?> <?php echo htmlspecialchars($car['year']); ?></h3>
                                </div>
                                <div class="pull-right">
                                    <div class="price-box-3"><sup>$</sup><?php echo number_format($car['price']); ?><span>/day</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Advanced search start -->
                    <div class="widget-2 advanced-search bg-grea-2 d-lg-none d-xl-none">
                        <h3 class="sidebar-title">Booking This Car</h3>
                        <ul>
                            <li>
                                <span>Make</span>Ferrari
                            </li>
                            <li>
                                <span>Model</span>Maxima
                            </li>
                            <li>
                                <span>Body Style</span>Convertible
                            </li>
                            <li>
                                <span>Year</span>2017
                            </li>
                            <li>
                                <span>Condition</span>Brand New
                            </li>
                            <li>
                                <span>Mileage</span>34,000 mi
                            </li>
                            <li>
                                <span>Left Side  Color</span>Dark Grey
                            </li>
                            <li>
                                <span>Transmission</span>6-speed Manual
                            </li>
                            <li>
                                <span>Engine</span>3.4L Mid-Engine V6
                            </li>
                            <li>
                                <span>No. of Gears:</span>5
                            </li>
                            <li>
                                <span>Location</span>Toronto
                            </li>
                            <li>
                                <span>Fuel Type</span>Gasoline Fuel
                            </li>
                        </ul>
                    </div>
                    <!-- Tabbing box start -->
                    <div class="tabbing tabbing-box mb-40">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true">Description</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Specifications</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Car Notes</button>
                            </li>
                            
                            

                            

                            
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                <div class="accordion accordion-flush" id="accordionFlushExample">
                                    <div class="accordion-item">
                                        <div class="car-description mb-50">
                                            <h3 class="heading-2">
                                                Description
                                            </h3>
                                            <p>Dis1</p>
                                            <p>Dis2</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                <div class="accordion accordion-flush" id="accordionFlushExample2">
                                    <div class="accordion-item">
                                        <div class="car-amenities mb-40">
                                            <h3 class="heading-2">Specifications</h3>
                                            <div class="row">
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <ul class="amenities">
                                                        <li>
                                                            <i class="fa fa-check"></i>Specifications1
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <ul class="amenities">
                                                        <li>
                                                            <i class="fa fa-check"></i>Specifications2
                                                        </li>
                                                        
                                                    </ul>
                                                </div>
                                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                                    <ul class="amenities">
                                                        <li>
                                                            <i class="fa fa-check"></i>Specifications3
                                                        </li>
                                                       
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="contact" role="tabpanel" aria-labelledby="contact-tab">
    <div class="accordion accordion-flush" id="accordionFlushExample3">
        <div class="accordion-item">
            <div class="features-info mb-40">
                <h3 class="heading-2">Car Features & Notes</h3>
                <div class="row">
                    <?php if (!empty($car_notes)): ?>
                        <?php foreach ($car_notes as $index => $note): ?>
                            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                                <ul>
                                    <li>
                                        <strong>Note:</strong> <?php echo htmlspecialchars($note['note']); ?>
                                    </li>
                                    <li>
                                        <strong>Added on:</strong> <?php echo htmlspecialchars($note['created_at']); ?>
                                    </li>
                                </ul>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="text-center text-muted">No notes available for this car.</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

                            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                                <div class="accordion accordion-flush" id="accordionFlushExample3">
                                    <div class="accordion-item">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact-4" role="tabpanel" aria-labelledby="contact-tab-4">
                                <div class="accordion accordion-flush" id="accordionFlushExample4">
                                    <div class="accordion-item">
                                        
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact-5" role="tabpanel" aria-labelledby="contact-tab-5">
                                <div class="accordion accordion-flush" id="accordionFlushExample5">
                                    <div class="accordion-item">
                                        <div class="location mb-50">
                                            <div class="map">
                                                <h3 class="heading-2">Location</h3>
                                                <div id="map" class="contact-map"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="contact-6" role="tabpanel" aria-labelledby="contact-tab-6">
                                <div class="accordion accordion-flush" id="accordionFlushExample6">
                                    <div class="accordion-item">
                                        <div class="inside-car mb-50">
                                            <h3 class="heading-2">
                                                Video
                                            </h3>
                                            <iframe src="https://www.youtube.com/embed/V7IrnC9MISU" allowfullscreen=""></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    
                    
                </div>
            </div>
            <div class="col-lg-4 col-md-12">
                <div class="sidebar-right">
                    <!-- Advanced search start -->
                    <div class="widget advanced-search d-none d-xl-block d-lg-block">
                        <h3 class="sidebar-title">Booking This Car</h3>
                        <ul>
    <li>
        <span>brand</span> <?php echo htmlspecialchars($car['brand']); ?>
    </li>
    <li>
        <span>Model</span> <?php echo htmlspecialchars($car['model']); ?>
    </li>
    
    <li>
        <span>Year</span> <?php echo htmlspecialchars($car['year']); ?>
    </li>
    
    <li>
        <span>Mileage</span> <?php echo number_format($car['mileage']); ?> km
    </li>
    
    
    
    
    <li>
        <span>Fuel Type</span> <?php echo htmlspecialchars($car['fuel_type']); ?>
    </li>
</ul>
                    </div>
                    
                    </div>
                    <!-- Social sinks start -->
                 
                    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Car details page end -->

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
            
            
            <div class="col-xl-4 col-lg-3 col-md-6 col-sm-6">
                <div class="footer-item clearfix">
                    <h4>Subscribe</h4>
                    <div class="Subscribe-box">
                        <p>Subscribe to receive the latest offers, news, and updates from us! Be the first to know about exclusive deals and exciting new features.</p>
                        <form class="form-inline d-flex" action="#">
                            <input class="form-control" type="email" id="email" placeholder="Email Address...">
                            <button class="btn button-theme" type="submit"><i class="fa fa-paper-plane"></i></button>
                        </form>
                    </div>
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
        <form action="index.html#" class="search-boxs">
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
                    "<li><i class='flaticon-phone'></i>  DeTech@gmail.com</li> " +
                    "<li><a href='index.html'><i class='fa fa-globe'></i>  http://www.example.com</li></a> " +
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