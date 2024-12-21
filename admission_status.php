<?php
include 'conn.php';
include 'check_login.php';

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit;
}

$email = $_SESSION['email'];

// Fetch student data
$sql = "SELECT * FROM student WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    error_log("Statement preparation failed: " . $conn->error);
    die("An error occurred. Please try again later.");
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $student_id = $student['id'];
} else {
    die("Student record not found.");
}

// Fetch admission status
$sql_admission1 = "SELECT status FROM admission1 WHERE student_id = ?";
$stmt_admission1 = $conn->prepare($sql_admission1);
if (!$stmt_admission1) {
    error_log("Statement preparation failed: " . $conn->error);
    die("An error occurred. Please try again later.");
}
$stmt_admission1->bind_param("i", $student_id);
$stmt_admission1->execute();
$result_admission1 = $stmt_admission1->get_result();

if ($result_admission1->num_rows > 0) {
    $admission1 = $result_admission1->fetch_assoc();
    $status = $admission1['status'];
    $admission_status = (trim($status) === 'Rejected') ? 'You have been rejected' : 'Admission Form Submitted';
} else {
    $admission_status = 'Not Submitted';
}

$stmt->close();
$stmt_admission1->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - C U SHAH POLYTECHNIC</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="img/logo.jpg" rel="icon">

    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700"
        rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <style>
        .status-not-submitted {
            color: orange;
            font-weight: bold;
        }

        .status-rejected {
            color: red;
            font-weight: bold;
        }

        .status-submitted {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <!-- Header -->

    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="home.php" class="logo d-flex align-items-center">
                <img src="img/logo.jpg" alt="Logo" style="height: 40px;">
                <span class="d-none d-lg-block ms-2">C U SHAH POLYTECHNIC</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->
        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">
                <li class="nav-item">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="profile.php"
                        aria-label="My Profile">
                        <i class="bi bi-person-circle me-2" aria-hidden="true"></i>
                        <span>My Profile</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-profile d-flex align-items-center pe-0" href="logout.php"
                        aria-label="Log Out">
                        <i class="bi bi-box-arrow-right me-2" aria-hidden="true"></i>
                        <span>Log Out</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav">
            <li class="nav-item"><a class="nav-link collapsed" href="home.php"><i
                        class="bi bi-grid"></i><span>Dashboard</span></a></li>
            <li class="nav-item"><a class="nav-link collapsed" href="admission.php"><i
                        class="bi bi-file-earmark"></i><span>Admission Form</span></a></li>
            <li class="nav-item"><a class="nav-link collapsed" href="admission_status.php"><i
                        class="bi bi-info-circle"></i><span>Admission Status</span></a></li>
            <li class="nav-item"><a class="nav-link collapsed" href="show_merit.php"><i
                        class="bi bi-award"></i><span>Merit</span></a></li>
        </ul>
    </aside>

    <main id="main" class="main">
        <section>
            <h2>Your Admission Status</h2>
            <p class="
                <?php
                echo ($admission_status == 'You have been rejected') ? 'status-rejected' :
                    ($admission_status == 'Not Submitted' ? 'status-not-submitted' : 'status-submitted');
                ?>">
                <?php echo htmlspecialchars($admission_status); ?>
            </p>
        </section>

        <footer class="footer bg-dark text-light py-3">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h2 class="text-white">
                            <img src="img/logo.jpg" alt="Logo" class="img-fluid mb-3" style="max-width: 150px;">
                            <br>C U SHAH POLYTECHNIC
                        </h2>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <p><i class="bi bi-geo-alt-fill me-2"></i>Nr. Bada Talav, GIDC Area, Wadhwan City,
                            Surendranagar, Gujarat 363030</p>
                        <p><i class="bi bi-telephone-fill me-2"></i>+91 2752243494</p>
                        <p><i class="bi bi-envelope-fill me-2"></i>cusp-snagar-dte@gujarat.gov.in</p>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-4">
                        <h4 class="text-white mb-4">Quick Links</h4>
                        <a href="#" class="text-white mb-2 d-block">About Us</a>
                        <a href="#" class="text-white mb-2 d-block">Contact Us</a>
                        <a href="#" class="text-white mb-2 d-block">Courses</a>
                        <a href="#" class="text-white mb-2 d-block">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </footer>
    </main>

    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="assets/vendor/chart.js/chart.umd.js"></script>
<script src="assets/vendor/echarts/echarts.min.js"></script>
<script src="assets/vendor/quill/quill.js"></script>
<script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="assets/vendor/tinymce/tinymce.min.js"></script>
<script src="assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>

</html>