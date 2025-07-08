<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="https://th.bing.com/th?id=ODLS.d9532277-73d9-4783-9a31-2ec29acfea2e&w=32&h=32&qlt=90&pcl=fffffa&o=6&cb=1028&pid=1.2" type="image/png">
    <title>Finance Portal</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background: #D6EAF8; /* Soft blue background */
            color: #2c3e50; /* Dark gray text color */
        }

        .navbar {
            background-color: #001f3f; /* Blue navbar background */
            color: white; /* White font color */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            padding: 10px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .topics {
            display: flex;
            margin-right: 20px;
        }

        .topic {
            position: relative;
            display: inline-block;
            padding: 20px;
            font-size: 18px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .topic-name {
            cursor: pointer;
        }

        .topic-name:hover {
            color: #ecf0f5; /* Text color on hover */
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #001F3F;
            min-width: 160px;
            z-index: 1;
            color: white;
            font-family: sans-serif;
            font-size: 17px;
        }

        .contents:hover {
            background-color: #D6EAF8;
            color: #2c3e50;
        }

        .topic:hover .dropdown-content {
            display: block;
        }

        .content {
            margin-top: 80px;
            padding: 20px;
            text-align: center;
            flex-direction: column;
        }

        .about {
            padding: 70px;
            color: #2c3e50;
            font-size: 24px;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .image1:hover {
            transform: scale(1.1);
        }
        .contents {
    margin-top: 10px; /* Adjusted margin for more space between navbar and content */
    padding: 2px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center; /* Center the content horizontally */
}

a {
    padding: 20px; /* Increased padding for better spacing */
    color: White;
    font-size: 16px;
    font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    text-decoration: none;
}
    </style>
</head>

<body>

    <div class="navbar">
        <div class="menu-icon">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTrATKgX0NZyNTc5BO6qyuXxXX-rE37Mx9wHA&usqp=CAU" alt="logo" style="height: 60px;">
        </div>
        <div class="navbar-logo"></div>
        <div class="topics">
            <div class="topic top">
                <span class="topic-name " style=""><a href="http://localhost/dbms/revenuesources.php">REVENUE SOURCES</a></span>
            </div>
            <div class="topic top">
                <span class="topic-name "><a href="http://localhost/dbms/schemes.php">SCHEMES</a></span>
            </div>
            <div class="topic top">
                <span class="topic-name"><a href="http://localhost/dbms/department.php">DEPARTMENTS</a></span>
            </div>
            <div class="topic top">
                <span class="topic-name" style="margin-right: 20px;">MORE..</span>
                <div class="dropdown-content">
                    <a href="http://localhost/dbms/benificiary.php?scheme=C" class="contents">Beneficiaries</a>
                    <a href="http://localhost/dbms/legislation.php" class="contents">Legislation</a>
                    <a href="http://localhost/dbms/outcome.php" class="contents">Outcomes</a>
                    <a href="http://localhost/dbms/report.php" class="contents">Reports</a>
                    <a href="http://localhost/dbms/document.php" class="contents">Documents</a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="image">
            <img src="https://img.freepik.com/free-vector/startup-managers-presenting-analyzing-sales-growth-chart-group-workers-with-heap-cash-rocket-bar-diagrams-with-arrow-heap-money_74855-14166.jpg?size=626&ext=jpg&ga=GA1.1.1548777004.1684316087&semt=sph" height="550" width="900" style="border-radius: 50%; margin-top: 50px; box-shadow: 0 0 10px #ecf0f5;"
                class="image1">
        </div>
        <div class="about">
            <h2 style="color: #001f3f;">
                ABOUT:
            </h2>
            <p>The "Scheme-wise Non-Tax Revenue Analysis under Union Budget" involves the creation of a sophisticated Database Management System (DBMS) designed to effectively store, manage, and analyze data related to non-tax revenue schemes within the Union Budget for fiscal years 2021-22 to 2023-24. The primary objective of this is to establish a user-friendly platform that facilitates easy retrieval and assessment of scheme-wise non-tax revenue data, ultimately enhancing decision-making processes and providing deeper insights into revenue patterns.</p>
        </div>
    </div>

    <script>
        // Add JavaScript functionality here, if needed
    </script>
</body>

</html>