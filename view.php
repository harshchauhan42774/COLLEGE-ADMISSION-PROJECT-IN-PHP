<?php
error_reporting(0);
include 'conn.php';

// SQL query to fetch data from the 'admission1' table
$sql = "SELECT * FROM admission1";
$result = $conn->query($sql);

?>
<!-- Example of displaying students and a confirmation button -->

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

        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            border: 1px solid #ddd;
        }

        th {
            background-color: #f4f4f4;
        }



        .footer {
            margin-top: 50px;
            padding: 20px 0;
            background-color: #343a40;
            color: #ffffff;
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

        .form-check-input {
            cursor: pointer;
        }

        .form-check-label {
            cursor: pointer;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            font-size: 14px;
            font-weight: bold;
            text-align: center;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            border-radius: 5px;
            border: none;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .btn:hover {
            background-color: #007bff;
            color: #fff;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-danger {
            background-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            color: #fff;
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-icon {
            display: inline-flex;
            align-items: center;
        }

        .btn-icon i {
            margin-right: 5px;
        }
    </style>
</head>

<body>

    <!-- Header -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <a href="admin_dashboard.php" class="logo d-flex align-items-center">
                <img src="img/logo.jpg" alt="Logo" style="height: 40px;">
                <span class="d-none d-lg-block ms-2">C U SHAH POLYTECHNIC</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div><!-- End Logo -->

        <!-- End Icons Navigation -->

    </header><!-- End Header -->

    <!-- Sidebar -->
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
    </aside><!-- End Sidebar -->

    <main id="main" class="main">
        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <h2>Admission List</h2>
                    <div class="table-container">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Name</th>
                                        <th>Board</th>
                                        <th>Passing Year</th>
                                        <th>Seat Number</th>
                                        <th>Obtained Marks</th>
                                        <th>Percentage</th>
                                        <th>Branch</th>
                                        <th>Result</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            echo "<tr>";
                                            echo "<td>" . $i++ . "</td>";
                                            echo "<td>" . $row["marksheet_name"] . "</td>";
                                            echo "<td>" . $row["board"] . "</td>";
                                            echo "<td>" . $row["passing_year"] . "</td>";
                                            echo "<td>" . $row["seat_number"] . "</td>"; // Display seat number
                                            echo "<td>" . $row["obc_marks"] . "</td>";
                                            echo "<td>" . $row["percentage"] . "</td>";
                                            echo "<td>" . $row["branch"] . "</td>";
                                            echo "<td><a href='#' data-bs-toggle='modal' data-bs-target='#resultModal' data-bs-photo='" . $row["result_upload"] . "'>View</a></td>";

                                            // Check if the student is not rejected
                                            if ($row["status"] != 'Rejected') {
                                                echo "<td><button onclick='handleReject(this, " . $row["student_id"] . ")' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i> Reject</button></td>";
                                            } else {
                                                echo "<td>Rejected</td>";
                                            }

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='10'>No records found</td>"; // Adjust column count if necessary
                                    }
                                    ?>
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Result Modal -->
        <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="resultModalLabel">Result Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <img id="resultPhoto" src="" alt="Result Photo" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>

        <footer class="footer">
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
                            Surendranagar,
                            Gujarat 363030</p>
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
    </main><!-- End #main -->

    <div class="container-fluid copyright text-light py-4">
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

    <!-- Custom JS to handle the result modal -->
    <script>
        var resultModal = document.getElementById('resultModal');
        resultModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var photo = button.getAttribute('data-bs-photo');
            var resultPhoto = resultModal.querySelector('#resultPhoto');
            resultPhoto.src = 'uploads/' + photo;
        });
    </script>

</body>
<script>
    document.getElementById('admissionSwitch').addEventListener('change', function () {
        var form = document.getElementById('toggleAdmissionForm');
        form.submit();
    });
</script>
<script>
    function handleReject(button, studentId) {
        // Hide the reject button
        button.style.display = 'none';

        // Send an AJAX request to reject.php to update the student's status
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "reject.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200 && xhr.responseText === "Success") {
                    // Find the row to update
                    var row = button.closest("tr");
                    row.cells[8].innerHTML = "Rejected"; // Assuming the status is in the 9th column
                } else {
                    alert("Failed to reject the admission. Please try again.");
                }
            }
        };
        xhr.send("id=" + studentId);
    }

</script>

</html>

<?php
// Close the database connection
$conn->close();
?>