<!-- all_schemes.php -->

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

        .apply-form {
            display: none;
            background-color: #f2f2f2;
            padding: 20px;
            margin-top: 10px;
        }
    </style>
    <title>All Schemes</title>
</head>
<body>

<div class="container">


    <h2 style="color: #ffffff;">All Schemes</h2>
    <p style="color: #ffffff;">This page displays all schemes available in the database.</p>
    <a href="benhome.php" class="button" style="top: 85px;float:right;"><button>Homepage</button></a>
</div>

<table>
    <tr>
        <th>Scheme Name</th>
        <th>Scheme Description</th>
        <th>Action</th>
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

    // Retrieve all scheme details from the database
    $sql = "SELECT scheme_name, scheme_description FROM scheme";
    $result = $conn->query($sql);

    // Display scheme name, description, and apply button in the table
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['scheme_name'] . "</td>";
            echo "<td>" . $row['scheme_description'] . "</td>";
            echo "<td>";
            echo "<button onclick=\"applyRedirect('" . $row['scheme_name'] . "')\">Apply</button>";
            echo "</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='3'>No schemes available</td></tr>";
    }

    // Close the database connection
    $conn->close();
    ?>

</table>



<script>
    function applyRedirect(schemeName) {
       
        window.location.href = 'http://localhost/dbms/index.php';
    }
</script>

</body>
</html>
