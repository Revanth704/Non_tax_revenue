<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f2f2f2;
        }

        .apply-form {
            width: 50%;
            margin: 20px auto;
            padding: 20px;
            background-color: #001f3f;
            color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        }

        form label {
            display: inline-block;
            width: 30%;
            margin-bottom: 5px;
        }

        form input {
            width: 68%;
            padding: 8px;
            margin-bottom: 15px;
            box-sizing: border-box;
        }

        form button {
            padding: 10px;
            background-color: #004080;
            color: #ffffff;
            border: none;
            cursor: pointer;
        }
    </style>
    <title>Apply for Scheme</title>
  
</head>
<body>

<div class="apply-form">
    
<a href="apply.php" class="button" style="top: 85px;float:right;"><button>Back</button></a>
    <h2>Apply for Scheme</h2>
    <form method="post" action="">
        <label for="name">Name:</label>
        <input type="text" name="name" required>

        <label for="age">Age:</label>
        <input type="text" name="age">

        <label for="location">Location:</label>
        <input type="text" name="location">

        <label for="locality">Locality:</label>
        <input type="text" name="locality">

        <label for="house_no">House No:</label>
        <input type="text" name="house_no">

        <label for="state">State:</label>
        <input type="text" name="state">

        <label for="phone_numbers">Phone Numbers:</label>
        <input type="text" name="phone_numbers">

        <label for="scheme_name">Scheme:</label>
        <input type="text" name="scheme_name">

        <button type="submit" > <a href="http://localhost/dbms/apply.php" style="text-decoration:none;color:white;">Submit Application</a></button>
    </form>
</div>

<?php
// Connect to your database (replace these with your actual database credentials)
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'non_tax_revenue';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $scheme_name = $_POST['scheme_name'];
    $location = $_POST['location'];
    $locality = $_POST['locality'];
    $house_no = $_POST['house_no'];
    $state = $_POST['state'];
    $phone_numbers = $_POST['phone_numbers'];

    // Insert data into the beneficiary table
    $sql = "INSERT INTO beneficiary (name, age, scheme_name, location, locality, house_no, state, phone_numbers) 
            VALUES ('$name', '$age', '$scheme_name', '$location', '$locality', '$house_no', '$state', '$phone_numbers')";

    if ($conn->query($sql) === TRUE) {
        echo "<p>Application submitted successfully!</p>";
        // Redirect to the same page to clear the form
        header("Location: ".$_SERVER['PHP_SELF']);
    } else {
        echo "<p>Error: " . $sql . "<br>" . $conn->error . "</p>";
    }
}

// Close the database connection
$conn->close();
?>

</body>
</html>
