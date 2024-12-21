    <?php
    include 'conn.php';

    // Fetch branch and seat limit from GET or POST
    $branch = $_GET['branch'] ?? $_POST['branch'] ?? '';
    $seat_limit = $_POST['seat_limit'] ?? $_GET['seat_limit'] ?? null;
    $message = '';

    if ($branch && $seat_limit !== null) {
        try {
            $conn->begin_transaction();

            // Clear existing merit list data for the branch
            $delete_sql = $conn->prepare("DELETE FROM merit WHERE branch = ?");
            $delete_sql->bind_param("s", $branch);
            $delete_sql->execute();

            // Fetch sorted data from 'admission1' for the branch excluding rejected students
            $sql = $conn->prepare("SELECT * FROM admission1 WHERE branch = ? AND status != 'Rejected' ORDER BY percentage DESC LIMIT ?");
            $sql->bind_param("si", $branch, $seat_limit);

            if ($sql->execute()) {
                $result = $sql->get_result();
                if ($result->num_rows > 0) {
                    // Insert data into the merit table
                    $insert_sql = $conn->prepare("INSERT INTO merit (student_id, name, branch, rank, percentage) VALUES (?, ?, ?, ?, ?)");
                    $rank = 1;

                    while ($row = $result->fetch_assoc()) {
                        $insert_sql->bind_param("issii", $row['id'], $row['marksheet_name'], $branch, $rank, $row['percentage']);
                        $insert_sql->execute();
                        $rank++;
                    }

                    $message = "Merit list for {$seat_limit} seats in {$branch} has been created and stored.";
                } else {
                    $message = "No eligible students found for the selected branch.";
                }
            } else {
                throw new Exception("Error fetching data from the database.");
            }

            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            $message = "An error occurred: " . htmlspecialchars($e->getMessage());
        }
    }

    // Fetch and display non-rejected students for all branches (optional for debugging)
    $sql_all = "SELECT * FROM admission1 WHERE status != 'Rejected' ORDER BY percentage DESC";
    $result_all = $conn->query($sql_all);

    if ($result_all->num_rows > 0) {
        while ($row = $result_all->fetch_assoc()) {
            echo "Student ID: " . $row['student_id'] . " - Name: " . $row['marksheet_name'] . " - Percentage: " . $row['percentage'] . "<br>";
        }
    } else {
        echo "No eligible students found for any branch.";
    }

    // Close the connection at the very end
    // $conn->close();
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <!-- Metadata and CSS links -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Merit List - C U SHAH POLYTECHNIC</title>
        <link href="img/logo.jpg" rel="icon">
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:300,400,600,700|Poppins:300,400,500,600,700"
            rel="stylesheet">
        <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
        <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
        <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
        <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
        <style>
            .table-container {
                margin-top: 20px;
                overflow-x: auto;
            }

            .table-responsive {
                width: 100%;
                overflow-x: auto;
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th,
            td {
                padding: 12px 15px;
                border: 1px solid #ddd;
            }

            th {
                background-color: #f4f4f4;
            }

            .footer {
                margin-top: 50px;
                padding: 20px 0;
                background-color: #343a40;
                color: #ffffff;
            }

            .btn-group {
                margin: 10px;
            }
        </style>
    </head>

    <body>

        <!-- Header -->
        <header id="header" class="header fixed-top d-flex align-items-center">
            <div class="d-flex align-items-center justify-content-between">
                <a href="admin_dashboard.php" class="logo d-flex align-items-center">
                    <img src="img/logo.jpg" alt="Logo" style="height: 40px;">
                    <span class="d-none d-lg-block ms-2">C U SHAH POLYTECHNIC</span>
                </a>
                <i class="bi bi-list toggle-sidebar-btn"></i>
            </div>
        </header>

        <!-- Sidebar -->
        <aside id="sidebar" class="sidebar">
            <ul class="sidebar-nav" id="sidebar-nav">
                <li class="nav-item">
                    <a class="nav-link collapsed" href="admin_dashboard.php">
                        <i class="bi bi-grid"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="view.php">
                        <i class="bi bi-file-earmark"></i>
                        <span>View Admission</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="merit.php">
                        <i class="bi bi-award"></i>
                        <span>Merit</span>
                    </a>
                </li>
            </ul>
        </aside>

        <main id="main" class="main">
            <section class="section dashboard">
                <div class="row">
                    <div class="col-12">
                        <h2>Merit List</h2>
                        <div class="btn-group">
                            <a href="merit.php?branch=Computer Engineering" class="btn btn-primary">Computer Engineering</a>
                            <a href="merit.php?branch=Mechanical Engineering" class="btn btn-success">Mechanical
                                Engineering</a>
                            <a href="merit.php?branch=Electrical Engineering" class="btn btn-danger">Electrical
                                Engineering</a>
                        </div>

                        <form method="POST" action="merit.php<?php echo $branch ? '?branch=' . urlencode($branch) : ''; ?>">
                            <div class="form-group">
                                <label for="seat_limit">Number of Seats:</label>
                                <input type="number" class="form-control" id="seat_limit" name="seat_limit" min="1"
                                    required>
                            </div>
                            <button type="submit" class="btn btn-success mt-3">Create Merit List</button>
                        </form>

                        <?php if ($message): ?>
                            <div class="alert alert-info mt-3">
                                <?php echo htmlspecialchars($message); ?>
                            </div>
                        <?php endif; ?>

                        <div class="table-container">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Rank</th>
                                            <th>Name</th>
                                            <th>Branch</th>
                                            <th>Percentage</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($branch) {
                                            $sql = $conn->prepare("SELECT * FROM merit WHERE branch = ? ORDER BY rank");
                                            $sql->bind_param("s", $branch);
                                            if ($sql->execute()) {
                                                $result = $sql->get_result();
                                                if ($result->num_rows > 0) {
                                                    $rank = 1;
                                                    while ($row = $result->fetch_assoc()) {
                                                        echo "<tr>";
                                                        echo "<td>" . $rank++ . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["branch"]) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row["percentage"]) . "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='8'>No data to display.</td></tr>";
                                                }
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </body>

    </html>