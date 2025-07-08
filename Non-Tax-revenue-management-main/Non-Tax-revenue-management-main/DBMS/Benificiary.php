<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficiary Page</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 20px;
            background-color: #D6EAF8;
        }
        h1, h2 {
            position: relative;
            text-align: center;
            color: white;
            background: linear-gradient(90deg, #001f3f, #001f3f 50%, transparent 50%, transparent);
            background-size: 200% 100%;
            animation: gradient-scroll 5s linear infinite;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
            display: inline-block;
            margin-bottom: 20px;
        }
        h1::after, h2::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: -2px;
            height: 2px;
            background-color: #001f3f;
        }
        @keyframes gradient-scroll {
            0% {
                background-position: 100% 0;
            }
            100% {
                background-position: -100% 0;
            }
        }
        #scheme-dropdown, #beneficiary-details {
            margin-top: 30px;
            text-align: center;
        }
        #scheme-dropdown label, #beneficiary-details label {
            display: block;
            margin-bottom: 5px;
            color: #495057;
        }

        #scheme-select {
            width: 200px;
            padding: 8px;
            border: 1px solid #ced4da;
            border-radius: 4px;
            box-sizing: border-box;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #001f3f;
            color: white;
        }
    </style>
</head>
<body>

    <?php
    // Replace these variables with your actual database credentials
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

    // Dummy data for schemes
    $schemes = ['A', 'B', 'C', 'D'];

    // Check if a scheme is selected
    $selectedScheme = isset($_GET['scheme']) ? $_GET['scheme'] : null;
    ?>

    <h1>Beneficiary Page</h1>
    <a href="home.php" class="button" style="top: 85px;float:right;"><button>Homepage</button></a>
    <div id="scheme-dropdown">
        <form action="" method="get">
            <label for="scheme-select">Select Scheme:</label>
            <select id="scheme-select" name="scheme" onchange="this.form.submit()">
                <option value="" <?php echo empty($selectedScheme) ? 'selected' : ''; ?>>All Schemes</option>
                <?php
                // Generate options for schemes
                foreach ($schemes as $scheme) {
                    $selected = ($selectedScheme == $scheme) ? 'selected' : '';
                    echo "<option value=\"$scheme\" $selected>$scheme</option>";
                }
                ?>
            </select>
        </form>
    </div>

    <div id="beneficiary-details">
        <h2>Beneficiary Details</h2>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Scheme Name</th>
                    <th>Location</th>
                    <th>Locality</th>
                    <th>House No</th>
                    <th>State</th>
                    <th>Phone Numbers</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Display beneficiary details based on the selected scheme
                $sql = "SELECT * FROM beneficiary";
                if (!empty($selectedScheme)) {
                    $sql .= " WHERE scheme_name = '$selectedScheme'";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['name']}</td>";
                        echo "<td>{$row['age']}</td>";
                        echo "<td>{$row['scheme_name']}</td>";
                        echo "<td>{$row['location']}</td>";
                        echo "<td>{$row['locality']}</td>";
                        echo "<td>{$row['house_no']}</td>";
                        echo "<td>{$row['state']}</td>";
                        echo "<td>{$row['phone_numbers']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8'>No beneficiaries found</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

</body>
</html>
