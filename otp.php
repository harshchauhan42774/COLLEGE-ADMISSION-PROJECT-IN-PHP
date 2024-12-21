<?php
include("conn.php"); // Include your database connection file

session_start(); // Start the session to get the stored email
$message = ""; // Initialize an empty message variable

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = $_SESSION['email'];
    $otp = htmlspecialchars(trim($_POST['otp']));

    // Verify OTP
    if ($stmt = $conn->prepare("SELECT * FROM student WHERE email = ? AND otp = ?")) {
        $stmt->bind_param("ss", $email, $otp);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // OTP verified
            if ($updateStmt = $conn->prepare("UPDATE student SET otp = NULL WHERE email = ?")) {
                $updateStmt->bind_param("s", $email);
                if ($updateStmt->execute()) {
                    // Redirect to home.php after successful verification
                    header("Location: home.php");
                    exit(); // Ensure no further code is executed
                } else {
                    echo "<script>alert('Error updating OTP status: " . addslashes($updateStmt->error) . "');</script>";
                }
                $updateStmt->close();
            }
        } else {
            // Alert user about invalid OTP
            echo "<script>alert('Invalid OTP. Please try again.');</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing OTP verification statement: " . addslashes($conn->error) . "');</script>";
    }

    $conn->close();
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
    </nav><br><br><br><br><br><br>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <h1 class="display-6 mb-4">Verify OTP</h1>
                <!-- Display the error or success message -->
                <?php if (!empty($message))
                    echo $message; ?>
                <form method="POST">
                    <div class="form-group mb-3">
                        <label for="otp" class="form-label">Enter OTP</label>
                        <input type="text" class="form-control" id="otp" name="otp" required>
                    </div>
                    <button type="submit" name="verify_otp" class="btn btn-primary py-3 px-5"
                        class="sign">Verify</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>