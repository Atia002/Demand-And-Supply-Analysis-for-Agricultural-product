<?php
include "db.php";

// Correct SQL query
$sql = "SELECT 'Weather_Id' AS weatherId, Date, 'Temperature_C' AS temperatureC ,Rainfall_mm , farm_Id FROM weather";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Weather Data</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Weather Records</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Weather_Id</th>
                    <th>Date</th>
                    <th>Temperature (°C)</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['weatherId']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['temperatureC']; ?></td>
                            <td>
                                <a class="btn btn-info" href="weatherUpdate.php?id=<?php echo $row['weatherId']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="weatherDelete.php?id=<?php echo $row['weatherId']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php   
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a style="color:black;" class="btn btn-warning" href="weatherAdd.php"><b>Add Weather</b></a>
    </div>
</body>
</html>
