<?php
include "db.php";

if (isset($_POST['submit'])) {

  $name = $_POST['Name'];
  $type = $_POST['Type'];
  $variety = $_POST['Variety'];
  $sowingTime = $_POST['Sowing_Time'];
  $transplanting = $_POST['Transplanting'];
  $harvestTime = $_POST['Harvest_Time'];
  $perAcreSeed = $_POST['Per_Acre_Seed'];
  $farmId = $_POST['Farm_Id'];

  // Make sure the Product_ID is auto-increment in your database, so we don't include it in the insert statement
  $sql = "INSERT INTO `product` (`Name`, `Type`, `Variety`, `Sowing_Time`, `Transplanting`, `Harvest_Time`, `Per_Acre_Seed`, `Farm_Id`) 
          VALUES ('$name', '$type', '$variety', '$sowingTime', '$transplanting', '$harvestTime', '$perAcreSeed', '$farmId')";

  $result = $conn->query($sql);

  if ($result == TRUE) {
    echo '<div class="alert alert-success" role="alert">New product record created successfully!</div>';
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
  <title>Production Entry Form</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
  <div class="container mt-4">
    <h2>Production Entry Form</h2>

    <form action="" method="POST">
      <fieldset>
        <legend>Production Information:</legend>

        <div class="form-group">
          <label for="Name">Name:</label>
          <input type="text" class="form-control" name="Name" id="Name" required>
        </div>

        <div class="form-group">
          <label for="Type">Type:</label>
          <input type="text" class="form-control" name="Type" id="Type" required>
        </div>

        <div class="form-group">
          <label for="Variety">Variety:</label>
          <input type="text" class="form-control" name="Variety" id="Variety" required>
        </div>

        <div class="form-group">
          <label for="Sowing_Time">Sowing Time:</label>
          <input type="text" class="form-control" name="Sowing_Time" id="Sowing_Time" required>
        </div>

        <div class="form-group">
          <label for="Transplanting">Transplanting:</label>
          <input type="text" class="form-control" name="Transplanting" id="Transplanting" required>
        </div>

        <div class="form-group">
          <label for="Harvest_Time">Harvest Time:</label>
          <input type="text" class="form-control" name="Harvest_Time" id="Harvest_Time" required>
        </div>

        <div class="form-group">
          <label for="Per_Acre_Seed">Per Acre Seed:</label>
          <input type="number" step="0.01" class="form-control" name="Per_Acre_Seed" id="Per_Acre_Seed" required>
        </div>

        <div class="form-group">
          <label for="Farm_Id">Farm ID:</label>
          <input type="text" class="form-control" name="Farm_Id" id="Farm_Id" required>
        </div>

        <input type="submit" name="submit" value="Submit" class="btn btn-primary">
      </fieldset>
    </form>
  </div>

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>

