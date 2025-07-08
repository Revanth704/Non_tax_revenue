<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="signup-styles.css">
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

  <!-- Signup Form -->
  <form class='form-container signup' id='signupForm' method='post' action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>'>
    <div class="flex-row">
      <label class="lf--label" for="signup-username">
        <svg x="0px" y="0px" width="12px" height="13px"></svg>
      </label>
      <input id="signup-username" name="signup-username" class='lf--input' placeholder='Username' type='text'>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-email">
        <svg x="0px" y="0px" width="12px" height="13px"></svg>
      </label>
      <input id="signup-email" name="signup-email" class='lf--input' placeholder='Email' type='email'>
      <span class="error-message" id="email-error"></span>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-phone">
        <svg x="0px" y="0px" width="12px" height="13px"></svg>
      </label>
      <input id="signup-phone" name="signup-phone" class='lf--input' placeholder='Phone Number' type='text'>
      <span class="error-message" id="phone-error"></span>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-aadhaar">
        <svg x="0px" y="0px" width="12px" height="13px"></svg>
      </label>
      <input id="signup-aadhaar" name="signup-aadhaar" class='lf--input' placeholder='Aadhaar Number' type='text'>
      <span class="error-message" id="aadhaar-error"></span>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-age"></label>
      <input id="signup-age" name="signup-age" class='lf--input' placeholder='Age' type='date'>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-bank-acc">
        <svg x="0px" y="0px" width="12px" height="13px"></svg>
      </label>
      <input id="signup-bank-acc" name="signup-bank-acc" class='lf--input' placeholder='Bank Account Number' type='text'>
      <span class="error-message" id="bank-acc-error"></span>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-ifsc-code">
        <svg x="0px" y="0px" width="12px" height="13px"></svg>
      </label>
      <input id="signup-ifsc-code" name="signup-ifsc-code" class='lf--input' placeholder='IFSC Code' type='text'>
      <span class="error-message" id="ifsc-code-error"></span>
    </div>
    <div class="flex-row">
      <label class="lf--label" for="signup-password">
        <svg x="0px" y="0px" width="15px" height="5px"></svg>
      </label>
      <input id="signup-password" name="signup-password" class='lf--input' placeholder='Password' type='password'>
    </div>
    <input class='lf--submit' type='submit' value='SIGN UP'>
    <a class='lf--forgot' href="login.php" id="loginButton">Already have an account? Login here</a>
  </form>

  <?php
  // Connect to MySQL database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "non_tax_revenue";

  $conn = new mysqli($servername, $username, $password, $dbname);

  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  // Handle form submission
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $username = $_POST["signup-username"];
      $pas = $_POST["signup-password"];
      $email = $_POST["signup-email"];
      $phone = $_POST["signup-phone"];
      $aadhaar = $_POST["signup-aadhaar"];
      $bankAcc = $_POST["signup-bank-acc"];
      $ifscCode = $_POST["signup-ifsc-code"];

      // Insert data into the database
      $sql = "INSERT INTO users (username, password, email, phone, aadhaar, bank_acc, ifsc_code) 
              VALUES ('$username', '$pas', '$email', '$phone', '$aadhaar', '$bankAcc', '$ifscCode')";

      if ($conn->query($sql) === TRUE) {
          echo "User registered successfully!";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }
  }

  $conn->close();
  ?>


</body>

</html>
