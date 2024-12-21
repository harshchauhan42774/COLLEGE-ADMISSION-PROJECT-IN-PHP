<?php
session_start();
include 'conn.php';

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - C U SHAH POLYTECHNIC</title>
    <link href="img/logo.jpg" rel="icon">
    <link
        href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700"
        rel="stylesheet">
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
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
      <a class="nav-link nav-profile d-flex align-items-center pe-0" href="admin.php" aria-label="Log Out">
        <i class="bi bi-box-arrow-right me-2" aria-hidden="true"></i>
        <span>Log Out</span>
      </a>
    </li>
  </ul>
</nav>
<!-- End Icons Navigation -->

</header><!-- End Header -->

    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link collapsed" href="admin_dashboard.php">
                    <i class="bi bi-grid"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="view.php">
                    <i class="bi bi-file-earmark"></i>
                    <span>View Admission</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="merit.php">
                    <i class="bi bi-award"></i>
                    <span>Merit</span>
                </a>
            </li>
        </ul>
    </aside>

    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Dashboard</h1>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Welcome to C U SHAH POLYTECHNIC</h5>
                        </div>
                    </div>
                </div>
            </div>
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

        <div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; C.U.SHAH POLYTECHNIC, All Right Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        Designed By : Chauhan Harsh D
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
    <script src="assets/vendor/chart.js/chart.umd.js"></script>
    <script src="assets/vendor/echarts/echarts.min.js"></script>
    <script src="assets/vendor/quill/quill.js"></script>
    <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
    <script src="assets/vendor/tinymce/tinymce.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>
    <script src="assets/js/main.js"></script>

</body>

</html>