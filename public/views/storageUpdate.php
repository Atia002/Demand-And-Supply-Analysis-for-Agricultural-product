<?php
include "db.php";

if (isset($_POST['update'])) {

    $storageID = $_POST['user_storageID'];
    $ColdStorageCapacity = $_POST['ColdStorageCapacity'];
    $Address = $_POST['Address'];
    $productType = $_POST['productType'];
    $StockLevel = $_POST['StockLevel'];

    $sqlup = "UPDATE `storage` 
              SET `ColdStorageCapacity`='$ColdStorageCapacity', `Address`='$Address', `productType`='$productType', `StockLevel`='$StockLevel' 
              WHERE `storageID`='$storageID'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Storage record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Storage record updated successfully.');</script>";
        header("refresh:2; url=./storageList.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $storageID = $_GET['id'];

    $sql = "SELECT * FROM `storage` WHERE `storageID`='$storageID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $ColdStorageCapacity = $row['ColdStorageCapacity'];
            $Address = $row['Address'];
            $productType = $row['productType'];
            $StockLevel = $row['StockLevel'];
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Storage Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Update Storage Record</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Storage Information:</legend>

            <input type="hidden" name="user_storageID" value="<?php echo $storageID; ?>">

            <div class="form-group">
                <label for="ColdStorageCapacity">Cold Storage Capacity:</label>
                <input type="number" step="0.01" class="form-control" name="ColdStorageCapacity" value="<?php echo $ColdStorageCapacity; ?>" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>" required>
            </div>

            <div class="form-group">
                <label for="productType">Product Type:</label>
                <input type="text" class="form-control" name="productType" value="<?php echo $productType; ?>" required>
            </div>

            <div class="form-group">
                <label for="StockLevel">Stock Level:</label>
                <input type="number" step="0.01" class="form-control" name="StockLevel" value="<?php echo $StockLevel; ?>" required>
            </div>

            <input type="submit" class="btn btn-primary" value="Update" name="update">
            <a href="storageList.php" class="btn btn-default">Back</a>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
    } else {
        header('Location: storageList.php');
    }
}
?>
