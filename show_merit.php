<?php
include 'conn.php'; // Include your database connection file
include 'check_login.php'; 

// Initialize branch variable
$branch = 'Computer Engineering'; // Default value

// Check if form is submitted and branch is set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['branch'])) {
    $branch = $_POST['branch'];
}

// Prepare the SQL statement
$stmt = $conn->prepare("SELECT * FROM merit WHERE branch = ? ORDER BY rank");
$stmt->bind_param("s", $branch);

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard - C U SHAH POLYTECHNIC</title>

  <!-- Favicons -->
  <link href="img/logo.jpg" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700" rel="stylesheet">

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
    }

    .header-nav .nav-item {
      margin-left: 20px;
    }

    .header-nav .nav-link {
      display: flex;
      align-items: center;
      color: #333;
      text-decoration: none;
      font-size: 16px;
    }

    .header-nav .nav-link:hover {
      color: #007bff;
    }

    .header-nav .nav-link i {
      font-size: 20px;
      margin-right: 8px;
    }

    @media (max-width: 768px) {
      .header-nav {
        display: none;
      }

      .toggle-sidebar-btn {
        display: block;
        font-size: 24px;
        cursor: pointer;
      }
    }
    /* Form Container */
form {
  margin: 20px;
  padding: 20px;
  border: 1px solid #ddd;
  border-radius: 8px;
  background-color: #f9f9f9;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

/* Label Styling */
form label {
  display: block;
  font-weight: bold;
  margin-bottom: 10px;
}

/* Select Box Styling */
form select {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  font-size: 16px;
  margin-bottom: 20px;
  box-sizing: border-box; /* To include padding and border in the width */
}

/* Button Styling */
form button {
  background-color: #007bff;
  color: #fff;
  border: none;
  padding: 10px 20px;
  border-radius: 4px;
  font-size: 16px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

/* Button Hover Effect */
form button:hover {
  background-color: #0056b3;
}

/* Responsive Design */
@media (max-width: 768px) {
  form {
    padding: 15px;
  }

  form select, form button {
    width: 100%;
    font-size: 14px;
  }

  form button {
    padding: 8px 16px;
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
    </div>
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
  </header>

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
  </aside>

  <main id="main" class="main">
    <form method="POST" action="">
      <label for="branch">Select Branch:</label>
      <select name="branch" id="branch">
        <option value="Computer Engineering" <?php if ($branch == 'Computer Engineering') echo 'selected'; ?>>Computer Engineering</option>
        <option value="Mechanical Engineering" <?php if ($branch == 'Mechanical Engineering') echo 'selected'; ?>>Mechanical Engineering</option>
        <option value="Electrical Engineering" <?php if ($branch == 'Electrical Engineering') echo 'selected'; ?>>Electrical Engineering</option>
      </select>
      <button type="submit">Show Merit List</button>
    </form>

    <section class="section dashboard">
      <div class="row">
        <div class="col-12">
          <h2>Merit List</h2>
          <div class="table-container">
            <div class="table-responsive">
              <table class="table table-striped table-bordered">
                <thead>
                  <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Percentage</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($row["rank"]) . "</td>";
                      echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                      echo "<td>" . htmlspecialchars($row["branch"]) . "</td>";
                      echo "<td>" . htmlspecialchars($row["percentage"]) . "</td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='4'>No merit data available.</td></tr>";
                  }
                  ?>
                </tbody>
              </table>
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
            <p><i class="bi bi-geo-alt-fill me-2"></i>Nr. Bada Talav, GIDC Area, Wadhwan City, Surendranagar, Gujarat 363030</p>
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
  </main>

  <!-- Back to Top Button -->
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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

<?php
// Close the statement and connection
$stmt->close();
$conn->close();
?>
