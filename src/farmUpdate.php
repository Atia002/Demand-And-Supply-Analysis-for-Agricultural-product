<?php
include "db.php";

if (isset($_POST['update'])) {
    $farmId = $_POST['farmId'];
    $address = $_POST['address'];
    $farmerId = $_POST['farmerId'];

    $sqlup = "UPDATE `farm` 
              SET `Address`='$address', 
                  `Farmer_Id`='$farmerId' 
              WHERE `Farm_Id`='$farmId'";

    $result = $conn->query($sqlup);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Farm record updated successfully.';
        echo '</div>';
        header("refresh:2; url=./farmTableView.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $farmId = $_GET['id'];

    $sql = "SELECT * FROM `farm` WHERE `Farm_Id`='$farmId'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $address = $row['Address'];
            $farmerId = $row['Farmer_Id'];
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Farm Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Update Farm Record</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Farm Information:</legend>

            <input type="hidden" name="farmId" value="<?php echo $farmId; ?>">

            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" name="address" value="<?php echo $address; ?>" required>
            </div>

            <div class="form-group">
                <label for="farmerId">Farmer ID:</label>
                <input type="text" class="form-control" name="farmerId" value="<?php echo $farmerId; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Update" name="update">
            <a href="farmTableView.php" class="btn btn-default">Back</a>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
    } else {
        header('Location: farmTableView.php');
    }
}
?>
