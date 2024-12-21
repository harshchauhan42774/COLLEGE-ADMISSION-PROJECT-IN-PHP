<?php
session_start();
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Replace with your own SQL query and validation logic
    $query = "SELECT * FROM admin WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login successful
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username; // Optional: Store the admin's username
        header('Location: admin_dashboard.php');
        exit;
    } else {
        // Login failed
        $error = "Invalid username or password";
    }
}
?>

<!-- HTML login form code goes here -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <style>
        /* General styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Main container */
        main {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 400px;
            width: 100%;
            text-align: center;
        }

        /* Logo */
        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }

        /* Heading */
        h1 {
            margin-bottom: 20px;
            color: #333;
        }

        /* Form styles */
        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        /* Input styles */
        input[type="text"],
        input[type="password"] {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }

        /* Button styles */
        button {
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #0056b3;
        }

        /* Error message styles */
        p {
            margin: 10px 0;
        }

        p.error {
            color: red;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <main>
        <div>
            <img src="img/logo.jpg" alt="">
        </div>
        <h1>Admin Login</h1>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </main>
</body>

</html>