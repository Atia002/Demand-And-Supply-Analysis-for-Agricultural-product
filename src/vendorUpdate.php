<?php
include "db.php";

// Check if the update button is pressed
if (isset($_POST['update'])) {

    // Get the form data
    $licenseId = $_POST['LicenseId'];
    $name = $_POST['Name'];
    $address = $_POST['Address'];
    $regDate = $_POST['RegDate'];
    $vendorType = $_POST['VendorType'];

    // SQL query to update the vendor table
    $sqlup = "UPDATE `vendor` 
              SET `Name`='$name', `Address`='$address', `RegDate`='$regDate', `VendorType`='$vendorType' 
              WHERE `LicenseId`='$licenseId'";

    // Execute the query
    $result = $conn->query($sqlup);

    // Check if the query was successful
    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Record updated successfully.');</script>";
        header("refresh:2; url=./vendorTableView.php"); // Redirect after 2 seconds
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

// Check if 'LicenseId' is passed in the URL for updating a specific vendor record
if (isset($_GET['LicenseId'])) {
    $licenseId = $_GET['LicenseId'];

    // SQL query to fetch the record from the vendor table
    $sql = "SELECT * FROM `vendor` WHERE `LicenseId`='$licenseId'";
    $result = $conn->query($sql);

    // If the record exists, populate the form with the existing data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['Name'];
            $address = $row['Address'];
            $regDate = $row['RegDate'];
            $vendorType = $row['VendorType'];
        }
?>

<!-- HTML form for updating the vendor record -->
<html>
<head>
    <title>Vendor Update Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Update Vendor Record</h2>

        <form action="" method="post">
            <fieldset>
                <legend>Vendor Information:</legend>

                <!-- Hidden field to pass the LicenseId -->
                <input type="hidden" name="LicenseId" value="<?php echo $licenseId; ?>">

                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="Name" value="<?php echo $name; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Address">Address:</label>
                    <input type="text" class="form-control" name="Address" value="<?php echo $address; ?>" required>
                </div>

                <div class="form-group">
                    <label for="RegDate">Registration Date:</label>
                    <input type="date" class="form-control" name="RegDate" value="<?php echo $regDate; ?>" required>
                </div>

                <div class="form-group">
                    <label for="VendorType">Vendor Type:</label>
                    <input type="text" class="form-control" name="VendorType" value="<?php echo $vendorType; ?>" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Update" name="update">
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php
    } else {
        header('Location: vendorTableView.php'); // Redirect if no record is found
    }
}
?>
