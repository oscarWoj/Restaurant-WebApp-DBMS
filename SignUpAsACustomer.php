<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="HUMAN_COLOURS.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C4A484;
        }
    </style>
</head>

<body>
    <!-- Form with all details needed to create a customer -->
    <h1 class=h1_orders>JOIN US HUMAN</h1>
    <div class="container_option">
    <form action="SignUpAsACustomer.php" method="POST">
        <label for="emailAddress">Email Address:</label>
        <input type="email" name="emailAddress" id="emailAddress" required>
        <br>
        <label for="firstName">First Name:</label>
        <input type="text" name="firstName" id="firstName" required>
        <br>
        <label for="lastName">Last Name:</label>
        <input type="text" name="lastName" id="lastName" required>
        <br>
        <label for="cellNum">Cell Number:</label>
        <input type="tel" name="cellNum" id="cellNum" required>
        <br>
        <label for="streetAddress">Street Address:</label>
        <input type="text" name="streetAddress" id="streetAddress" required>
        <br>
        <label for="city">City:</label>
        <input type="text" name="city" id="city" required>
        <br>
        <label for="pc">Postal Code:</label>
        <input type="text" name="pc" id="pc" required>
        <br>
        <input type="submit" value="Sign Up">
    </form>
    </div>
<br>
<div class="container_option">

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $db_name = "restaurantdb";
    $username = "web_user"; // Db connection details
    $password = "SECURE_PASSWORD";
    $port = 3306;

    $emailAddress = $_POST['emailAddress'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $cellNum = $_POST['cellNum']; // Passing on values from form
    $streetAddress = $_POST['streetAddress'];
    $city = $_POST['city'];
    $pc = $_POST['pc'];
    $creditAmt = 5.00;

    try {
        $connection = new PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT emailAddress FROM customerAccount WHERE emailAddress = :emailAddress";
        $stmt = $connection->prepare($query);
        $stmt->bindParam(':emailAddress', $emailAddress);
        $stmt->execute();

        if ($stmt->rowCount() > 0) { // Customer exists
            echo "<h2>Error: A customer with this email address already exists.</h2>";

          } else { // Add Customer
            $query = "INSERT INTO customerAccount (emailAddress, firstName, lastName, cellNum, streetAddress, city, pc, creditAmt)
                      VALUES (:emailAddress, :firstName, :lastName, :cellNum, :streetAddress, :city, :pc, :creditAmt)";
            $stmt = $connection->prepare($query);
            $stmt->bindParam(':emailAddress', $emailAddress);
            $stmt->bindParam(':firstName', $firstName);
            $stmt->bindParam(':lastName', $lastName);
            $stmt->bindParam(':cellNum', $cellNum);
            $stmt->bindParam(':streetAddress', $streetAddress);
            $stmt->bindParam(':city', $city);
            $stmt->bindParam(':pc', $pc);
            $stmt->bindParam(':creditAmt', $creditAmt);

            $stmt->execute();

            echo "<h2>Successfully added: <br>{$emailAddress}</h2>";
            }

    } catch (PDOException $e) {
        echo "Error";
        echo "Error!: ". $e->getMessage(). "<br/>";
        die();
    }
    $connection = null;
    }
    ?>

  </div>

  <br>
  <div class="container_option" stlye> 
  <img src="img/ONEOFUSONEOFUS.jpg" alt="NOTHING TO WORRY ABOUT" width="595" height="595" style="border:5px solid black">
  </div> 
  
</body>
</html>