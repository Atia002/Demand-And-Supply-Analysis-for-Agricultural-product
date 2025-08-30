<?php
include "db.php";

if (isset($_POST['submit'])) {

    $storageID = $_POST['storageID'];
    $ColdStorageCapacity = $_POST['ColdStorageCapacity'];
    $Address = $_POST['Address'];
    $productType = $_POST['productType'];
    $StockLevel = $_POST['StockLevel'];

    // Insert query
    $sql = "INSERT INTO `storage` (`storageID`, `ColdStorageCapacity`, `Address`, `productType`, `StockLevel`) 
            VALUES ('$storageID', '$ColdStorageCapacity', '$Address', '$productType', '$StockLevel')";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success">New storage record added successfully!</div>';
        echo "<script>setTimeout(function(){ window.location.href='storageList.php'; }, 2000);</script>";
    } else {
        echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Storage</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Add Storage</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="storageID">Storage ID:</label>
            <input type="text" class="form-control" name="storageID" id="storageID" required>
        </div>

        <div class="form-group">
            <label for="ColdStorageCapacity">Cold Storage Capacity:</label>
            <input type="number" step="0.01" class="form-control" name="ColdStorageCapacity" id="ColdStorageCapacity" required>
        </div>

        <div class="form-group">
            <label for="Address">Address:</label>
            <input type="text" class="form-control" name="Address" id="Address" required>
        </div>

        <div class="form-group">
            <label for="productType">Product Type:</label>
            <input type="text" class="form-control" name="productType" id="productType" required>
        </div>

        <div class="form-group">
            <label for="StockLevel">Stock Level:</label>
            <input type="number" step="0.01" class="form-control" name="StockLevel" id="StockLevel" required>
        </div>

        <input type="submit" name="submit" value="Add Storage" class="btn btn-primary">
        <a href="storageList.php" class="btn btn-default">Back</a>
    </form>
</div>
</body>
</html>
