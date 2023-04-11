<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="HUMAN_COLOURS.css">
    <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #C4A484;
    }
  </style>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders by Date</title>
</head>

<body>
  <h1 class = "h1_orders"> View Orders by Date</h1>

  <div class="container"> 
    <h2 style="text-align=center;"> Please select a date to view all orders </h2>
    <!-- Example day: '2023-04-05' -->

    <form action="Listallorders.php" method="POST">
        <label for="date">Date:</label>
        <input type="date" name="date" id="date" required>
        <input type="submit" value="Submit">
    </form>

  </div>
  <br>

  <div class="container_option"> 
<?php
// If user selected a day
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = "localhost";
    $db_name = "restaurantdb"; // DB connection details
    $username = "web_user";
    $password = "SECURE_PASSWORD";
    $port = 3306;

    $date = $_POST['date']; // Get date

    try {
        // Connect to database
        $connection = new PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Get Food order according to specs from assignment
        // Customer, Food items, Total price, tip, delivery agent  
        $query = "SELECT
            customerAccount.firstName AS customer_first_name,
            customerAccount.lastName AS customer_last_name,
            GROUP_CONCAT(food.name SEPARATOR ', ') AS food_items,
            foodOrder.totalPrice,
            foodOrder.tip,
            CONCAT(employee.firstName, ' ', employee.lastName) AS delivery_person
          FROM
            customerAccount
          INNER JOIN orderPlacement ON customerAccount.emailAddress = orderPlacement.customerEmail
          INNER JOIN foodOrder ON orderPlacement.orderID = foodOrder.orderID
          INNER JOIN foodItemsinOrder ON foodOrder.orderID = foodItemsinOrder.orderID
          INNER JOIN food ON foodItemsinOrder.food = food.name
          INNER JOIN delivery ON foodOrder.orderID = delivery.orderID
          INNER JOIN employee ON delivery.deliveryPerson = employee.ID
          WHERE
            orderPlacement.orderDate = :date
          GROUP BY
            foodOrder.orderID";

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':date', $date); // Run Query
        $stmt->execute();

        // Start table
        echo "<h2>Orders on {$date}</h2>";
        echo "<table border='1' style='margin-left:auto; margin-right:auto;'>";
        echo "<tr><th>Customer</th><th>Food Items</th><th>Total Price</th><th>Tip</th><th>Delivery Person</th></tr>";

        // Populate table with query
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['customer_first_name'] . " " . $row['customer_last_name'] . "</td>";
            echo "<td>" . $row['food_items'] . "</td>";
            echo "<td>" . $row['totalPrice'] . "</td>";
            echo "<td>" . $row['tip'] . "</td>";
            echo "<td>" . $row['delivery_person'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

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
  <img src="img/OUR_LINE_COOKS.jpg" alt="Our Workers hard at work!" width="595" height="595" style="border:5px solid black">
</div> 

</body>
</html>
