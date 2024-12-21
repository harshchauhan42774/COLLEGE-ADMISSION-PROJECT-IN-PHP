<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
session_start();
include 'conn.php';

if (isset($_POST['submitEmail'])) {
    $email = $_POST['email'];

    // Check if the email exists in the database
    $stmt = $conn->prepare("SELECT * FROM student WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $otp = rand(100000, 999999); // Generate a 6-digit OTP
        $_SESSION['otp'] = $otp;
        $_SESSION['email'] = $email;

        // Send OTP to the user's email
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'harshchauhan2650@gmail.com';
            $mail->Password = 'rtodoybhdevzdeqq';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('harshchauhan2650@gmail.com', 'C U SHAH POLYTECHNIC');
            $mail->addAddress($email);

            $mail->isHTML(false);
            $mail->Subject = 'Password Reset OTP';
            $mail->Body = "Your OTP for password reset is: $otp";

            $mail->send();
            echo "<script>
                    alert('An OTP has been sent to your email. Please check your email.');
                    window.location.href = 'verify_email.php';
                  </script>";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>
                alert('Email address not found.');
                window.location.href = 'reverify_email.php';
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Verify OTP</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg bg-white navbar-light sticky-top p-0">
    <a href="index.html">
        <h2 class="m-0" style="color: rgb(21, 0, 158, 29);"><img src="img/logo.jpg">C U SHAH POLYTECHNIC</h2>
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
</nav>
<br><br><br><br><br><br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-6">
            <h1 class="display-6 mb-4">Verify Email</h1>
            <form method="POST">
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                </div>
                <button type="submit" name="submitEmail" class="btn btn-primary py-3 px-5">Send</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
