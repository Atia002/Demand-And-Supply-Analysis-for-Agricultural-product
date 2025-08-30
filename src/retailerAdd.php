<?php
include "db.php";

if (isset($_POST['submit'])) {

  // Collect the store type from the form
  $storeType = $_POST['storeType'];
  
  // Insert into retailer table
  $sql = "INSERT INTO `retailer` (`storeType`) 
          VALUES ('$storeType')";

  $result = $conn->query($sql);

  if ($result == TRUE) {
    echo '<div class="alert alert-success" role="alert">New retailer record created successfully!</div>';
    echo "<script>console.log('New retailer record created successfully!');</script>";
    header("refresh:2; url=./retailerTableView.php"); // Redirect after 2 seconds
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Retailer Entry Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-4">
    <h2>Retailer Entry Form</h2>

    <form action="" method="POST">
      <fieldset>
        <legend>Retailer Information:</legend>

        <div class="form-group">
          <label for="storeType">Store Type:</label>
          <input type="text" class="form-control" name="storeType" id="storeType" required>
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
      </fieldset>
    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>