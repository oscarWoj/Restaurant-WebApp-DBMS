<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="HUMAN_COLOURS.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Schedules</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #C4A484;
        }
    </style>
</head>

<body>
    <?php
    try {
        // Make connection
        $host = "localhost";
        $db_name = "restaurantdb";
        $username = "web_user";
        $password = "SECURE_PASSWORD";
        $port = 3306;

        $connection = new PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $employeeID = $_POST["employee"];

        // Get Employee Name

        $queryName = "SELECT firstName, lastName FROM employee where ID = :employeeID";
        $resultName = $connection->prepare($queryName);
        $resultName->bindParam(':employeeID', $employeeID);
        $resultName->execute();

        $name = $resultName -> fetch();
        echo " <h1 class=h1_orders>Displaying Schedule for ".$name["firstName"]." ".$name["lastName"]."</h1>";
    
        // Get Employee Shifts
        $query = "SELECT day, startTime, endTime FROM shift 
                WHERE empID = :employeeID AND day IN ('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday') 
                ORDER BY FIELD(day, 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday')"; // Show logically

        $stmt = $connection->prepare($query);
        $stmt->bindParam(':employeeID', $employeeID);
        $stmt->execute();

        // Display employee shift
        echo "<div class='container_option'>";
        echo "<table border='1' style='margin-left:auto; margin-right:auto;'>";
        echo "<tr><th>Day</th><th>Start Time</th><th>End Time</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr><td>" . $row['day'] . "</td><td>" . $row['startTime'] . "</td><td>" . $row['endTime'] . "</td></tr>";
        }
        echo "</table>";
        echo "</div><br>";

    } catch (PDOException $e) { // Database error
        echo "Error";
        echo "Error!: ". $e->getMessage(). "<br/>";
	    die();
    }
    $connection = NULL; // End connection
    ?>

    <div class="container_option">
        <h2> ALL REFUND REQUESTS WILL BE RETURNED A NULL VALUE<h2>
    </div>
</body>
</html>