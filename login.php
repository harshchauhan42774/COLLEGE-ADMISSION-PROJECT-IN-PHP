<?php
include ("conn.php"); // Include your database connection file

session_start(); // Start a session to store user data

$message = ""; // Initialize an empty message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = htmlspecialchars(trim($_POST['email']));
    $password = md5(trim($_POST['password'])); // Hash the password using md5

    // Prepare and execute the SQL statement
    if ($stmt = $conn->prepare("SELECT * FROM student WHERE email = ? AND password = ?")) {
        $stmt->bind_param("ss", $email, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if user exists
        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Check if OTP is NULL
            if (is_null($user['otp'])) {
                // Successful login
                $_SESSION['email'] = $email; // Store email in session
                header("Location: home.php"); // Redirect to home.php
                exit(); // Ensure no further code is executed after redirect
            } else {
                // OTP is not NULL
                $_SESSION['reverify_email'] = $email; // Store email in session for re-verification
                $message = "<p style='color: red; text-align: center;'>Please verify your email before logging in.</p>
                            <p style='text-align: center;'><a href='reverify_email.php' class='btn btn-link'>Click here to resend OTP</a></p>";
            }
        } else {
            // Invalid login
            $message = "<p style='color: red; text-align: center;'>Invalid email or password.</p>";
        }
        $stmt->close();
    } else {
        $message = "<p style='color: red; text-align: center;'>Error preparing login statement: " . $conn->error . "</p>";
    }

    $conn->close();
}
?>





<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>C U SHAH POLYTECHNIC - Login</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <link href="img/logo.jpg" rel="icon">

    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/animate/animate.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="index.html">
            <h2 class="m-0" style="color: rgb(21    0, 158, 29);"><img src="img/logo.jpg">C U SHAH POLYTECHNIC</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="courses.php" class="nav-item nav-link">Courses</a>
                <a href="login.php" class="nav-item nav-link active">Login</a>
                <a href="register.php" class="nav-item nav-link">Register</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Login Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-6 offset-lg-3 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="bg-white shadow rounded p-5">
                        <h3 class="text-center mb-4">Login</h3>
                        <?php if ($message)
                            echo $message; ?>
                        <form class="form" method="POST">
                            <div class="form-group mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-4">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="mb-4 text-end">
                                <a href="password.php">Forgot Password?</a>
                            </div>
                            <div class="d-grid mb-3">
                                <button type="submit" name="sign" class="btn btn-primary">Login</button>
                            </div>
                            <p class="text-center mt-3" style="font-size: 20px;">
                                Don't have an account? <a href="register.php">Register</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Login End -->

    <!-- Footer Start -->
    <div class="container-fluid bg-dark text-light footer my-6 mb-0 py-6 wow fadeIn" data-wow-delay="0.1s">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-3 col-md-6 mb-4">
                    <h2 style="color: white;"><img src="img/logo.jpg" alt="Logo" class="img-fluid mb-3"
                            style="max-width: 150px;"><br>C U SHAH POLYTECHNIC</h2>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="ps-4">
                        <h4 class="text-white mb-4">Contact Info</h4>
                        <p class="mb-2"><i class="fa fa-map-marker-alt me-2"></i>Nr. Bada Talav, GIDC Area, Wadhwan
                            City, Surendranagar, Gujarat 363030</p>
                        <p class="mb-2"><i class="fa fa-phone-alt me-2"></i>+91 2752243494</p>
                        <p class="mb-2"><i class="fa fa-envelope me-2"></i>cusp-snagar-dte@gujarat.gov.in</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="text-light mb-4">Quick Links</h4>
                    <div class="d-flex flex-column">
                        <a class="btn btn-link text-white mb-2" href="#">About Us</a>
                        <a class="btn btn-link text-white mb-2" href="#">Contact Us</a>
                        <a class="btn btn-link text-white mb-2" href="#">Our Services</a>
                        <a class="btn btn-link text-white mb-2" href="#">Terms & Conditions</a>
                        <a class="btn btn-link text-white mb-2" href="#">Support</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

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

    <!-- Template Javascript -->
    <script src="lib/wow/wow.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/main.js"></script>
</body>

</html>