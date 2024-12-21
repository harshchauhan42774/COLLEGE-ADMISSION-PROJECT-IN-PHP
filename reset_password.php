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

if (isset($_POST['reset_password'])) {
    $newPassword = md5($_POST['new_password']);
    $confirmPassword = md5($_POST['confirm_password']);
    $email = $_SESSION['email'];

    if ($newPassword !== $confirmPassword) {
        echo "<script>
                alert('Passwords do not match. Please try again.');
                window.location.href = 'reset_password.php';
              </script>";
        exit();
    }

    // Update the user's password in the database
    $stmt = $conn->prepare("UPDATE student SET password = ? WHERE email = ?");
    $stmt->bind_param("ss", $newPassword, $email);

    if ($stmt->execute()) {
        // Clear the session data
        session_unset();
        session_destroy();

        echo "<script>
                alert('Your password has been reset successfully. Please log in with your new password.');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reset Password</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script>
        function validatePasswords() {
            var newPassword = document.getElementById("new_password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            if (newPassword !== confirmPassword) {
                alert("Passwords do not match. Please try again.");
                return false;
            }
            return true;
        }
    </script>
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
            <h1 class="display-6 mb-4">Reset Password</h1>
            <form method="POST" onsubmit="return validatePasswords()">
                <div class="form-group mb-3">
                    <label for="new_password" class="form-label">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="form-control" placeholder="Enter new password" required>
                </div>
                <div class="form-group mb-3">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" class="form-control" placeholder="Confirm new password" required>
                </div>
                <button type="submit" name="reset_password" class="btn btn-primary py-3 px-5">Reset Password</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>