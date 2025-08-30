<?php
include "db.php";

if (isset($_POST['submit'])) {

  $licenseId = $_POST['LicenseId'];
  $name = $_POST['Name'];
  $address = $_POST['address'];
  $regDate = $_POST['RegDate'];
  $vendorType = $_POST['VendorType'];

  // Insert into vendor table
  $sql = "INSERT INTO `vendor` (`LicenseId`, `Name`, `address`, `RegDate`, `VendorType`) 
          VALUES ('$licenseId', '$name', '$address', '$regDate', '$vendorType')";

  $result = $conn->query($sql);

  if ($result == TRUE) {
    echo '<div class="alert alert-success" role="alert">New vendor record created successfully!</div>';
    echo "<script>console.log('New vendor record created successfully!');</script>";
    header("refresh:2; url=./vendorTableView.php"); // Redirect after 2 seconds
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Vendor Entry Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-4">
    <h2>Vendor Entry Form</h2>

    <form action="" method="POST">
      <fieldset>
        <legend>Vendor Information:</legend>

        <div class="form-group">
          <label for="LicenseId">License ID:</label>
          <input type="text" class="form-control" name="LicenseId" id="LicenseId" required>
        </div>

        <div class="form-group">
          <label for="Name">Name:</label>
          <input type="text" class="form-control" name="Name" id="Name" required>
        </div>

        <div class="form-group">
          <label for="address">Address:</label>
          <input type="text" class="form-control" name="address" id="address" required>
        </div>

        <div class="form-group">
          <label for="RegDate">Registration Date:</label>
          <input type="date" class="form-control" name="RegDate" id="RegDate" required>
        </div>

        <div class="form-group">
          <label for="VendorType">Vendor Type:</label>
          <input type="text" class="form-control" name="VendorType" id="VendorType" required>
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
      </fieldset>
    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
