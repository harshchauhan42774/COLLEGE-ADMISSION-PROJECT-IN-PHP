<?php
session_start();
include 'conn.php';
include 'check_login.php';
// Check if user is logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Get the email from session
$email = $_SESSION['email'];

// Fetch data from the admission table based on the email
$sql = "SELECT * FROM admission WHERE email = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $admission = $result->fetch_assoc();
    } else {
        echo "No records found.";
        exit();
    }
    
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Admission Profile</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        .profile-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
        
        .profile-title {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        
        .profile-label {
            font-weight: bold;
            color: #555;
        }
        
        .profile-info {
            margin-bottom: 10px;
        }
        
        .profile-info p {
            margin: 0;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="index.html" class="navbar-brand">
            <h2 class="m-0" style="color: rgb(21, 158, 29);">
                <img src="img/logo.jpg" alt="Logo" class="img-fluid" style="max-width: 50px;"> C U SHAH POLYTECHNIC
            </h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="home.php" class="nav-item nav-link">Home</a>
                <a href="apply.php" class="nav-item nav-link">Apply for Admission</a>
                <a href="profile.php" class="nav-item nav-link active">Profile View</a>
                <a href="logout.php" class="nav-item nav-link">Logout</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Profile View Start -->
    <div class="container">
        <div class="profile-container">
            <h2 class="profile-title">Admission Profile</h2>
            <div class="profile-info">
                <label class="profile-label">First Name:</label>
                <p><?php echo htmlspecialchars($admission['firstname']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Last Name:</label>
                <p><?php echo htmlspecialchars($admission['lastname']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Father's Name:</label>
                <p><?php echo htmlspecialchars($admission['fathername']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Mother's Name:</label>
                <p><?php echo htmlspecialchars($admission['mothername']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Father's Phone Number:</label>
                <p><?php echo htmlspecialchars($admission['fatherphone']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Category:</label>
                <p><?php echo htmlspecialchars($admission['category']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Age:</label>
                <p><?php echo htmlspecialchars($admission['age']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Date of Birth:</label>
                <p><?php echo htmlspecialchars($admission['dob']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Gender:</label>
                <p><?php echo htmlspecialchars($admission['gender']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Email:</label>
                <p><?php echo htmlspecialchars($admission['email']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Address:</label>
                <p><?php echo htmlspecialchars($admission['address']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">City:</label>
                <p><?php echo htmlspecialchars($admission['city']); ?></p>
            </div>
            <div class="profile-info">
                <label class="profile-label">Pin Code:</label>
                <p><?php echo htmlspecialchars($admission['pincode']); ?></p>
            </div>
        </div>
    </div>
    <!-- Profile View End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer mt-5 py-6">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h2 class="text-white">
                        <img src="img/logo.jpg" alt="Logo" class="img-fluid mb-3" style="max-width: 150px;"><br>C U SHAH POLYTECHNIC
                    </h2>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="text-white mb-4">Contact Info</h4>
                    <p class="mb-2"><i class="fa fa-map-marker-alt me-2"></i>Nr. Bada Talav, GIDC Area, Wadhwan City, Surendranagar, Gujarat 363030</p>
                    <p class="mb-2"><i class="fa fa-phone-alt me-2"></i>+91 2752243494</p>
                    <p class="mb-2"><i class="fa fa-envelope me-2"></i>cusp-snagar-dte@gujarat.gov.in</p>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <div class="d-flex flex-column">
                        <a class="btn btn-link text-white mb-2" href="#">About Us</a>
                        <a class="btn btn-link text-white mb-2" href="#">Contact Us</a>
                        <a class="btn btn-link text-white mb-2" href="#">Courses</a>
                        <a class="btn btn-link text-white" href="#">Privacy Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/waypoints/waypoints.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="lib/counterup/counterup.min.js"></script>
    <script src="lib/parallax/parallax.min.js"></script>
    
    <!-- Template Javascript -->
    <script src="js/main.js"></script>
</body>

</html>
