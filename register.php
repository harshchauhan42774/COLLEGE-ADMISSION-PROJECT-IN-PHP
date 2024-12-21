<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();
include 'conn.php';

// Function to send verification email
function sendVerificationEmail($toEmail, $userName, $otp)
{
    $fromEmail = 'harshchauhan2650@gmail.com';
    $subject = 'Email Verification';
    $body = "Hi $userName,\n\n";
    $body .= "Thank you for registering. Please use the following OTP to verify your email address:\n";
    $body .= "$otp\n\n";
    $body .= "Regards,\n";
    $body .= "C U SHAH POLYTECHNIC";

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'harshchauhan2650@gmail.com';
        $mail->Password = 'rtodoybhdevzdeqq'; // Use a more secure way to handle passwords
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($fromEmail, 'C U SHAH POLYTECHNIC');
        $mail->addAddress($toEmail, $userName);

        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body = $body;

        $mail->send();
        return true;    
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}

// Handle sign-up form submission
if (isset($_POST['signup'])) {
    $fname = htmlspecialchars(trim($_POST['fname']));
    $surname = htmlspecialchars(trim($_POST['surname']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $password = md5(trim($_POST['password'])); // Consider using password_hash()
    $otp = rand(100000, 999999); // Generate a 6-digit OTP

    $stmt = $conn->prepare("SELECT * FROM student WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                alert('Email Address Already Exists');
                window.location.href = 'register.php';
              </script>";
    } else {
        $stmt = $conn->prepare("INSERT INTO student (fname, surname, email, otp, phone, password) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fname, $surname, $email, $otp, $phone, $password);

        if ($stmt->execute()) {
            if (sendVerificationEmail($email, $fname, $otp)) {
                $_SESSION['email'] = $email;
                echo "<script>
                        window.location.href = 'otp.php';
                      </script>";
            } else {
                echo "Error: Could not send verification email.";
            }
        } else {
            echo "Error: " . $conn->error;
        }
    }
}

// Handle sign-in form submission
if (isset($_POST['login'])) {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = md5(trim($_POST['password'])); // Consider using password_hash() and password_verify()

    $stmt = $conn->prepare("SELECT * FROM student WHERE email = ? AND password = ?");
    $stmt->bind_param("ss", $email, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['is_verify'] == 1) {
            // User is verified, proceed with login
            echo "<script>
                    alert('Login successful!');
                    window.location.href = 'dashboard.php'; // Redirect to a logged-in area
                  </script>";
        } else {
            echo "<script>
                    alert('Please verify your email address.');
                    window.location.href = 'otp.php';
                  </script>";
        }
    } else {
        echo "<script>
                alert('Incorrect Email or Password');
                window.location.href = 'login.php';
              </script>";
    }
}

$conn->close();
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>C U SHAH POLYTECHNIC - Register</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">
    <link href="img/logo.jpg" rel="icon">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <style>
        .invalid-feedback {
            color: red;
        }

        .is-valid {
            border-color: #28a745;
        }

        .is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>

<body>
    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
        <a href="index.html">
            <h2 class="m-0" style="color: rgb(21, 0, 158, 29);"><img src="img/logo.jpg">C U SHAH POLYTECHNIC</h2>
        </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="index.php" class="nav-item nav-link">Home</a>
                <a href="about.php" class="nav-item nav-link">About</a>
                <a href="courses.php" class="nav-item nav-link">Courses</a>
                <a href="login.php" class="nav-item nav-link">Login</a>
                <a href="register.php" class="nav-item nav-link active">Register</a>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Registration Form Start -->
    <div class="container-xxl py-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h1 class="display-6 mb-4">Register</h1>
                    <form id="registerForm" class="form" method="POST">
                        <div class="form-group mb-3">
                            <label for="fname" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="surname" class="form-label">Surname</label>
                            <input type="text" class="form-control" id="surname" name="surname" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" name="signup" class="btn btn-primary py-3 px-5">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Registration Form End -->

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
                        <div class="d-flex mb-2">
                            <i class="bi bi-geo-alt text-primary me-2"></i>
                            <p class="mb-0">Near B.S.N.L. Office, Opp. Akashwani Quarter, Bhavnagar Road, Surendranagar
                                - 363002, Gujarat.</p>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bi bi-envelope-open text-primary me-2"></i>
                            <p class="mb-0">cuspolytechnic@yahoo.co.in</p>
                        </div>
                        <div class="d-flex mb-2">
                            <i class="bi bi-telephone text-primary me-2"></i>
                            <p class="mb-0">(02752) 260 056</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="text-white mb-4">Quick Links</h4>
                    <a class="btn btn-link" href="about.php">About</a>
                    <a class="btn btn-link" href="contact.php">Contact</a>
                    <a class="btn btn-link" href="courses.php">Courses</a>
                    <a class="btn btn-link" href="register.php">Register</a>
                    <a class="btn btn-link" href="login.php">Login</a>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <h4 class="text-white mb-4">Follow Us</h4>
                    <div class="d-flex">
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-instagram"></i></a>
                        <a class="btn btn-outline-light btn-social" href="#"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer End -->

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free/js/all.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>

    <script>
        $(document).ready(function () {
            $("#registerForm").validate({
                rules: {
                    fname: {
                        required: true,
                        minlength: 2
                    },
                    surname: {
                        required: true,
                        minlength: 2
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    phone: {
                        required: true,
                        digits: true,
                        minlength: 10,
                        maxlength: 10
                    },
                    password: {
                        required: true,
                        minlength: 6
                    }
                },
                messages: {
                    fname: {
                        required: "Please enter your first name",
                        minlength: "First name must be at least 2 characters long"
                    },
                    surname: {
                        required: "Please enter your surname",
                        minlength: "Surname must be at least 2 characters long"
                    },
                    email: {
                        required: "Please enter your email",
                        email: "Please enter a valid email address"
                    },
                    phone: {
                        required: "Please enter your phone number",
                        digits: "Please enter only digits",
                        minlength: "Phone number must be 10 digits",
                        maxlength: "Phone number must be 10 digits"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    }
                },
                errorElement: "div",
                errorClass: "invalid-feedback",
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                }
            });
        });
    </script>
</body>

</html>
