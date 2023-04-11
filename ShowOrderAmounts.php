<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="HUMAN_COLOURS.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Summaries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C4A484;
        }
    </style>
</head>

<body>
    <h1 class=h1_orders>Order Summaries by Date</h1>
    
    <div class="container_option">
        <?php
        $host = "localhost";
        $db_name = "restaurantdb";
        $username = "web_user"; // Connection Details
        $password = "SECURE_PASSWORD";
        $port = 3306;

        try { // Try to connect
            $connection = new PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Get number of orders for each date
            $query = "SELECT orderPlacement.orderDate AS order_date, COUNT(*) AS order_count
                      FROM orderPlacement
                      GROUP BY orderPlacement.orderDate
                      ORDER BY orderPlacement.orderDate ASC";

            $stmt = $connection->prepare($query);
            $stmt->execute();

            // Display in a table
            echo "<table border='1' style='margin-left:auto; margin-right:auto;'>";
            echo "<tr><th>Date</th><th>Number of Orders</th></tr>";

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['order_date'] . "</td>";
                echo "<td>" . $row['order_count'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";

        } catch (PDOException $e) {
            echo "Error";
            echo "Error!: ". $e->getMessage(). "<br/>";
            die();
        }

        $connection = null;
        ?>
    </div>
    <br>
    <div class="container_option">
        <h2> PLEASE DO NOT ASK EMPLOYEES QUESTIONS THAT MAY INCREASE SELF-AWARENESS<h2>
    </div>
</body>
</html>
