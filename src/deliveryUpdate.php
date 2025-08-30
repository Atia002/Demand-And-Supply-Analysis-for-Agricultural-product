<?php
include "db.php";

// Update delivery record
if (isset($_POST['update'])) {
    $deliveryId = $_POST['deliveryId'];
    $date = $_POST['date'];
    $transportMode = $_POST['transportMode'];
    $status = $_POST['status'];
    $type = $_POST['type'];

    $sqlup = "UPDATE `delivery` 
              SET `Date`='$date', 
                  `TransportMode`='$transportMode', 
                  `Status`='$status', 
                  `Type`='$type' 
              WHERE `DeliveryID`='$deliveryId'";

    $result = $conn->query($sqlup);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Delivery record updated successfully.';
        echo '</div>';
        header("refresh:2; url=deliveryView.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

// Get delivery record by ID
if (isset($_GET['id'])) {
    $deliveryId = $_GET['id'];

    $sql = "SELECT * FROM `delivery` WHERE `DeliveryID`='$deliveryId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row['Date'];
            $transportMode = $row['TransportMode'];
            $status = $row['Status'];
            $type = $row['Type'];
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Delivery Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Update Delivery Record</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Delivery Information:</legend>

            <input type="hidden" name="deliveryId" value="<?php echo $deliveryId; ?>">

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" class="form-control" name="date" value="<?php echo $date; ?>" required>
            </div>

            <div class="form-group">
                <label for="transportMode">Transport Mode:</label>
                <input type="text" class="form-control" name="transportMode" value="<?php echo $transportMode; ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status:</label>
                <input type="text" class="form-control" name="status" value="<?php echo $status; ?>" required>
            </div>

            <div class="form-group">
                <label for="type">Type:</label>
                <input type="text" class="form-control" name="type" value="<?php echo $type; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Update" name="update">
            <a href="deliveryView.php" class="btn btn-default">Back</a>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
    } else {
        header('Location: deliveryView.php');
    }
}
?>
