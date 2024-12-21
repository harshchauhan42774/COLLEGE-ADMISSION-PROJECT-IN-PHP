<?php
session_start();
include 'conn.php'; // Include the database connection file

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
    $student_id = $student['id'];
} else {
    die("Student record not found.");
}

// Check if admission record already exists
$check_sql = "SELECT * FROM admission1 WHERE student_id = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("i", $student_id);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    header("Location: home.php"); // Redirect to a status page
    exit;
}

// Proceed with insertion
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Directly assign inputs to variables
    $board = $_POST['board'];
    $branch = $_POST['branch'];
    $passing_year = $_POST['passing_year'];
    $passing_month = $_POST['passing_month'];
    $seat_number = $_POST['seat_number'];
    $marksheet_name = $_POST['marksheet_name'];
    $attempts = $_POST['attempts'];
    $total_marks = $_POST['total_marks'];
    $obc_marks = $_POST['obc_marks'];
    $percentage = $_POST['percentage'];
    $language_medium = $_POST['language_medium'];

    // File upload without validation
    $result_upload = '';
    if (!empty($_FILES['result_upload']['name'])) {
        $target_dir = "uploads/";
        $result_upload = $_FILES["result_upload"]["name"];
        $target_file = $target_dir . $result_upload;
        move_uploaded_file($_FILES["result_upload"]["tmp_name"], $target_file);
    }

    // Insert admission record
    $insert_sql = "INSERT INTO admission1 (student_id, board, branch, passing_year, passing_month, seat_number, marksheet_name, attempts, result_upload, total_marks, obc_marks, percentage, language_medium) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $insert_stmt = $conn->prepare($insert_sql);
    $insert_stmt->bind_param("issssssssssds", $student_id, $board, $branch, $passing_year, $passing_month, $seat_number, $marksheet_name, $attempts, $result_upload, $total_marks, $obc_marks, $percentage, $language_medium);

    if ($insert_stmt->execute()) {
        header("Location: home.php");
        exit;
    } else {
        die("Insertion failed: " . $insert_stmt->error);
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admission Form - C U SHAH POLYTECHNIC</title>
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
    <style>
        .form-field-error {
            border-color: #dc3545;
            /* Red border for error fields */
            background-color: #f8d7da;
            /* Light red background for error fields */
        }

        .form-field-valid {
            border-color: #28a745;
            /* Green border for valid fields */
            background-color: #d4edda;
            /* Light green background for valid fields */
        }
    </style>
</head>

<body>

    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="home.php" class="logo d-flex align-items-center">
                <img src="img/logo.jpg" alt="Logo" style="height: 40px;">
                <span class="d-none d-lg-block ms-2">C U SHAH POLYTECHNIC</span>
            </a>
            <i class="bi bi-list toggle-sidebar-btn"></i>
        </div>

    </header>

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
        </ul>
    </aside>
    <main id="main" class="main">
        <div class="container mt-5">
            <h2>Admission Form</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="mb-3">
                        <label for="board" class="form-label">Board</label>
                        <select id="board" name="board" class="form-control" required>
                            <option value="" disabled selected>Select your board</option>
                            <option value="Gujarat Secondary and Higher Secondary Education Board">Gujarat Secondary and
                                Higher Secondary Education Board</option>
                            <option value="Central Board of Secondary Education">Central Board of Secondary Education
                            </option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="branch" class="form-label">Branch</label>
                        <select id="branch" name="branch" class="form-control" required>
                            <option value="" disabled selected>Select your branch</option>
                            <option value="Computer Engineering">Computer Engineering</option>
                            <option value="Electrical Engineering">Electrical Engineering</option>
                            <option value="Mechanical Engineering">Mechanical Engineering</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="passing_year" class="form-label">Passing Year</label>
                        <input type="number" id="passing_year" name="passing_year" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="passing_month" class="form-label">Passing Month</label>
                        <select id="passing_month" name="passing_month" class="form-control" required
                            aria-label="Select passing month" data-toggle="tooltip" title="Select the month you passed">
                            <option value="" disabled selected>Select your passing month</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="seat_number" class="form-label">Seat Number</label>
                        <input type="text" id="seat_number" name="seat_number" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="marksheet_name" class="form-label">Name as on Marksheet</label>
                        <input type="text" id="marksheet_name" name="marksheet_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="attempts" class="form-label">Attempts</label>
                        <input type="number" id="attempts" name="attempts" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="result_upload" class="form-label">Upload Result</label>
                        <input type="file" id="result_upload" name="result_upload" class="form-control"
                            accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="total_marks" class="form-label">Total Marks</label>
                        <input type="number" id="total_marks" name="total_marks" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="obc_marks" class="form-label">Obtained Marks</label>
                        <input type="number" id="obc_marks" name="obc_marks" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="percentage" class="form-label">Percentage</label>
                        <input type="number" id="percentage" name="percentage" class="form-control" step="0.01"
                            readonly>
                    </div>
                    <div class="mb-3">
                        <label for="language_medium" class="form-label">Language Medium</label>
                        <select id="language_medium" name="language_medium" class="form-control" required>
                            <option value="" disabled selected>Select your language medium</option>
                            <option value="Gujarati">Gujarati</option>
                            <option value="English">English</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
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
        </footer>


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
<script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<script>
    $(document).ready(function () {
        // Custom method to check file extension
        $.validator.addMethod("extension", function (value, element, param) {
            var allowedExtensions = param.split('|');
            var fileExtension = value.split('.').pop().toLowerCase();
            return this.optional(element) || $.inArray(fileExtension, allowedExtensions) !== -1;
        }, "Invalid file type.");

        // Custom method to validate seat number (1 character + 7 digits)
        $.validator.addMethod("seatNumberFormat", function (value, element) {
            return this.optional(element) || /^[A-Za-z]\d{7}$/.test(value);
        }, "Seat number must start with exactly one character followed by seven digits.");

        // Custom method to validate passing year range
        $.validator.addMethod("yearRange", function (value, element, param) {
            var year = parseInt(value, 10);
            return this.optional(element) || (year >= param[0] && year <= param[1]);
        }, "Please enter a year between {0} and {1}.");

        // Custom method to prevent multiple consecutive spaces
        $.validator.addMethod("noMultipleSpaces", function (value, element) {
            return this.optional(element) || !/\s{2,}/.test(value);
        }, "Multiple consecutive spaces are not allowed.");

        // Custom method to ensure only digits are entered in attempts
        $.validator.addMethod("validAttempts", function (value, element) {
            return this.optional(element) || /^\d+$/.test(value);
        }, "Please enter only digits.");

        // Custom method to ensure obc_marks <= total_marks
        $.validator.addMethod("lessThanTotalMarks", function (value, element) {
            var totalMarks = parseFloat($("#total_marks").val());
            var obcMarks = parseFloat(value);
            return this.optional(element) || obcMarks <= totalMarks;
        }, "Obtained marks cannot be greater than total marks.");

        // Initialize form validation
        $("form").validate({
            rules: {
                board: "required",
                passing_year: {
                    required: true,
                    number: true,
                    yearRange: [2000, 2024]
                },
                passing_month: "required",
                branch: "required",
                seat_number: {
                    required: true,
                    seatNumberFormat: true
                },
                marksheet_name: {
                    required: true,
                    noMultipleSpaces: true
                },
                attempts: {
                    required: true,
                    digits: true,
                    min: 1,
                    max: 3
                },
                result_upload: {
                    required: true,
                    extension: "jpg|jpeg|png"
                },
                total_marks: {
                    required: true,
                    number: true
                },
                obc_marks: {
                    required: true,
                    number: true,
                    lessThanTotalMarks: true // Add the custom method here
                },
                percentage: {
                    required: true,
                    number: true,
                    min: 0,
                    max: 100
                },
                language_medium: "required"
            },
            messages: {
                board: "Please select your board",
                passing_year: {
                    required: "Please enter your passing year",
                    number: "Please enter a valid year",
                    yearRange: "Please enter a year between 2020 and 2024"
                },
                branch: "Please select your branch",
                passing_month: "Please select your passing month",
                seat_number: {
                    required: "Please enter your seat number",
                    seatNumberFormat: "Seat number must start with exactly one character followed by six digits"
                },
                marksheet_name: {
                    required: "Please enter your name as on the marksheet",
                    noMultipleSpaces: "Multiple consecutive spaces are not allowed"
                },
                attempts: {
                    required: "Please enter the number of attempts",
                    digits: "Please enter only positive digits",
                    min: "Minimum allowed attempts is 1",
                    max: "Maximum allowed attempts is 3"
                },
                result_upload: {
                    required: "Please upload your result",
                    extension: "Only jpg, jpeg, and png files are allowed"
                },
                total_marks: {
                    required: "Please enter your total marks",
                    number: "Please enter a valid number"
                },
                obc_marks: {
                    required: "Please enter your OBC marks",
                    number: "Please enter a valid number",
                    lessThanTotalMarks: "Obtained marks cannot be greater than total marks"
                },
                percentage: {
                    required: "Please enter your percentage",
                    number: "Please enter a valid number",
                    min: "Percentage must be between 0 and 100",
                    max: "Percentage must be between 0 and 100"
                },
                language_medium: "Please select your language medium"
            },
            highlight: function (element) {
                $(element).addClass("form-field-error").removeClass("form-field-valid");
            },
            unhighlight: function (element) {
                $(element).addClass("form-field-valid").removeClass("form-field-error");
            },
            submitHandler: function (form) {
                form.submit();
            }
        });

        // Auto-calculate percentage
        $("#total_marks, #obc_marks").on("input", function () {
            var totalMarks = parseFloat($("#total_marks").val());
            var obcMarks = parseFloat($("#obc_marks").val());
            if (!isNaN(totalMarks) && !isNaN(obcMarks) && totalMarks > 0) {
                var percentage = (obcMarks / totalMarks) * 100;
                $("#percentage").val(percentage.toFixed(2));
            } else {
                $("#percentage").val("");
            }
        });
    });
</script>

</html>