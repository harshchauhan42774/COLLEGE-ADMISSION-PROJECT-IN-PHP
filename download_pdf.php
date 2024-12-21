<?php
require('fpdf/fpdf.php'); // Include the FPDF library
include 'conn.php'; // Include the database connection file

if (isset($_POST['student_id'])) {
    $student_id = $_POST['student_id'];

    // Fetch student data
    $sql_student = "SELECT * FROM student WHERE id = ?";
    $stmt_student = $conn->prepare($sql_student);
    $stmt_student->bind_param("i", $student_id);
    $stmt_student->execute();
    $result_student = $stmt_student->get_result();
    $student = $result_student->fetch_assoc();

    // Fetch admission data
    $sql_admission = "SELECT * FROM admissions WHERE student_id = ?";
    $stmt_admission = $conn->prepare($sql_admission);
    $stmt_admission->bind_param("i", $student_id);
    $stmt_admission->execute();
    $result_admission = $stmt_admission->get_result();
    $admission = $result_admission->fetch_assoc();

    // Fetch admission1 data
    $sql_admission1 = "SELECT * FROM admission1 WHERE student_id = ?";
    $stmt_admission1 = $conn->prepare($sql_admission1);
    $stmt_admission1->bind_param("i", $student_id);
    $stmt_admission1->execute();
    $result_admission1 = $stmt_admission1->get_result();
    $admission1 = $result_admission1->fetch_assoc();

    // Create instance of FPDF
    $pdf = new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);

    // Add student information to the PDF
    $pdf->Cell(0, 10, 'Student Information', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'First Name: ' . $admission['fname']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Last Name: ' . $admission['lname']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Email: ' . $admission['email']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Mobile: ' . $admission['mobile']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Date of Birth: ' . $admission['dob']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Father\'s Name: ' . $admission['fathername']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Mother\'s Name: ' . $admission['mothername']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Parents\' Phone: ' . $admission['parents_phone']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Category: ' . $admission['category']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Gender: ' . $admission['gender']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Permanent Address: ' . $admission['perment_address']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Present Address: ' . $admission['present_address']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Pincode: ' . $admission['pincode']);
    $pdf->Ln();

    $pdf->Ln();
    $pdf->Cell(0, 10, 'Educational Information', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Branch: ' . $admission1['branch']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Board: ' . $admission1['board']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Passing Year: ' . $admission1['passing_year']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Passing Month: ' . $admission1['passing_month']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Seat Number: ' . $admission1['seat_number']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Marksheet Name: ' . $admission1['marksheet_name']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Attempts: ' . $admission1['attempts']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Total Marks: ' . $admission1['total_marks']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Obc Marks: ' . $admission1['obc_marks']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Percentage: ' . $admission1['percentage']);
    $pdf->Ln();
    $pdf->Cell(40, 10, 'Language Medium: ' . $admission1['language_medium']);
    $pdf->Ln();

    // Output the PDF
    $pdf->Output('D', 'Admission_Details.pdf');
}

// Close the database connections
$stmt_student->close();
$stmt_admission->close();
$stmt_admission1->close();
$conn->close();
?>
