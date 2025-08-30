<?php
include "db.php";

if (isset($_POST['update'])) {

    $ConsumerID = $_POST['user_ConsumerID'];
    $Name       = $_POST['Name'];
    $Contact    = $_POST['Contact'];
    $Email      = $_POST['Email'];
    $Region     = $_POST['Region'];
    $Address    = $_POST['Address'];
    $feedback   = $_POST['feedback'];

    $sqlup = "UPDATE `consumer` 
              SET `Name`='$Name', `Contact`='$Contact', `Email`='$Email', `Region`='$Region', `Address`='$Address', `feedback`='$feedback' 
              WHERE `ConsumerID`='$ConsumerID'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Consumer record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Consumer record updated successfully.');</script>";
        header("refresh:2; url=./consumerList.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }

}

if (isset($_GET['id'])) {
    $ConsumerID = $_GET['id'];

    $sql = "SELECT * FROM `consumer` WHERE `ConsumerID`='$ConsumerID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Name     = $row['Name'];
            $Contact  = $row['Contact'];
            $Email    = $row['Email'];
            $Region   = $row['Region'];
            $Address  = $row['Address'];
            $feedback = $row['feedback'];
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Consumer Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Update Consumer Record</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Consumer Information:</legend>

            <input type="hidden" name="user_ConsumerID" value="<?php echo $ConsumerID; ?>">

            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>" required>
            </div>

            <div class="form-group">
                <label for="Contact">Contact:</label>
                <input type="text" class="form-control" name="Contact" value="<?php echo $Contact; ?>" required>
            </div>

            <div class="form-group">
                <label for="Email">Email:</label>
                <input type="email" class="form-control" name="Email" value="<?php echo $Email; ?>" required>
            </div>

            <div class="form-group">
                <label for="Region">Region:</label>
                <input type="text" class="form-control" name="Region" value="<?php echo $Region; ?>" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>" required>
            </div>

            <div class="form-group">
                <label for="feedback">Feedback:</label>
                <textarea class="form-control" name="feedback" rows="3"><?php echo $feedback; ?></textarea>
            </div>

            <input type="submit" class="btn btn-primary" value="Update" name="update">
            <a href="consumerList.php" class="btn btn-default">Back</a>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
    } else {
        header('Location: consumerList.php');
    }
}
?>
