<?php
include "db.php";

if (isset($_POST['update'])) {
    $Weather_Id = $_POST['Weather_Id'];
    $Date = $_POST['Date'];
    $Temperature_C = $_POST['Temperature_C'];
    $Rainfall_mm = $_POST['Rainfall_mm'];
    $farm_Id = $_POST['farm_Id'];

    $sqlup = "UPDATE `weather` 
              SET `Date`='$Date', 
                  `Temperature_C`='$Temperature_C', 
                  `Rainfall_mm`='$Rainfall_mm', 
                  `farm_Id`='$farm_Id' 
              WHERE `Weather_Id`='$Weather_Id'";

    $result = $conn->query($sqlup);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Weather record updated successfully.';
        echo '</div>';
        header("refresh:2; url=./weatherTableView.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $Weather_Id = $_GET['id'];

    $sql = "SELECT * FROM `weather` WHERE `Weather_Id`='$Weather_Id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Date = $row['Date'];
            $Temperature_C = $row['Temperature_C'];
            $Rainfall_mm = $row['Rainfall_mm'];
            $farm_Id = $row['farm_Id'];
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Weather Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Update Weather Record</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Weather Information:</legend>

            <input type="hidden" name="Weather_Id" value="<?php echo $Weather_Id; ?>">

            <div class="form-group">
                <label for="Date">Date:</label>
                <input type="date" class="form-control" name="Date" value="<?php echo $Date; ?>" required>
            </div>

            <div class="form-group">
                <label for="Temperature_C">Temperature (°C):</label>
                <input type="number" step="0.01" class="form-control" name="Temperature_C" value="<?php echo $Temperature_C; ?>" required>
            </div>

            <div class="form-group">
                <label for="Rainfall_mm">Rainfall (mm):</label>
                <input type="number" step="0.01" class="form-control" name="Rainfall_mm" value="<?php echo $Rainfall_mm; ?>" required>
            </div>

            <div class="form-group">
                <label for="farm_Id">Farm ID:</label>
                <input type="text" class="form-control" name="farm_Id" value="<?php echo $farm_Id; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Update" name="update">
            <a href="weatherTableView.php" class="btn btn-default">Back</a>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
    } else {
        header('Location: weatherTableView.php');
    }
}
?>
