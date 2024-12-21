<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['otp'])) {
    echo "<script>
            alert('Unauthorized access.');
            window.location.href = 'index.php';
          </script>";
    exit();
}

if (isset($_POST['verify_otp'])) {
    $otp = $_POST['otp'];

    if ($otp == $_SESSION['otp']) {
        echo "<script>
                alert('OTP verified. You can now reset your password.');
                window.location.href = 'reset_password.php';
              </script>";
    } else {
        echo "<script>
                alert('Incorrect OTP. Please try again.');
                window.location.href = 'verify_otp.php';
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
            <h1 class="display-6 mb-4">Verify OTP</h1>
            <form method="POST">
                <div class="form-group mb-3">
                    <label for="otp" class="form-label">Enter OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" required>
                </div>
                <button type="submit" name="verify_otp" class="btn btn-primary py-3 px-5">Verify</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
