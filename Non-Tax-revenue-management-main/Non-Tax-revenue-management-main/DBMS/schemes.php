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
            top: 8px;
            right: 30px;
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
            color: #ffffff;
        }

        form {
            margin-bottom: 20px;
        }

        input, textarea, button, select {
            padding: 8px;
            margin-right: 10px;
        }

        button.delete {
            background-color: #f44336;
            color: #fff;
        }
    </style>
    <title>Sample Schemes</title>
</head>
<body>

<div class="container">
    <h2>Add New Scheme</h2>
    <p>Click the button below to add a new scheme to the list.</p>
    <button onclick="toggleForm()">Add New Scheme</button>
    <a href="home.php" class="button" style="top: 85px"><button>Homepage</button></a>
</div>

<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'non_tax_revenue';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_scheme']) && isset($_POST['scheme_id'])) {
        $scheme_id = $_POST['scheme_id'];
        $delete_sql = "DELETE FROM scheme WHERE scheme_id = $scheme_id";

        if ($conn->query($delete_sql) === TRUE) {

        } else {
            echo "Error deleting scheme: " . $conn->error;
        }
    } elseif (isset($_POST['submit']) && !empty($_POST['scheme_name']) && !empty($_POST['scheme_description']) && !empty($_POST['scheme_budget']) && !empty($_POST['scheme_department']) && !empty($_POST['legislation']) && !empty($_POST['outcome']) && !empty($_POST['document'])) {
        $scheme_name = $_POST['scheme_name'];
        $scheme_description = $_POST['scheme_description'];
        $scheme_budget = $_POST['scheme_budget'];
        $scheme_department = $_POST['scheme_department'];
        $legislation = $_POST['legislation'];
        $outcome = $_POST['outcome'];
        $document = $_POST['document'];

        $insert_sql = "INSERT INTO scheme (scheme_name, scheme_description, scheme_budget, scheme_department, legislation, outcome, document) VALUES ('$scheme_name', '$scheme_description', '$scheme_budget', '$scheme_department', '$legislation', '$outcome', '$document')";

        if ($conn->query($insert_sql) === TRUE) {
            echo "New scheme added successfully!";
        } else {
            echo "Error: " . $insert_sql . "<br>" . $conn->error;
        }
    }
}

$sql = "SELECT scheme_id, scheme_name, scheme_description, scheme_budget, scheme_department, legislation, outcome, document FROM scheme";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Scheme Name</th>';
    echo '<th>Scheme Description</th>';
    echo '<th>Scheme Budget</th>';
    echo '<th>Scheme Department</th>';
    echo '<th>Action</th>';
    echo '</tr>';

    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . $row['scheme_name'] . '</td>';
        echo '<td>' . $row['scheme_description'] . '</td>';
        echo '<td>' . $row['scheme_budget'] . '</td>';
        echo '<td>' . $row['scheme_department'] . '</td>';
        echo '<td>';
        echo '<form method="post" style="display: inline;">';
        echo '<input type="hidden" name="scheme_id" value="' . $row['scheme_id'] . '">';
        echo '<button type="submit" name="delete_scheme" class="delete">Delete</button>';
        echo '</form>';
        echo '</td>';
        echo '</tr>';
    }

    echo '</table>';
} else {
    echo '<p>No schemes available.</p>';
}

$conn->close();
?>

<form method="post" id="scheme-form" style="display: none;">
    <label for="scheme_name">Scheme Name:</label>
    <input type="text" id="scheme_name" name="scheme_name" required>

    <label for="scheme_description">Scheme Description:</label>
    <textarea id="scheme_description" name="scheme_description" required></textarea>

    <label for="scheme_budget">Scheme Budget:</label>
    <input type="text" id="scheme_budget" name="scheme_budget" required>

    <label for="scheme_department">Scheme Department:</label>
    <select id="scheme_department" name="scheme_department" required>
        <option value="Education">Education</option>
        <option value="Agriculture">Agriculture</option>
        <option value="Service">Service</option>
        <option value="Industrial">Industrial</option>
    </select>

    <label for="legislation">Legislation:</label>
    <input type="text" id="legislation" name="legislation" required>

    <label for="outcome">Outcome:</label>
    <input type="text" id="outcome" name="outcome" required>

    <label for="document">Document:</label>
    <input type="text" id="document" name="document" required>

    <button type="submit" name="submit" style="background-color: #4CAF50; color: #fff;">Add New Scheme</button>
</form>

<script>
    function toggleForm() {
        var form = document.getElementById('scheme-form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';
    }
</script>

</body>
</html>
