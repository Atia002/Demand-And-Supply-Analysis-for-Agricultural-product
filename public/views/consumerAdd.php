<?php
include "db.php";

if (isset($_POST['submit'])) {

    $ConsumerID = $_POST['ConsumerID'];
    $Name       = $_POST['Name'];
    $Contact    = $_POST['Contact'];
    $Email      = $_POST['Email'];
    $Region     = $_POST['Region'];
    $Address    = $_POST['Address'];
    $feedback   = $_POST['feedback'];

    
    $sql = "INSERT INTO `Consumer`(`ConsumerID`, `Name`, `Contact`, `Email`, `Region`, `Address`, `feedback`) 
            VALUES ('$ConsumerID','$Name','$Contact','$Email','$Region','$Address','$feedback')";

    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">New consumer record created successfully!</div>';
        echo "<script>console.log('New consumer record created successfully!');</script>";
        header("refresh:2; url=./consumerTableView.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Consumer Signup Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Consumer Entry Form</h2>

    <form action="" method="POST">
        <fieldset>
            <legend>Consumer Information:</legend>

            <div class="form-group">
                <label for="ConsumerID">Consumer ID:</label>
                <input type="text" class="form-control" name="ConsumerID" id="ConsumerID" required>
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
                <label for="Email">Email:</label>
                <input type="email" class="form-control" name="Email" id="Email" required>
            </div>

            <div class="form-group">
                <label for="Region">Region:</label>
                <input type="text" class="form-control" name="Region" id="Region" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" class="form-control" name="Address" id="Address" required>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback:</label>
                <textarea class="form-control" name="feedback" id="feedback" rows="3"></textarea>
            </div>

            <input type="submit" name="submit" value="Submit" class="btn btn-primary">
        </fieldset>
    </form>
</div>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
