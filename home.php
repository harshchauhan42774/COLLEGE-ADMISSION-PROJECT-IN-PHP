<?php
include 'conn.php';
include 'check_login.php';
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
    .header-nav {
      margin-left: auto;
      /* Align navigation to the right */
    }

    .header-nav .nav-item {
      margin-left: 20px;
      /* Space between items */
    }

    .header-nav .nav-link {
      display: flex;
      align-items: center;
      color: #333;
      /* Text color */
      text-decoration: none;
      font-size: 16px;
    }

    .header-nav .nav-link:hover {
      color: #007bff;
      /* Hover color */
    }

    .header-nav .nav-link i {
      font-size: 20px;
      /* Icon size */
      margin-right: 8px;
      /* Space between icon and text */
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
      .header-nav {
        display: none;
        /* Hide navigation on small screens */
      }

      .toggle-sidebar-btn {
        display: block;
        /* Show toggle button */
        font-size: 24px;
        cursor: pointer;
      }
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
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="profile.php" aria-label="My Profile">
            <i class="bi bi-person-circle me-2" aria-hidden="true"></i>
            <span>My Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="logout.php" aria-label="Log Out">
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
    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="home.php">
          <i class="bi bi-grid"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="admission.php">
          <i class="bi bi-file-earmark"></i>
          <span>Admission Form</span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="admission_status.php">
          <i class="bi bi-info-circle"></i>
          <span>Admission Status</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="show_merit.php">
          <i class="bi bi-award"></i>
          <span>Merit</span>
        </a>
      </li>

    </ul>
  </aside><!-- End Sidebar -->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Dashboard</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="home.php">Home</a></li>
          <li class="breadcrumb-item active">Dashboard</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
      <div class="row">
        <!-- Your content here -->
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
            <p><i class="bi bi-geo-alt-fill me-2"></i>Nr. Bada Talav, GIDC Area, Wadhwan City, Surendranagar, Gujarat
              363030</p>
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
    </footer><!-- End Footer -->
    <!-- Copyright Start -->
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
    <!-- Copyright End -->
  </main><!-- End #main -->

  <!-- Footer -->
  <!-- Footer -->




  <!-- Vendor JS Files -->
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

</body>

</html>