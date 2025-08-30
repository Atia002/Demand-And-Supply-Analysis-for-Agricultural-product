<?php
include "db.php";

if (isset($_POST['submit'])) {

  $batchNo = $_POST['Batch_No'];

  $Year = $_POST['Year'];

  $Season = $_POST['Season'];

  $AcreAge = $_POST['AcerAge'];

  $Quantity = $_POST['Quantity'];

  

  $sql = "INSERT INTO `Production`(`Batch_No`, `Year`, `Season`, `AcerAge`, `Quantity`) VALUES ('$batchNo','$Year','$Season','$AcreAge','$Quantity')";

  $result = $conn->query($sql);

  if ($result == TRUE) {

    echo '<div class="alert alert-success" role="alert">New record created successfully!</div>';
    echo "<script>console.log('New record created successfully!');</script>";
    header("refresh:2; url=./productionTableView.php");
  } else {

    echo "Error:" . $sql . "<br>" . $conn->error;
  }

  $conn->close();
}
?>

<!DOCTYPE html>

<html>

<head>
  <title>Signup Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
  <div class="container mt-4">
    <h2>Production Entry Form</h2>

    <form action="" method="POST">
      <fieldset>
        <legend>Production Information:</legend>

        <div class="form-group">
          <label for="Batch_No">Batch No:</label>
          <input type="text" class="form-control" name="batchNo" id="batchNo" required>
        </div>

        <div class="form-group">
          <label for="Year">Year:</label>
          <input type="number" class="form-control" name="Year" id="Year" required>
        </div>

        <div class="form-group">
          <label for="Season">Season:</label>
          <input type="text" class="form-control" name="Season" id="Season" required>
        </div>

        <div class="form-group">
          <label for="AcreAge">Acre Age:</label>
          <input type="number" step="0.01" class="form-control" name="AcreAge" id="AcreAge" required>
        </div>

        <div class="form-group">
          <label for="Quantity">Quantity:</label>
          <input type="number" step="0.01" class="form-control" name="Quantity" id="Quantity" required>
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
      </fieldset>
    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>