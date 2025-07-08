<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Display</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
            background-image: url('https://img.freepik.com/free-vector/layout-abstract-illustration_335657-5136.jpg?size=626&ext=jpg&ga=GA1.1.1753624679.1703166247&semt=ais');
            background-size: 90% 150%;
            background-repeat: no-repeat;
            
        }

        .container {
            margin-top: 120px;
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the last value for transparency */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
            margin-top:120px;
            text-align: left; /* Align text to the left within the container */
        }

        h1 {
            color: #333;
            text-align: center; /* Center the text within the container */
        }

        p {
            margin-bottom: 10px;
            color: #555;
            line-height: 1.6; /* Improve text readability with a proper line height */
        }

        strong {
            color: #333;
            display: inline-block;
            width: 120px; /* Adjust width based on your preference */
            margin-right: 10px;
            font-weight: bold;
        }
        .button {
             color:black;
             background:blue;
        }
    </style>
</head>

<body>
    <div class="container">
    <a href="benhome.php" class="button" style="top: 85px;float:right;"><button>Homepage</button></a>
        <h1>User Display</h1>
        <?php
        $host = "localhost";
        $username = "root";
        $password = "";
        $database = "non_tax_revenue";

        $conn = new mysqli($host, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT username FROM login_attempts ORDER BY login_time DESC LIMIT 1";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $username = $row['username'];

            // Retrieve user details from the users table
            $userDetailsSql = "SELECT * FROM users WHERE username = '$username'";
            $userDetailsResult = $conn->query($userDetailsSql);

            if ($userDetailsResult->num_rows > 0) {
                $userDetails = $userDetailsResult->fetch_assoc();

                // Display user details
                echo "<p><strong>Username:</strong> " . $userDetails['username'] . "</p>";
                echo "<p><strong>Email:</strong> " . $userDetails['email'] . "</p>";
                echo "<p><strong>Phone:</strong> " . $userDetails['phone'] . "</p>";
                echo "<p><strong>Aadhaar:</strong> " . $userDetails['aadhaar'] . "</p>";
                echo "<p><strong>Bank Account:</strong> " . $userDetails['bank_acc'] . "</p>";
                echo "<p><strong>IFSC Code:</strong> " . $userDetails['ifsc_code'] . "</p>";

            } else {
                echo "<p>User details not found</p>";
            }
        } else {
            echo "<p>No username found</p>";
        }

        $conn->close();
        ?>
    </div>
</body>

</html>
