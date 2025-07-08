<?php
// Replace the following with your actual database credentials
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'non_tax_revenue';

// Create a database connection
$conn = new mysqli($host, $username, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Handle delete operation
    if (isset($_POST['delete']) && isset($_POST['department_id'])) {
        $departmentIdToDelete = $_POST['department_id'];

        // Fetch the details of the department being deleted
        $sqlGetDepartment = "SELECT allocated_department, amount_generated FROM revenue_sources WHERE allocated_department = ?";
        $stmtGetDepartment = $conn->prepare($sqlGetDepartment);
        $stmtGetDepartment->bind_param('s', $departmentIdToDelete);
        $stmtGetDepartment->execute();
        $resultGetDepartment = $stmtGetDepartment->get_result();

        if ($resultGetDepartment->num_rows > 0) {
            while ($row = $resultGetDepartment->fetch_assoc()) {
                $allocatedDepartment = $row['allocated_department'];
                $amountGenerated = $row['amount_generated'];

                // Delete the record from revenue_sources
                $sqlDeleteRevenueSource = "DELETE FROM revenue_sources WHERE allocated_department = '$departmentIdToDelete'";
                $conn->query($sqlDeleteRevenueSource);

                // Update the amount_collected in the departments table
                $sqlUpdateAmount = "UPDATE departments SET amount_collected = amount_collected - ? WHERE name = ?";
                $stmtUpdateAmount = $conn->prepare($sqlUpdateAmount);
                $stmtUpdateAmount->bind_param('ds', $amountGenerated, $allocatedDepartment);
                $stmtUpdateAmount->execute();
            }
        }
    }

    // Handle add/edit operation
    if (isset($_POST['submit'])) {
        // Your existing code for add/edit operation goes here
    }
}

// Fetch data with sum grouped by department from the "revenue_sources" table
$sqlSum = "SELECT allocated_department, SUM(amount_generated) AS total_amount FROM revenue_sources GROUP BY allocated_department";
$resultSum = $conn->query($sqlSum);

// Initialize an array with all four departments and placeholder values
$allDepartments = [
    'Education' => ['name' => 'Education', 'amount_collected' => NULL, 'description' => ''],
    'Agriculture' => ['name' => 'Agriculture', 'amount_collected' => NULL, 'description' => ''],
    'Service' => ['name' => 'Service', 'amount_collected' => NULL, 'description' => ''],
    'Industrial' => ['name' => 'Industrial', 'amount_collected' => NULL, 'description' => ''],
];

// Process the query result for sum
if ($resultSum->num_rows > 0) {
    while ($row = $resultSum->fetch_assoc()) {
        // Update the array with the actual data
        $departmentName = $row['allocated_department'];
        $totalAmount = $row['total_amount'];
        $allDepartments[$departmentName]['amount_collected'] = $totalAmount;

        // Check if the department already exists in the departments table
        $sqlCheckDepartment = "SELECT * FROM departments WHERE name = ?";
        $stmtCheckDepartment = $conn->prepare($sqlCheckDepartment);
        $stmtCheckDepartment->bind_param('s', $departmentName);
        $stmtCheckDepartment->execute();
        $resultCheckDepartment = $stmtCheckDepartment->get_result();

        if ($resultCheckDepartment->num_rows === 0) {
            // Insert the department into the departments table
            $sqlInsertDepartment = "INSERT INTO departments (name, description, amount_collected) VALUES (?, '', ?)";
            $stmtInsertDepartment = $conn->prepare($sqlInsertDepartment);
            $stmtInsertDepartment->bind_param('sd', $departmentName, $totalAmount);
            $stmtInsertDepartment->execute();
        } else {
            // Retrieve the existing amount_collected and update if it's less than the current totalAmount
            $sqlGetExistingAmount = "SELECT amount_collected FROM departments WHERE name = ?";
            $stmtGetExistingAmount = $conn->prepare($sqlGetExistingAmount);
            $stmtGetExistingAmount->bind_param('s', $departmentName);
            $stmtGetExistingAmount->execute();
            $resultExistingAmount = $stmtGetExistingAmount->get_result();

            if ($resultExistingAmount->num_rows > 0) {
                $rowExistingAmount = $resultExistingAmount->fetch_assoc();
                $existingAmount = $rowExistingAmount['amount_collected'];

                // Update the amount_collected if the current totalAmount is greater than the existing amount
                if ($totalAmount > $existingAmount) {
                    $amountToUpdate = $totalAmount - $existingAmount;

                    $sqlUpdateAmount = "UPDATE departments SET amount_collected = amount_collected + ? WHERE name = ?";
                    $stmtUpdateAmount = $conn->prepare($sqlUpdateAmount);
                    $stmtUpdateAmount->bind_param('ds', $amountToUpdate, $departmentName);
                    $stmtUpdateAmount->execute();
                }
            }
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        .container {
            background-color: #001f3f; /* Navy Blue */
            padding: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #001f3f; /* Navy Blue */
            color: #ffffff; /* White text */
        }

        form {
            margin-bottom: 20px;
        }
        button {
            padding: 8px;
            margin-right: 10px;
        }
        button.delete {
            background-color: #008000; /* Green */
            color: #ffffff; /* White text */
        }
    </style>
    <title>Department Management</title>
</head>
<body>

<div class="container">
<a href="home.php" class="button" style="top: 85px;float:right;"><button>Homepage</button></a>
    <h2 style="color: #ffffff;">Department Management</h2>
    <p style="color: #ffffff;">This page allows you to manage departments. Changes will reflect in the database.</p>
    

</div>
<table>
    <tr>
        <th>Department Name</th>
        <th>Amount Collected</th>
        <th>Department Description</th>
    </tr>
    <?php foreach ($allDepartments as $department) : ?>
        <tr>
            <td><?php echo $department['name']; ?></td>
            <td><?php echo $department['amount_collected'] ?? 'N/A'; ?></td>
            <td><?php echo $department['description']; ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<!-- Your HTML form here, make sure you have an input field named 'amount-collected-from-form' -->

</body>
</html>
