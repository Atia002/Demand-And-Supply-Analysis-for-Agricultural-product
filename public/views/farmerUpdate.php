<?php
include "db.php";

if (isset($_POST['update'])) {

    $Faemer_ID = $_POST['user_Faemer_ID'];
    $Name = $_POST['Name'];
    $Contact = $_POST['Contact'];
    $Address = $_POST['Address'];
    $Year_of_experience = $_POST['Year_of_experience'];
    $Gender = $_POST['Gender'];

    $sqlup = "UPDATE `farmer` 
              SET `Name`='$Name', `Contact`='$Contact', `Address`='$Address', `Year_of_experience`='$Year_of_experience', `Gender`='$Gender' 
              WHERE `Faemer_ID`='$Faemer_ID'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Farmer record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Farmer record updated successfully.');</script>";
        header("refresh:2; url=./farmerList.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['id'])) {
    $Faemer_ID = $_GET['id'];

    $sql = "SELECT * FROM `farmer` WHERE `Faemer_ID`='$Faemer_ID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Name = $row['Name'];
            $Contact = $row['Contact'];
            $Address = $row['Address'];
            $Year_of_experience = $row['Year_of_experience'];
            $Gender = $row['Gender'];
        }
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Farmer Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h2>Update Farmer Record</h2>

    <form action="" method="post">
        <fieldset>
            <legend>Farmer Information:</legend>

            <input type="hidden" name="user_Faemer_ID" value="<?php echo $Faemer_ID; ?>">

            <div class="form-group">
                <label for="Name">Name:</label>
                <input type="text" class="form-control" name="Name" value="<?php echo $Name; ?>" required>
            </div>

            <div class="form-group">
                <label for="Contact">Contact:</label>
                <input type="text" class="form-control" name="Contact" value="<?php echo $Contact; ?>" required>
            </div>

            <div class="form-group">
                <label for="Address">Address:</label>
                <input type="text" class="form-control" name="Address" value="<?php echo $Address; ?>" required>
            </div>

            <div class="form-group">
                <label for="Year_of_experience">Years of Experience:</label>
                <input type="number" class="form-control" name="Year_of_experience" value="<?php echo $Year_of_experience; ?>" required>
            </div>

            <div class="form-group">
                <label for="Gender">Gender:</label>
                <select class="form-control" name="Gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" <?php if($Gender=='Male') echo 'selected'; ?>>Male</option>
                    <option value="Female" <?php if($Gender=='Female') echo 'selected'; ?>>Female</option>
                    <option value="Other" <?php if($Gender=='Other') echo 'selected'; ?>>Other</option>
                </select>
            </div>

            <input type="submit" class="btn btn-primary" value="Update" name="update">
            <a href="farmerList.php" class="btn btn-default">Back</a>
        </fieldset>
    </form>
</div>
</body>
</html>

<?php
    } else {
        header('Location: farmerList.php');
    }
}
?>
