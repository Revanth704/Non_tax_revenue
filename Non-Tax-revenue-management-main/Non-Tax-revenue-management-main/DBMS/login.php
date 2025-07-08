<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="login-styles.css">
    <style>
    body {
        background-image: url("https://wallpapercave.com/wp/wp3400422.jpg");
        background-size: cover;
        background-position: fixed;
        margin: 0; /* Set margin to 0 to remove default margin */
    }
</style>

</head>

<body>
    <!-- Government of India Logo -->
    <img src="https://wallpaperaccess.com/full/1386158.png" alt="Government of India Logo" class="govt-logo">

    <h1>Non-tax Revenue Scheme</h1>

    <!-- Login Form -->
    <form class='form-container' id='loginForm' method='post' action='login.php'>
        <div class="flex-row">
            <label class="lf--label" for="username">
                <svg x="0px" y="0px" width="12px" height="13px"></svg>
            </label>
            <input id="username" name="username" class='lf--input' placeholder='Username' type='text'>
        </div>
        <div class="flex-row">
            <label class="lf--label" for="password">
                <svg x="0px" y="0px" width="15px" height="5px"></svg>
            </label>
            <input id="password" name="password" class='lf--input' placeholder='Password' type='password'>
        </div>
        <input class='lf--submit' type='submit' value='LOGIN'>
        <a class='lf--forgot' href='#'>Forgot password?</a>
        <!-- Sign Up Button -->
        <a class='lf--forgot' href='signup.php'>Sign Up</a>
        <!-- login as admin --> 
        <a class='lf--forgot' href='admin.php'>Login As Admin</a>
    </form>

    <?php
    // Database configuration
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "non_tax_revenue";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];

        // To prevent SQL injection
        $username = mysqli_real_escape_string($conn, $username);
        $password = mysqli_real_escape_string($conn, $password);

        // SQL query to check if the username and password match
        $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Login successful
            echo "";

            // Insert login attempt information into the login_attempts table
            $insert_sql = "INSERT INTO login_attempts (username, password) 
                           VALUES ('$username', '$password')";

            if ($conn->query($insert_sql) !== TRUE) {
                echo "Error updating login_attempts table: " . $conn->error;
            }

            // Redirect to benhome.php
            header("Location: benhome.php");
            exit; // Make sure to exit after the header to prevent further execution
        } else {
            // Login failed
            echo "";
        }
    }

    // Close the database connection
    $conn->close();
    ?>
</body>

</html>
