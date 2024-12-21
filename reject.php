<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $student_id = intval($_POST['id']);

    // Update query
    $sql = "UPDATE admission1 SET status = 'Rejected' WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error";
    }

    $stmt->close();
} else {
    echo "Invalid Request";
}

$conn->close();
?>
