<?php

include 'conn.php'; // Include the database connection file
include 'check_login.php';

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

$email = $_SESSION['email'];

// Fetch student data from the database
$sql = "SELECT * FROM student WHERE email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $student_id = $student['id']; // Assuming 'id' is the primary key in the student table
} else {
    die("Student record not found.");
}

// Fetch admission data
$sql_admission = "SELECT * FROM admissions WHERE student_id = ?";
$stmt_admission = $conn->prepare($sql_admission);
$stmt_admission->bind_param("i", $student_id);
$stmt_admission->execute();
$result_admission = $stmt_admission->get_result();

// Fetch admission1 data
$sql_admission1 = "SELECT * FROM admission1 WHERE student_id = ?";
$stmt_admission1 = $conn->prepare($sql_admission1);
$stmt_admission1->bind_param("i", $student_id);
$stmt_admission1->execute();
$result_admission1 = $stmt_admission1->get_result();
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

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        .main {
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .container {
            width: 80%;
            margin: 0 auto;
        }

        h2,
        h3 {
            color: #2c3e50;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #2c3e50;
            color: #fff;
        }

        td {
            background-color: #f4f4f4;
        }

        table img {
            display: block;
            max-width: 100%;
            height: auto;
            border-radius: 5px;
        }

        form {
            text-align: center;
            margin-top: 20px;
        }

        button[type="submit"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #2980b9;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        .footer a {
            text-decoration: none;
            color: #3498db;
            font-weight: bold;
            transition: color 0.3s ease;
        }

        .footer a:hover {
            color: #2980b9;
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
        <div class="container">
            <h2>Admission Details</h2>

            <?php if ($result_admission->num_rows > 0): ?>
                <h3>Admission Form Data</h3>
                <?php $admission = $result_admission->fetch_assoc(); ?>
                <table>
                    <tr>
                        <th>First Name</th>
                        <td><?php echo htmlspecialchars($admission['fname']); ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo htmlspecialchars($admission['lname']); ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo htmlspecialchars($admission['email']); ?></td>
                    </tr>
                    <tr>
                        <th>Mobile</th>
                        <td><?php echo htmlspecialchars($admission['mobile']); ?></td>
                    </tr>
                    <tr>
                        <th>Date of Birth</th>
                        <td><?php echo htmlspecialchars($admission['dob']); ?></td>
                    </tr>
                    <tr>
                        <th>Father's Name</th>
                        <td><?php echo htmlspecialchars($admission['fathername']); ?></td>
                    </tr>
                    <tr>
                        <th>Mother's Name</th>
                        <td><?php echo htmlspecialchars($admission['mothername']); ?></td>
                    </tr>
                    <tr>
                        <th>Parents' Phone</th>
                        <td><?php echo htmlspecialchars($admission['parents_phone']); ?></td>
                    </tr>
                    <tr>
                        <th>Category</th>
                        <td><?php echo htmlspecialchars($admission['category']); ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo htmlspecialchars($admission['gender']); ?></td>
                    </tr>
                    <tr>
                        <th>Permanent Address</th>
                        <td><?php echo htmlspecialchars($admission['perment_address']); ?></td>
                    </tr>
                    <tr>
                        <th>Present Address</th>
                        <td><?php echo htmlspecialchars($admission['present_address']); ?></td>
                    </tr>
                    <tr>
                        <th>Pincode</th>
                        <td><?php echo htmlspecialchars($admission['pincode']); ?></td>
                    </tr>
                    <!-- <tr>
                        <th>Photo</th>
                        <td><img src="<?php echo htmlspecialchars($admission['photo']); ?>" alt="Photo"
                                style="max-width: 200px;"></td>
                    </tr> -->
                </table>
            <?php else: ?>
                <p>No admission data found.</p>
            <?php endif; ?>

            <?php if ($result_admission1->num_rows > 0): ?>
                <?php $admission1 = $result_admission1->fetch_assoc(); ?>
                <table>
                    <tr>
                        <th>Branch</th>
                        <td><?php echo htmlspecialchars($admission1['branch']); ?></td>
                    </tr>
                    <tr>
                        <th>Board</th>
                        <td><?php echo htmlspecialchars($admission1['board']); ?></td>
                    </tr>
                    <tr>
                        <th>Passing Year</th>
                        <td><?php echo htmlspecialchars($admission1['passing_year']); ?></td>
                    </tr>
                    <tr>
                        <th>Passing Month</th>
                        <td>
                            <?php
                            echo htmlspecialchars($admission1['passing_month']) ? htmlspecialchars($admission1['passing_month']) : 'N/A';
                            ?>
                        </td>

                    </tr>
                    <tr>
                        <th>Seat Number</th>
                        <td><?php echo htmlspecialchars($admission1['seat_number']); ?></td>
                    </tr>
                    <tr>
                        <th>Marksheet Name</th>
                        <td><?php echo htmlspecialchars($admission1['marksheet_name']); ?></td>
                    </tr>
                    <tr>
                        <th>Attempts</th>
                        <td><?php echo htmlspecialchars($admission1['attempts']); ?></td>
                    </tr>
                    <tr>
                        <th>Total Marks</th>
                        <td><?php echo htmlspecialchars($admission1['total_marks']); ?></td>
                    </tr>
                    <tr>
                        <th>Obc Marks</th>
                        <td><?php echo htmlspecialchars($admission1['obc_marks']); ?></td>
                    </tr>
                    <tr>
                        <th>Percentage</th>
                        <td><?php echo htmlspecialchars($admission1['percentage']); ?></td>
                    </tr>
                    <tr>
                        <th>Language Medium</th>
                        <td><?php echo htmlspecialchars($admission1['language_medium']); ?></td>
                    </tr>
                    <tr>
                        <th>Result</th>
                        <td><img src="uploads/<?php echo htmlspecialchars($admission1['result_upload']); ?>" alt="Photo"
                                style="max-width: 200px;"></td>
                    </tr>

                </table>
            <?php else: ?>
                <p>No admission1 data found.</p>
            <?php endif; ?>




            <form method="post" action="download_pdf.php" style="display:inline;">
                <input type="hidden" name="student_id" value="<?php echo $student_id; ?>">
                <button type="submit">Download PDF</button>
            </form>

        </div>
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


    <!-- Back to Top Button -->
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

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

</body>

</html>

<?php
// Close the statements and connection
$stmt->close();
$stmt_admission->close();
$stmt_admission1->close();
$conn->close();
?>