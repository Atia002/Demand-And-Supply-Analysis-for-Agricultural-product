<?php
include "db.php";

if (isset($_POST['submit'])) {

    $Faemer_ID = $_POST['Faemer_ID'];
    $Name = $_POST['Name'];
    $Contact = $_POST['Contact'];
    $Address = $_POST['Address'];
    $Year_of_experience = $_POST['Year_of_experience'];
    $Gender = $_POST['Gender'];

    // Insert query
    $sql = "INSERT INTO `farmer` (`Faemer_ID`, `Name`, `Contact`, `Address`, `Year_of_experience`, `Gender`) 
            VALUES ('$Faemer_ID', '$Name', '$Contact', '$Address', '$Year_of_experience', '$Gender')";

    if ($conn->query($sql) === TRUE) {
        echo '<div class="alert alert-success">New farmer added successfully!</div>';
        echo "<script>setTimeout(function(){ window.location.href='farmerList.php'; }, 2000);</script>";
    } else {
        echo '<div class="alert alert-danger">Error: ' . $conn->error . '</div>';
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Farmer</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <h2>Add Farmer</h2>
    <form method="POST" action="">
        <div class="form-group">
            <label for="Faemer_ID">Farmer ID:</label>
            <input type="text" class="form-control" name="Faemer_ID" id="Faemer_ID" required>
        </div>

        <div class="form-group">
            <label for="Name">Name:</label>
            <input type="text" class="form-control" name="Name" id="Name" required>
        </div>

        <div class="form-group">
            <label for="Contact">Contact:</label>
            <input type="text" class="form-control" name="Contact" id="Contact" required>
        </div>

        <div class="form-group">
            <label for="Address">Address:</label>
            <input type="text" class="form-control" name="Address" id="Address" required>
        </div>

        <div class="form-group">
            <label for="Year_of_experience">Years of Experience:</label>
            <input type="number" class="form-control" name="Year_of_experience" id="Year_of_experience" required>
        </div>

        <div class="form-group">
            <label for="Gender">Gender:</label>
            <select class="form-control" name="Gender" id="Gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>

        <input type="submit" name="submit" value="Add Farmer" class="btn btn-primary">
        <a href="farmerList.php" class="btn btn-default">Back</a>
    </form>
</div>
</body>
</html>
