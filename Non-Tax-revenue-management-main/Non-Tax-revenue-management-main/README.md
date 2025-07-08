# Non-Tax Revenue Management System

## Project Overview

This project is a web-based "Non-Tax Revenue Management System" designed to help government departments efficiently track, manage, and report on non-tax revenue sources. It provides functionalities for managing departments, revenue inflows, schemes, beneficiaries, and relevant legislative and outcome data.

**Key Aims and Capabilities:**

*   **Financial Tracking:** Monitor how much non-tax revenue is generated from various sources.
*   **Departmental Revenue Tracking:** Understand the amount of money collected by each department.
*   **Scheme Management:** Keep track of different government schemes, their budgets, and associated details.
*   **Beneficiary Management:** Record and manage information about beneficiaries applying for or receiving benefits from schemes.
*   **Legislation & Outcome Tracking:** Link specific legislations and outcomes to relevant schemes for better accountability and reporting.

## Key Features

*   **User Authentication:** Secure login and signup for different roles (admin, beneficiary, department).
*   **Department Management:** View, add, and manage departments, with automated tracking of collected revenue.
*   **Revenue Source Management:** Add, edit, and delete various non-tax revenue sources, specifying the amount generated and the allocated department.
*   **Scheme Management:** Create, view, and manage government schemes, including their descriptions, budgets, and associated departments.
*   **Legislation & Outcome Tracking:** Record and update legislation and outcome details for each scheme.
*   **Beneficiary Details:** Display beneficiary information, potentially filtered by scheme.
*   **Dynamic Data Updates:** Database interactions for real-time data management.

## Database Schema (SQL)

The database for this project is built using MySQL. The schema is designed to store all the necessary information for managing non-tax revenues, departments, schemes, users, and beneficiaries.

**Visual Schema:**
For a visual representation of the database schema and relationships, please refer to the `dbms.dia` file located in the `Non-Tax-revenue-management/DBMS/` directory. You will need a diagramming tool like Dia Diagram Editor to open this file.

**SQL Code for Database Setup:**

Below is the complete SQL script to create the `non_tax_revenue` database and all its necessary tables with the relevant attributes and foreign key relationships.

```sql
-- Create the database
CREATE DATABASE IF NOT EXISTS non_tax_revenue;
USE non_tax_revenue;

-- Users table (for user authentication and management)
CREATE TABLE users (
    username VARCHAR(50) PRIMARY KEY,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(15),
    aadhaar VARCHAR(12),
    bank_acc VARCHAR(20),
    ifsc_code VARCHAR(11)
);

-- Login attempts table (to log login activities)
CREATE TABLE login_attempts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50),
    password VARCHAR(255),
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (username) REFERENCES users(username)
);

-- Departments table (to manage government departments and their collected amounts)
CREATE TABLE departments (
    name VARCHAR(100) PRIMARY KEY,
    amount_collected DECIMAL(15,2) DEFAULT 0.00,
    description TEXT
);

-- Revenue Sources table (to track various non-tax revenue sources)
CREATE TABLE revenue_sources (
    id INT PRIMARY KEY AUTO_INCREMENT,
    revenue_source VARCHAR(100) NOT NULL,
    amount_generated DECIMAL(15,2) NOT NULL,
    allocated_department VARCHAR(100),
    FOREIGN KEY (allocated_department) REFERENCES departments(name)
);

-- Scheme table (to manage different government schemes)
CREATE TABLE scheme (
    scheme_id INT PRIMARY KEY AUTO_INCREMENT,
    scheme_name VARCHAR(100) UNIQUE NOT NULL, -- UNIQUE to allow linking by name in beneficiary table
    scheme_description TEXT,
    scheme_budget DECIMAL(15,2),
    scheme_department VARCHAR(100),
    document TEXT, -- Path or reference to scheme-related documents
    FOREIGN KEY (scheme_department) REFERENCES departments(name)
);

-- Legislation table (to store legislation details for schemes)
CREATE TABLE legislation (
    legislation_id INT PRIMARY KEY AUTO_INCREMENT,
    scheme_id INT NOT NULL,
    legislation_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (scheme_id) REFERENCES scheme(scheme_id)
);

-- Outcome table (to store outcome details for schemes)
CREATE TABLE outcome (
    outcome_id INT PRIMARY KEY AUTO_INCREMENT,
    scheme_id INT NOT NULL,
    outcome_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (scheme_id) REFERENCES scheme(scheme_id)
);

-- Beneficiary table (to manage beneficiary information)
CREATE TABLE beneficiary (
    beneficiary_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    age INT,
    scheme_name VARCHAR(100), -- Referenced for display in Benificiary.php
    location VARCHAR(100),
    locality VARCHAR(100),
    house_no VARCHAR(50),
    state VARCHAR(50),
    phone_numbers VARCHAR(50),
    FOREIGN KEY (scheme_name) REFERENCES scheme(scheme_name)
);

-- Initial Data Inserts (Optional)
INSERT INTO departments (name, description) VALUES
('Education', 'Education Department'),
('Agriculture', 'Agriculture Department'),
('Service', 'Service Department'),
('Industrial', 'Industrial Department');

INSERT INTO users (username, password, email) VALUES
('admin', 'admin123', 'admin@example.com'); -- IMPORTANT: In a production environment, always hash passwords!
```

## Setup Instructions

Follow these steps to set up the Non-Tax Revenue Management System:

### 1. Database Setup (MySQL via phpMyAdmin)

1.  **Start your MySQL Server:** Ensure your MySQL server (e.g., via XAMPP, WAMP, MAMP, or a standalone MySQL installation) is running.
2.  **Access phpMyAdmin:** Open your web browser and navigate to `http://localhost/phpmyadmin` (or the address where your phpMyAdmin is hosted).
3.  **Drop Existing Database (Optional but Recommended):** If you have a previous `non_tax_revenue` database, it's best to drop it for a clean start.
    *   Select `non_tax_revenue` from the left sidebar.
    *   Go to the "Operations" tab.
    *   Click "Drop the database (DROP)" and confirm.
4.  **Create New Database:**
    *   Click on "New" in the left sidebar.
    *   In the "Database name" field, type `non_tax_revenue`.
    *   Click the "Create" button.
5.  **Import SQL Schema:**
    *   Select the newly created `non_tax_revenue` database from the left sidebar.
    *   Click on the "SQL" tab in the main panel.
    *   Copy the entire SQL code provided in the "SQL Code for Database Setup" section above.
    *   Paste the copied SQL code into the query box.
    *   Click the "Go" button to execute the script. This will create all tables and insert initial data.

### 2. Application Setup

1.  **Locate PHP Files:** The core PHP application files are located in `Non-Tax-revenue-management/DBMS/`.
2.  **Update Database Connection Details:**
    *   Open each of the following PHP files in your code editor:
        *   `Non-Tax-revenue-management/DBMS/department.php`
        *   `Non-Tax-revenue-management/DBMS/revenuesources.php`
        *   `Non-Tax-revenue-management/DBMS/login.php`
        *   `Non-Tax-revenue-management/DBMS/signup.php`
        *   `Non-Tax-revenue-management/DBMS/Benificiary.php`
        *   `Non-Tax-revenue-management/DBMS/schemes.php`
        *   `Non-Tax-revenue-management/DBMS/legislation.php`
        *   `Non-Tax-revenue-management/DBMS/outcome.php`
    *   In each file, locate the database connection variables (e.g., `$host`, `$username`, `$password`, `$database`).
    *   **Crucially, ensure the `password` variable is set to the actual password for your MySQL `root` user or the database user you created.** If you're using XAMPP/WAMP default setup, it's often an empty string (`''`).
    ```php
    // Example from your PHP files
    $host = 'localhost';
    $username = 'root';
    $password = ''; // <--- Update this if your MySQL root has a password
    $database = 'non_tax_revenue';
    ```
    *   **Note:** If you moved `legislation` and `outcome` into separate tables, you will need to manually modify `legislation.php` and `outcome.php` to perform `INSERT`/`SELECT` operations on the new `legislation` and `outcome` tables instead of updating columns in the `scheme` table. This `README` assumes the database schema provided, which includes these as separate tables.
3.  **Place Project Files on Web Server:**
    *   Copy the entire `Non-Tax-revenue-management` folder.
    *   Paste it into your web server's document root directory. For XAMPP, this is typically `htdocs` (e.g., `C:\xampp\htdocs\`).
    *   After copying, the path to your main application files should look something like `C:\xampp\htdocs\Non-Tax-revenue-management\DBMS\`.

### 3. Running the Application

1.  **Start your Web Server:** Ensure your Apache web server (e.g., via XAMPP, WAMP, MAMP) is running.
2.  **Access the Application:** Open your web browser and navigate to:
    `http://localhost/Non-Tax-revenue-management/DBMS/login.php` (for the login page)
    or
    `http://localhost/Non-Tax-revenue-management/DBMS/signup.php` (for the signup page).

You should now be able to interact with the Non-Tax Revenue Management System.

## Technologies Used

*   **Backend:** PHP
*   **Database:** MySQL
*   **Frontend:** HTML, CSS, JavaScript (basic)
*   **Database Management:** phpMyAdmin

## Future Enhancements

*   **Password Hashing:** Implement strong password hashing (e.g., `password_hash()` in PHP) for user passwords instead of plain text storage or simple string matching.
*   **Improved Error Handling:** Implement more robust error handling and user feedback.
*   **Security:** Add more security measures against SQL injection (using prepared statements consistently) and XSS attacks.
*   **User Roles & Permissions:** Implement a more granular role-based access control system.
*   **Advanced Reporting:** Develop more sophisticated reporting functionalities and data visualization.
*   **User Interface:** Enhance the overall user interface and experience with modern design principles.
*   **Modularity:** Refactor the PHP code for better organization and reusability. 