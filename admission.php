<?php
// session_start();
include 'conn.php'; // Include the database connection file
include 'check_login.php'; // Check if the user is logged in

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit;
}

$email = $_SESSION['email'];

// Fetch student data from the database
$sql = "SELECT * FROM student WHERE email = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Statement preparation failed: " . $conn->error);
}
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
    $student_id = $student['id']; // Assuming 'id' is the primary key in the student table
} else {
    die("Student record not found.");
}

// Check if the user has already submitted the form for `admissions`
$sql_check_admissions = "SELECT * FROM admissions WHERE student_id = ?";
$stmt_check_admissions = $conn->prepare($sql_check_admissions);
$stmt_check_admissions->bind_param("i", $student_id);
$stmt_check_admissions->execute();
$result_check_admissions = $stmt_check_admissions->get_result();

// Check if the user has already submitted the form for `admission1`
$sql_check_admission1 = "SELECT * FROM admission1 WHERE student_id = ?";
$stmt_check_admission1 = $conn->prepare($sql_check_admission1);
$stmt_check_admission1->bind_param("i", $student_id);
$stmt_check_admission1->execute();
$result_check_admission1 = $stmt_check_admission1->get_result();

if ($result_check_admissions->num_rows > 0) {
    // User has already submitted the `admissions` form
    if ($result_check_admission1->num_rows > 0) {
        // User has also submitted the `admission1` form
        echo "<script>
        window.location.href = 'view_admission.php';
      </script>";
    } else {
        // Redirect to `admission1.php` if only `admissions` form is submitted
        header("Location: admission1.php");
        exit();
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data and sanitize it
    $fname = $_POST['fname'] ?? '';
    $lname = $_POST['lname'] ?? '';
    $email = $_POST['email'] ?? '';
    $mobile = $_POST['mobile'] ?? '';
    $dob = $_POST['dob'] ?? '';
    $fathername = $_POST['fathername'] ?? '';
    $mothername = $_POST['mothername'] ?? '';
    $parents_phone = $_POST['parents_phone'] ?? '';
    $category = $_POST['category'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $perment_address = $_POST['perment_address'] ?? '';
    $present_address = $_POST['present_address'] ?? '';
    $pincode = $_POST['pincode'] ?? '';

    // Handle file upload
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $photoTmpName = $_FILES['photo']['tmp_name'];
        $photoName = basename($_FILES['photo']['name']);
        $photoDir = 'uploads/'; // Directory where photos will be stored
        $photoPath = $photoDir . $photoName;

        // Ensure the uploads directory exists
        if (!is_dir($photoDir)) {
            mkdir($photoDir, 0755, true);
        }

        // Move the uploaded file to the desired location
        if (move_uploaded_file($photoTmpName, $photoPath)) {
            $photo = $photoPath;
        } else {
            echo "Failed to upload photo.";
            exit();
        }
    }

    // Create a prepared statement to insert data into `admissions`
    $stmt = $conn->prepare("INSERT INTO admissions (student_id, fname, lname, email, mobile, dob, fathername, mothername, parents_phone, category, gender, perment_address, present_address, pincode, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("issssssssssssss", $student_id, $fname, $lname, $email, $mobile, $dob, $fathername, $mothername, $parents_phone, $category, $gender, $perment_address, $present_address, $pincode, $photo);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect to `admission1.php` after successful submission of the first form
        header("Location: admission1.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();
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

    <!-- jQuery and jQuery Validation plugin -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>


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
            <form id="admissionForm" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" id="fname" name="fname" class="form-control"
                            value="<?= htmlspecialchars($student['fname']) ?>" readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" id="lname" name="lname" class="form-control"
                            value="<?= htmlspecialchars($student['surname']) ?>" readonly>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="<?= htmlspecialchars($student['email']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="mobile" class="form-label">Mobile</label>
                    <input type="text" id="mobile" name="mobile" class="form-control"
                        value="<?= htmlspecialchars($student['phone']) ?>" readonly>
                </div>
                <div class="mb-3">
                    <label for="dob" class="form-label">Date of Birth</label>
                    <input type="date" id="dob" name="dob" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="fathername" class="form-label">Father's Name</label>
                    <input type="text" id="fathername" name="fathername" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="mothername" class="form-label">Mother's Name</label>
                    <input type="text" id="mothername" name="mothername" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="parents_phone" class="form-label">Parents' Phone</label>
                    <input type="text" id="parents_phone" name="parents_phone" class="form-control">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Category</label>
                    <select id="category" name="category" class="form-control">
                        <option value="" disabled selected>Select your category</option>
                        <option value="General">General</option>
                        <option value="OBC">OBC</option>
                        <option value="SC">SC</option>
                        <option value="ST">ST</option>
                        <option value="Others">Others</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="gender" class="form-label">Gender</label>
                    <select id="gender" name="gender" class="form-control">
                        <option value="" disabled selected>Select your Gender</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="perment_address" class="form-label">Permanent Address</label>
                    <textarea id="perment_address" name="perment_address" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="present_address" class="form-label">Present Address</label>
                    <textarea id="present_address" name="present_address" class="form-control" rows="3"></textarea>
                </div>
                <div class="mb-3">
                    <label for="pincode" class="form-label">Pincode</label>
                    <input type="text" id="pincode" name="pincode" class="form-control">
                </div>
                <!-- <div class="mb-3">
                    <label for="photo" class="form-label">Profile Photo</label>
                    <input type="file" id="photo" name="photo" class="form-control" accept="image/*">
                </div> -->

                <button type="submit" class="btn btn-primary">Submit</button>
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

        <div class="container-fluid copyright text-light py-4 wow fadeIn" data-wow-delay="0.1s">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        &copy; C.U.SHAH POLYTECHNIC, All Rights Reserved.
                    </div>
                    <div class="col-md-6 text-center text-md-end">
                        Designed By : Chauhan Harsh D
                    </div>
                </div>
            </div>
        </div>
    </main>

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
        // Add custom validation method for date of birth
        $.validator.addMethod("yearRange", function (value, element, params) {
            var selectedDate = new Date(value);
            var selectedYear = selectedDate.getFullYear();
            return this.optional(element) || (selectedYear <= params.max && selectedYear >= params.min);
        }, "Please enter a valid date of birth.");

        $("#admissionForm").validate({
            rules: {
                dob: {
                    required: true,
                    yearRange: { min: 2000, max: 2009 }
                },

                fathername: "required",
                mothername: "required",
                parents_phone: {
                    required: true,
                    digits: true,
                    minlength: 10,
                    maxlength: 10
                },
                category: "required",
                gender: "required",
                perment_address: "required",
                present_address: "required",
                pincode: {
                    required: true,
                    digits: true,
                    minlength: 6,
                    maxlength: 6
                },
                photo: {
                    extension: "jpg|jpeg|png"
                }
            },
            messages: {
                dob: {
                    required: "Please enter your date of birth",
                    yearRange: "Date of birth must be between 2000 and 2009"
                },

                fathername: "Please enter your father's name",
                mothername: "Please enter your mother's name",
                parents_phone: {
                    required: "Please enter your parents' phone number",
                    digits: "Please enter only digits",
                    minlength: "Phone number should be 10 digits",
                    maxlength: "Phone number should be 10 digits"
                },
                category: "Please select your category",
                gender: "Please select your gender",
                perment_address: "Please enter your permanent address",
                present_address: "Please enter your present address",
                pincode: {
                    required: "Please enter your pincode",
                    digits: "Please enter only digits",
                    minlength: "Pincode should be 6 digits",
                    maxlength: "Pincode should be 6 digits"
                },
                photo: "Please upload a valid photo (jpg, jpeg, png)"
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
    });
</script>

</html>