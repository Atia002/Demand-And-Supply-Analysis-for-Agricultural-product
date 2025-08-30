<?php
include "db.php";

// Check if the update button is pressed
if (isset($_POST['update'])) {

    // Get form data
    $storeType = $_POST['StoreType'];  // Field for storeType

    // Get the retailer's LicenseId or another identifier for update
    $licenseId = $_POST['user_LicenseId'];

    // SQL query to update the retailer table
    $sqlup = "UPDATE `retailer` 
              SET `storeType`='$storeType' 
              WHERE `LicenseId`='$licenseId'";

    // Execute the query
    $result = $conn->query($sqlup);

    // Check if the query was successful
    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Record updated successfully.');</script>";
        header("refresh:2; url=./retailerTableView.php"); // Redirect after 2 seconds
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

// Check if 'LicenseId' is passed in the URL for updating a specific retailer record
if (isset($_GET['LicenseId'])) {
    $licenseId = $_GET['LicenseId'];

    // SQL query to fetch the retailer record from the retailer table
    $sql = "SELECT * FROM `retailer` WHERE `LicenseId`='$licenseId'";
    $result = $conn->query($sql);

    // If the record exists, populate the form with the existing data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $storeType = $row['storeType'];  // The storeType field in retailer
        }
?>

<!-- HTML form for updating the retailer record -->
<html>
<head>
    <title>Retailer Update Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Update Retailer Record</h2>

        <form action="" method="post">
            <fieldset>
                <legend>Retailer Information:</legend>

                <!-- Hidden field to pass the LicenseId -->
                <input type="hidden" name="user_LicenseId" value="<?php echo $licenseId; ?>">

                <div class="form-group">
                    <label for="StoreType">Store Type:</label>
                    <input type="text" class="form-control" name="StoreType" value="<?php echo $storeType; ?>" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Update" name="update">
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php
    } else {
        header('Location: retailerTableView.php'); // Redirect if no record is found
    }
}
?>
