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
    cursor: pointer;
}

button.update {
    background-color: #4CAF50; /* Green */
    color: #ffffff; /* White text */
    border: none;
}

button.delete {
    background-color: #f44336; /* Red */
    color: #ffffff; /* White text */
    border: none;
}
    </style>
    <title>LEGISLATION</title>
</head>
<body>

<div class="container">
    <h2 style="color: #ffffff;">LEGISLATION</h2>
    <a href="home.php" class="button" style="top: 85px;float:right;"><button>Homepage</button></a>
    <p style="color: #ffffff;">This page allows you to see and update the LEGISLATION of the scheme. Changes will reflect in the database.</p>
</div>

<table>
    <tr>
        <th>SCHEME</th>
        <th>LEGISLATION</th>
        <th>ACTION</th>
    </tr>

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

    // Retrieve scheme details from the database
    $sql = "SELECT scheme_name, legislation FROM scheme";
    $result = $conn->query($sql);

    // Display scheme details in the table
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['scheme_name'] . "</td>";
            echo "<td>" . $row['legislation'] . "</td>";
            echo "<td>";
            echo "<form method='post'>";
            echo "<input type='hidden' name='scheme_name' value='" . $row['scheme_name'] . "'>";
            echo "<input type='text' name='new_outcome' placeholder='New Outcome'>";
            echo "<button type='submit' name='update_outcome'>Update</button>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No data available</td></tr>";
    }

    // Update the outcome in the database
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_outcome'])) {
        $schemeName = $_POST['scheme_name'];
        $newOutcome = $_POST['new_outcome'];

        $updateSql = "UPDATE scheme SET legislation = '$newOutcome' WHERE scheme_name = '$schemeName'";
        $conn->query($updateSql);
        
        // You may want to add error handling for the update operation
    }

    // Close the database connection
    $conn->close();
    ?>

</table>

</body>
</html>