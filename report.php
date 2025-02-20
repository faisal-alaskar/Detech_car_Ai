<?php
include 'db.php'; // الاتصال بقاعدة البيانات

if (isset($_GET['reservation_id'])) {
    $reservation_id = intval($_GET['reservation_id']);
} else {
    die("Reservation ID is required.");
}

// استرجاع بيانات الحجز
$sql = "SELECT r.reservation_id, c.car_id, rp.current_mileage, rp.return_mileage, rp.miles_used, 
        rp.damage_before, rp.damage_after, rp.front_photo_before, rp.front_photo_after, 
        rp.right_photo_before, rp.right_photo_after, rp.back_photo_before, rp.back_photo_after, 
        rp.left_photo_before, rp.left_photo_after, c.price, r.reservation_date, r.return_date, 
        u.full_name
        FROM reservations r
        JOIN cars c ON r.car_id = c.car_id
        JOIN report rp ON r.reservation_id = rp.reservation_id
        JOIN users u ON r.user_id = u.user_id
        WHERE r.reservation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $reservation_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("No report found for the given reservation ID.");
}

$report = $result->fetch_assoc();

// حساب عدد الأيام والسعر الإجمالي
$reservation_date = new DateTime($report['reservation_date']);
$return_date = new DateTime($report['return_date']);
$days_used = $reservation_date->diff($return_date)->days;
$total_price = $days_used * $report['price'];

// استخراج البيانات من قاعدة البيانات
$damage_before = isset($report['damage_before']) ? explode(',', $report['damage_before']) : [];
$damage_after = isset($report['damage_after']) ? explode(',', $report['damage_after']) : [];

// تنظيف القيم
$damage_before = array_map('trim', array_map('strtolower', $damage_before));
$damage_after = array_map('trim', array_map('strtolower', $damage_after));

$compare_url = 'http://localhost/detech/compare_damage.php'; // تحقق من المسار الصحيح
$post_data = [
    'damage_before' => $report['damage_before'],
    'damage_after' => $report['damage_after']
];

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $compare_url);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
curl_close($ch);

// ** تحويل البيانات المسترجعة من JSON إلى مصفوفة PHP **
$response_data = json_decode($response, true);

// ** تصحيح الأخطاء: طباعة النتائج للتحقق منها **

$new_damages = $response_data['new_damages'] ?? [];


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
    <link rel="stylesheet" type="text/css" href="css/style1.css">


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
                <h1>Deliver/retern car</h1>
                <
            </div>
        </div>
    </div>
    <!-- Sub Banner end -->
    
    <!-- Featured car start -->
    <div class="featured-car content-area-15 bg-light p-4 rounded shadow-sm">
    <meta charset="UTF-8">
    <!--  تضمين Bootstrap و Magnific Popup -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
    
    <h2 class="text-center mb-4">Car Report for Reservation #<?php echo $reservation_id; ?></h2>

    <div class="row mb-4">
        <div class="col-md-6">
            <h4>Details</h4>
            <ul>
                <li>Customer Name: <?php echo htmlspecialchars($report['full_name']); ?></li>
                <li>Current Mileage: <?php echo $report['current_mileage']; ?> KM</li>
                <li>Return Mileage: <?php echo $report['return_mileage']; ?> KM</li>
                <li>Miles Used: <?php echo $report['miles_used']; ?> KM</li>
                <li>Reservation Days: <?php echo $days_used; ?> Days</li>
                <li>Total Price: <?php echo $total_price; ?> SAR</li>
            </ul>
        </div>
        
        <div class="col-md-6">
    <h4 class="text-danger text-center">New Damages Detected</h4>
    <ul class="list-unstyled">
        <?php if (!empty($new_damages)): ?>
            <?php foreach ($new_damages as $damage): ?>
                <li class="text-danger fw-bold">🚨 <?php echo $damage; ?></li>
            <?php endforeach; ?>
        <?php else: ?>
            <li class="text-success">No new damages detected.</li>
        <?php endif; ?>
    </ul>
</div>

</div>


    </div>

    <div class="text-center mb-4">
        <button id="toggleButton" class="btn btn-primary" onclick="togglePhotos()">Show Photos</button>
    </div>

    <div id="carPhotos" style="display: none;">
        <h4 class="text-center">Car Photos</h4>
        <div class="row g-3">
            <?php
            $photos = [
                'Front View Before' => "uploads/modified_{$reservation_id}_front_view.jpg|uploads/{$reservation_id}_front_view.jpg",
                'Right Side View Before' => "uploads/modified_{$reservation_id}_right_side_view.jpg|uploads/{$reservation_id}_right_side_view.jpg",
                'Back View Before' => "uploads/modified_{$reservation_id}_back_view.jpg|uploads/{$reservation_id}_back_view.jpg",
                'Left Side View Before' => "uploads/modified_{$reservation_id}_left_side_view.jpg|uploads/{$reservation_id}_left_side_view.jpg",
                'Front View After' => "uploads/modified_RE_{$reservation_id}_front_view.jpg|uploads/RE_{$reservation_id}_front_view.jpg",
                'Right Side View After' => "uploads/modified_RE_{$reservation_id}_right_side_view.jpg|uploads/RE_{$reservation_id}_right_side_view.jpg",
                'Back View After' => "uploads/modified_RE_{$reservation_id}_back_view.jpg|uploads/RE_{$reservation_id}_back_view.jpg",
                'Left Side View After' => "uploads/modified_RE_{$reservation_id}_left_side_view.jpg|uploads/RE_{$reservation_id}_left_side_view.jpg",
            ];

            foreach ($photos as $label => $paths) {
                $path_options = explode('|', $paths);
                $final_path = null;
                foreach ($path_options as $path) {
                    if (file_exists($path)) {
                        $final_path = $path;
                        break;
                    }
                }

                if ($final_path) {
                    echo "
                    <div class='col-md-3'>
                        <h6 class='text-center'>$label</h6>
                        <a href='$final_path' class='image-popup'>
                            <img src='$final_path' class='img-thumbnail' alt='$label'>
                        </a>
                    </div>";
                } else {
                    echo "
                    <div class='col-md-3'>
                        <h6 class='text-center text-danger'>$label</h6>
                        <p class='text-muted text-center'>Image Not Found</p>
                    </div>";
                }
            }
            ?>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.image-popup').magnificPopup({
                type: 'image',
                gallery: { enabled: true },
                mainClass: 'mfp-fade',
                removalDelay: 300,
                closeOnContentClick: true
            });
        });

        function togglePhotos() {
            const photosSection = document.getElementById('carPhotos');
            const toggleButton = document.getElementById('toggleButton');
            if (photosSection.style.display === 'none') {
                photosSection.style.display = 'block';
                toggleButton.textContent = 'Hide Photos';
            } else {
                photosSection.style.display = 'none';
                toggleButton.textContent = 'Show Photos';
            }
        }
    </script>

    
    
</div>


    
    
</div>

    </div>
    
    <!-- Yompare info start -->
    
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