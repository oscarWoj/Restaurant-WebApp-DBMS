<!DOCTYPE html>
<html lang="en">
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
    <h1 class=h1_orders>LISTING HAPPY EMPLOYEES</h1>
    <div class="container_option">

    <form action="getSchedule.php" method="POST">  <!--  Selecting an employee will take you to a new page -->
        <?php
        $host = "localhost";
        $db_name = "restaurantdb"; // Db connection details
        $username = "web_user";
        $password = "SECURE_PASSWORD";
        $port = 3306;

        try {
            //Connect
            $connection = new PDO("mysql:host=$host;dbname=$db_name;port=$port", $username, $password);
            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $query = "SELECT ID, firstName, lastName FROM employee";
            $result = $connection->prepare($query);
            $result->execute();

            // Show employees as radio buttons
            echo "SEPERATING INSTANCES: </br>";
            while ($row = $result->fetch()) {
            echo '<input type="radio" name="employee" value="';
            echo $row['ID'];
            echo '"> '.$row["firstName"]." ".$row["lastName"]."<br>";
            }
        
        } catch (PDOException $e) {
            echo "Error";
            echo "Error!: ". $e->getMessage(). "<br/>";
            die();
        }

        $connection = null; // End connection
        ?>

        <input type="submit" value = "ADOPT EMPLOYEE">
        </form>
    </div>

    <br>
    <div class="container_option">
        <h2> WE WILL MAKE EVERY EFFORT TO MAKE YOUR ORDER PALATABLE<h2>
    </div>
</body>
</html>