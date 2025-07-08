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
            background-color: #001F3F; 
            padding: 20px;
            margin-bottom: 20px;
            color: #ffffff;
        }
        .container a.button {
            position: absolute;
            top: 8px; /* Adjust the top position */
            right: 30px; /* Adjust the right position */
            text-decoration: none;
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
            background-color: #001F3F; /* Navy Blue */
            color: #ffffff; /* White text */
        }

        form {
            margin-bottom: 20px;
        }

        input, button {
            padding: 8px;
            margin-right: 10px;
        }

        button.delete {
            background-color: #4CAF50; /* Green */
            color: #ffffff; /* White text */
        }
    </style>
    <title>Non-Tax Revenue Sources</title>
</head>
<body>

<div class="container">
    <h2>Add New Revenue Source</h2>
    <p>Click the button below to add a new revenue source to the list.</p>
    <button onclick="toggleForm()">Add New Revenue Source</button>
    <a href="home.php" class="button"><button>Homepage</button></a>
</div>

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
    if (isset($_POST['delete']) && isset($_POST['index'])) {
        $indexToDelete = $_POST['index'];

        // Fetch the details of the row being deleted
        $sqlGetRowDetails = "SELECT allocated_department, amount_generated FROM revenue_sources WHERE id = ?";
        $stmtGetRowDetails = $conn->prepare($sqlGetRowDetails);
        $stmtGetRowDetails->bind_param('i', $indexToDelete);
        $stmtGetRowDetails->execute();
        $resultRowDetails = $stmtGetRowDetails->get_result();

        if ($resultRowDetails->num_rows > 0) {
            $rowDetails = $resultRowDetails->fetch_assoc();
            $allocatedDepartment = $rowDetails['allocated_department'];
            $amountGenerated = $rowDetails['amount_generated'];

            // Delete the record from revenue_sources
            $sqlDeleteRevenueSource = "DELETE FROM revenue_sources WHERE id = $indexToDelete";
            $conn->query($sqlDeleteRevenueSource);

            // Update the amount_collected in the departments table
            $sqlUpdateAmount = "UPDATE departments SET amount_collected = amount_collected - ? WHERE name = ?";
            $stmtUpdateAmount = $conn->prepare($sqlUpdateAmount);
            $stmtUpdateAmount->bind_param('ds', $amountGenerated, $allocatedDepartment);
            $stmtUpdateAmount->execute();
        }
    }
    // Retrieve form data
    if (isset($_POST['edit']) && isset($_POST['index'])) {
        // Edit the "Amount Generated" for the specified index
        $indexToEdit = $_POST['index'];
        $editedAmount = $_POST['edited-amount'];

        // Update the database record
        $sql = "UPDATE revenue_sources SET amount_generated = '$editedAmount' WHERE id = $indexToEdit";
        $conn->query($sql);

        // Update the array (optional, if you want to reflect changes immediately)
        $revenueSources[$indexToEdit][2] = $editedAmount;
    } elseif (isset($_POST['delete']) && isset($_POST['index'])) {
        // Remove the revenue source at the specified index
        $indexToDelete = $_POST['index'];

        // Delete the database record
        $sql = "DELETE FROM revenue_sources WHERE id = $indexToDelete";
        $conn->query($sql);

        // Remove from the array (optional, if you want to reflect changes immediately)
        if (isset($revenueSources[$indexToDelete])) {
            unset($revenueSources[$indexToDelete]);
        }
    } elseif (isset($_POST['submit']) && !isset($_POST['index'])) {
        // Add the new revenue source to the array
        $newRevenueSource = [
            $_POST['revenue-source'],
            $_POST['amount-generated'],
            $_POST['allocated-department'],
        ];

        // Insert into the database
        $sql = "INSERT INTO revenue_sources (revenue_source, amount_generated, allocated_department) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('sss', $newRevenueSource[0], $newRevenueSource[1], $newRevenueSource[2]);
        $stmt->execute();

        // Retrieve the last inserted ID
        $lastInsertId = $stmt->insert_id;

        // Update the array with the inserted ID (optional, if you want to reflect changes immediately)
        $newRevenueSource['id'] = $lastInsertId;
        $revenueSources[] = $newRevenueSource;
    } elseif (isset($_POST['submit-edit']) && isset($_POST['index'])) {
        // Submit the edited "Amount Generated" for the specified index
        $indexToSubmit = $_POST['index'];
        $editedAmount = $_POST['edited-amount'];

        // Update the database record
        $sql = "UPDATE revenue_sources SET amount_generated = '$editedAmount' WHERE id = $indexToSubmit";
        $conn->query($sql);

        // Update the array (optional, if you want to reflect changes immediately)
        $revenueSources[$indexToSubmit][2] = $editedAmount;
    }
}

// Fetch data from the "revenue_sources" table
$sql = "SELECT id, revenue_source, amount_generated, allocated_department FROM revenue_sources";
$result = $conn->query($sql);

// Display revenue sources fetched from the database
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Revenue Source</th>';
    echo '<th>Amount Generated</th>';
    echo '<th>Amount Allocated to Department</th>';
    echo '<th>Action</th>';
    echo '</tr>';
    
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['revenue_source'] . '</td>';
        echo '<td>';
        echo '<form method="post" style="display: inline;">';
        echo '<input type="hidden" name="index" value="' . $row['id'] . '">';
        echo '<input type="text" name="edited-amount" value="' . $row['amount_generated'] . '">';
        echo '<button type="submit" name="submit-edit" class="submit-edit">Submit</button>';
        echo '</form>';
        echo '</td>';
        echo '<td>' . $row['allocated_department'] . '</td>';
        echo '<td>';
        echo '<form method="post" style="display: inline;">';
        echo '<input type="hidden" name="index" value="' . $row['id'] . '">';
        echo '<button type="submit" name="delete" class="delete">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }
    
    echo '</table>';
} else {
    echo '<p>No revenue sources available.</p>';
}

// Close the database connection
$conn->close();
?>

<form method="post" id="revenue-form" style="display: none;">
    <label for="revenue-source">Revenue Source:</label>
    <input type="text" id="revenue-source" name="revenue-source" required>

    <label for="amount-generated">Amount Generated:</label>
    <input type="text" id="amount-generated" name="amount-generated" required>
    <label for="allocated-department">Select Department:</label>
    <select id="allocated-department" name="allocated-department" required>
        <option value="Education">Education</option>
        <option value="Agriculture">Agriculture</option>
        <option value="Service">Service</option>
        <option value="Industrial">Industrial</option>
    </select>
    <button type="submit" name="submit" style="background-color: #4CAF50; color: #ffffff;">Add New Revenue Source</button>
    </form>

<script>
    function toggleForm() {
        var form = document.getElementById('revenue-form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    }
</script>

</body>
</html>