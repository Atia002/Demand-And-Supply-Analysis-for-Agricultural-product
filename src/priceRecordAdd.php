<?php
include "db.php";

if (isset($_POST['submit'])) {

  $recordId = $_POST['Record_Id'];
  $date = $_POST['Date'];
  $priceValue = $_POST['Price_Value'];
  $priceType = $_POST['Price_Type'];
  $productId = $_POST['Product_Id'];

  // Make sure the Record_Id is auto-incremented or handled appropriately
  $sql = "INSERT INTO `price_record` (`Record_Id`, `Date`, `Price_Value`, `Price_Type`, `Product_Id`) 
          VALUES ('$recordId', '$date', '$priceValue', '$priceType', '$productId')";

  $result = $conn->query($sql);

  if ($result == TRUE) {
    echo '<div class="alert alert-success" role="alert">New price record created successfully!</div>';
    echo "<script>console.log('New record created successfully!');</script>";
    header("refresh:2; url=./productionTableView.php"); // Redirect after 2 seconds
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
  <title>Price Record Entry Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-4">
    <h2>Price Record Entry Form</h2>

    <form action="" method="POST">
      <fieldset>
        <legend>Price Record Information:</legend>

        <div class="form-group">
          <label for="Record_Id">Record ID:</label>
          <input type="text" class="form-control" name="Record_Id" id="Record_Id" required>
        </div>

        <div class="form-group">
          <label for="Date">Date:</label>
          <input type="date" class="form-control" name="Date" id="Date" required>
        </div>

        <div class="form-group">
          <label for="Price_Value">Price Value:</label>
          <input type="number" step="0.01" class="form-control" name="Price_Value" id="Price_Value" required>
        </div>

        <div class="form-group">
          <label for="Price_Type">Price Type:</label>
          <input type="text" class="form-control" name="Price_Type" id="Price_Type" required>
        </div>

        <div class="form-group">
          <label for="Product_Id">Product ID:</label>
          <input type="text" class="form-control" name="Product_Id" id="Product_Id" required>
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
      </fieldset>
    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
