<?php
include 'db.php'; // الاتصال بقاعدة البيانات

if (isset($_GET['reservation_id'])) {
    $reservation_id = intval($_GET['reservation_id']);
} else {
    die("Reservation ID is required.");
}

$message = "";
$upload_dir = 'uploads/';
$uploaded_images = [];
$processed_images = [];  //  الصور المعدلة مع المربعات
$mileage = 0;
$note = "";
$show_note_and_submit = false; //  عرض مربع الملاحظات بعد رفع الصور فقط


//  استرجاع بيانات الحجز
$sql = "SELECT r.reservation_id, c.car_id, c.mileage, r.note 
        FROM reservations r 
        JOIN cars c ON r.car_id = c.car_id 
        WHERE r.reservation_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $reservation_id);
$stmt->execute();
$result = $stmt->get_result();
$car = $result->fetch_assoc();
$car_id = $car['car_id'] ?? 0;
$mileage = $car['mileage'] ?? 0;
$note = $car['note'] ?? "";

//  رفع الصور والتحليل
if (isset($_POST['upload_images'])) {
    $image_labels = ["Front View", "Right Side View", "Back View", "Left Side View"];
    $damage_report = [];
    $damage_found = false;

    foreach ($image_labels as $index => $label) {
        $file_key = "image" . ($index + 1);
        if (isset($_FILES[$file_key]) && $_FILES[$file_key]['error'] == 0) {
            // الحصول على الامتداد الأصلي للملف
            $extension = pathinfo($_FILES[$file_key]['name'], PATHINFO_EXTENSION);
    
            // إنشاء اسم ملف جديد برقم الحجز ونوع الصورة
            $new_file_name = 'RE_' . $reservation_id . '_' . str_replace(' ', '_', strtolower($label)) . '.' . $extension;
            $image_path = $upload_dir . $new_file_name;
            
    
            // نقل الملف إلى المجلد المحدد
            if (move_uploaded_file($_FILES[$file_key]['tmp_name'], $image_path)) {
                $uploaded_images[$label] = $image_path;
            } else {
                $message .= "<div style='color:red;'>Error uploading image {$label}</div>";
            }
        }
    }
    


    //  تشغيل كود البايثون لكل صورة
    $python_path = "D:\\python\\python.exe";  
    $script_path = "D:\\xampp\\htdocs\\detech\\scan_damage.py";  

    foreach ($uploaded_images as $label => $image_path) {
        $processed_image_path = str_replace(".", "_modified.", $image_path);
        $command = escapeshellcmd("$python_path \"$script_path\" \"$image_path\"");
        $output = shell_exec($command . " 2>&1");
    
        // تحليل النتائج
        $scratches = substr_count($output, 'Scratch');
        $dents = substr_count($output, 'Dent');
        $broken_parts = substr_count($output, 'Broken part');  //  إضافة عداد لـ Broken Part
    
        if ($scratches > 0 || $dents > 0 || $broken_parts > 0) {
            $damage_found = true;
            $damage_details = [];
            if ($scratches > 0) $damage_details[] = "$scratches Scratch(es)";
            if ($dents > 0) $damage_details[] = "$dents Dent(s)";
            if ($broken_parts > 0) $damage_details[] = "$broken_parts Broken Part(s)";  //  إضافة تفصيل الأجزاء المكسورة
            $damage_report[] = "{$label}: " . implode(", ", $damage_details);
        }
    
        // إضافة الصورة المعدلة إلى الصور المعدلة
        if (file_exists($processed_image_path)) {
            $processed_images[$label] = $processed_image_path;
        } else {
            $processed_images[$label] = $image_path;
        }
    }
    

    //  تحديث الملاحظات وعرض المربعات بعد التحليل
    $show_note_and_submit = true;
    if ($damage_found) {
        $note = "Damage Summary:\n" . implode("\n", $damage_report);
        $message .= "<div class='alert alert-danger'>🚨 Damage Detected in some images.</div>";
    } else {
        $note = "No damage detected.";
        $message .= "<div class='alert alert-success'> No damage detected in any image.</div>";
    }
}
if (isset($_POST['submit_delivery'])) {
    $mileage = isset($_POST['mileage']) ? intval($_POST['mileage']) : $mileage;

    //  تحديث جدول report بخانة return_mileage
    $update_report_sql = "UPDATE report SET return_mileage = ?, damage_after = ? WHERE reservation_id = ?";
    $stmt_update_report = $conn->prepare($update_report_sql);
    if (!$stmt_update_report) {
        die("Error preparing update report statement: " . $conn->error);
    }

    // قراءة محتوى damage_after من الحقول
    $damage_after = $_POST['note'] ?? ""; // النص المحدث من المستخدم

    $stmt_update_report->bind_param('isi', $mileage, $damage_after, $reservation_id);

    if ($stmt_update_report->execute()) {
        $message .= "<div class='alert alert-success'> Return mileage and damage report updated successfully in report table!</div>";
    } else {
        $message .= "<div class='alert alert-danger'> Error updating return mileage and damage report: " . $stmt_update_report->error . "</div>";
    }

    //  تحديث جدول cars بخانة mileage
    $update_mileage_sql = "UPDATE cars SET mileage = ? WHERE car_id = ?";
    $stmt_update_mileage = $conn->prepare($update_mileage_sql);
    if (!$stmt_update_mileage) {
        die("Error preparing update mileage statement: " . $conn->error);
    }

    $stmt_update_mileage->bind_param('ii', $mileage, $car_id);

    if ($stmt_update_mileage->execute()) {
        $message .= "<div class='alert alert-success'> Mileage updated successfully in cars table!</div>";
    } else {
        $message .= "<div class='alert alert-danger'> Error updating mileage in cars table: " . $stmt_update_mileage->error . "</div>";
    }
    //  تحديث حالة السيارة إلى "Delivered" في جدول cars
$update_status_sql = "UPDATE reservations SET status = 'returned' WHERE car_id = ?";
$stmt_update_status = $conn->prepare($update_status_sql);
if (!$stmt_update_status) {
    die("Error preparing update status statement: " . $conn->error);
}
$stmt_update_status->bind_param('i', $car_id);
if ($stmt_update_status->execute()) {
    $message .= "<div class='alert alert-success'> Car status updated to 'Delivered' successfully!</div>";
} else {
    $message .= "<div class='alert alert-danger'> Error updating car status: " . $stmt_update_status->error . "</div>";
}
echo "<script>window.location.href='admin_dashboard.php';</script>";
exit;

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
    <style>
        .img-thumbnail {
            border: 2px solid #007BFF;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
        }

        .gallery-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .gallery-container img {
            width: 200px;
            height: auto;
        }
    </style>
</head>
<body class="container mt-5">

    <h2 class="text-center mb-4">Car Delivery - Update Car Information</h2>

    <!--  نموذج رفع الصور -->
    <form action="returen_car.php?reservation_id=<?php echo $reservation_id; ?>" method="POST" enctype="multipart/form-data" class="row g-3">
        <input type="hidden" name="car_id" value="<?php echo htmlspecialchars($car_id); ?>">

        <h4 class="text-center mt-4">Upload Car Images (Front, Right, Back, Left)</h4>
        <div class="col-md-3">
    <label for="image1" class="form-label">Front View:</label>
    <input type="file" name="image1" class="form-control" accept="image/*" capture="environment" required>
</div>
<div class="col-md-3">
    <label for="image2" class="form-label">Right Side View:</label>
    <input type="file" name="image2" class="form-control" accept="image/*" capture="environment" required>
</div>
<div class="col-md-3">
    <label for="image3" class="form-label">Back View:</label>
    <input type="file" name="image3" class="form-control" accept="image/*" capture="environment" required>
</div>
<div class="col-md-3">
    <label for="image4" class="form-label">Left Side View:</label>
    <input type="file" name="image4" class="form-control" accept="image/*" capture="environment" required>
</div>


        <div class="text-center col-12 mt-4">
            <button type="submit" name="upload_images" class="btn btn-primary">Upload and Analyze Images</button>
        </div>
    </form>
    <div class="modal-body">
    <div class="gallery-container">
    <?php foreach ($uploaded_images as $label => $image_path): ?>
        <div>
            <h6><?php echo $label; ?></h6>
            <?php
            // تحويل المسار الكامل إلى مسار يمكن للمتصفح الوصول إليه
            $original_image_path = str_replace(
                "D:\\xampp\\htdocs\\detech\\uploads\\",
                "uploads/",
                $image_path
            );

            $modified_image_path = str_replace(
                basename($image_path),
                "modified_" . basename($image_path),
                $original_image_path
            );

            // تحقق إذا كانت الصورة المعدلة موجودة
            $final_image_path = file_exists($modified_image_path) ? $modified_image_path : $original_image_path;
            ?>
            <a href="<?php echo $final_image_path; ?>" class="image-popup">
                <img src="<?php echo $final_image_path; ?>" class="img-thumbnail" alt="<?php echo $label; ?>">
            </a>
        </div>
    <?php endforeach; ?>
</div>

</div>





</div>

<!--  تضمين مكتبات Magnific Popup -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>

<script>
    $(document).ready(function () {
        // إعداد Magnific Popup لتكبير الصور
        $('.image-popup').magnificPopup({
            type: 'image',
            gallery: {
                enabled: true // تمكين التنقل بين الصور
            },
            mainClass: 'mfp-fade', // تأثير الفتح والإغلاق
            removalDelay: 300, // تأخير عند الإغلاق
            closeOnContentClick: true // إغلاق عند الضغط على الصورة
        });
    });
</script>

    <!--  عرض الملاحظات وزر التسليم بعد التحليل فقط -->
    <?php if ($show_note_and_submit): ?>
        <form action="returen_car.php?reservation_id=<?php echo $reservation_id; ?>" method="POST" class="row g-3 mt-4">
        <div class="col-md-6">
    <label for="mileage" class="form-label">Mileage (KM):</label>
    <input type="number" id="mileage" name="mileage" class="form-control" value="<?php echo htmlspecialchars($mileage); ?>" disabled required>
    <div class="form-check mt-2">
        <input class="form-check-input" type="checkbox" id="enableMileageEdit" onclick="toggleMileage()">
        <label class="form-check-label" for="enableMileageEdit">Enable Editing</label>
    </div>
</div>

<script>
    function toggleMileage() {
        const mileageField = document.getElementById('mileage');
        const enableCheckbox = document.getElementById('enableMileageEdit');
        mileageField.disabled = !enableCheckbox.checked; // تفعيل أو تعطيل الحقل بناءً على حالة المربع
    }
</script>




            <div class="col-md-6">
                <label for="note" class="form-label">Damage Report:</label>
                <textarea name="note" class="form-control" rows="4"><?php echo htmlspecialchars($note); ?></textarea>
            </div>
            
            <div class="text-center col-12 mt-4">
                <button type="submit" name="submit_delivery" class="btn btn-success">Submit Car Delivery</button>
            </div>
        </form>
    <?php endif; ?>

    
    
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