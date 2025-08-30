<?php

include "db.php";

if (isset($_POST['update'])) {

    $Year = $_POST['Year'];

    $user_batchNo = $_POST['user_batchNo'];

    $Season = $_POST['Season'];

    $AcreAge = $_POST['Acreage'];

    $Quantity = $_POST['Quantity'];

    

    $sqlup = "UPDATE `production` SET `Year`='$Year',`Season`='$Season',`AcreAge`='$AcreAge',`Quantity`='$Quantity ' WHERE `user_batchNo'='$user_batchN'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">';
        echo 'Record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Record updated successfully.');</script>";
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['batchNo'])) {
    $batchNo = $_GET['batchNo'];

    $sql = "SELECT * FROM `Production` WHERE `Batch_no`='$batchNo'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $Year = $row['Year'];
            $Season = $row['Season'];
            $AcreAge = $row['AcerAge'];  
            $Quantity = $row['Quantity'];
        }
?>

     <html>
    <head>
        <title>Production Update Form</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    </head>

    <body>
        <div class="container mt-4">
            <h2>Update Production Record</h2>

            <form action="" method="post">
                <fieldset>
                    <legend>Production Information:</legend>

                    
                    <input type="hidden" name="user_batchNo" value="<?php echo $user_batchNo; ?>"> 
                    <div class="form-group">
                        <label for="Year">Year:</label>
                        <input type="number" class="form-control" name="Year" value="<?php echo $Year; ?>" required>
                    </div>

                    <div class="form-group">
                        <label for="Season">Season:</label>
                        <input type="text" class="form-control" name="Season" value="<?php echo $Season; ?>" required>
                    </div>

                <div class="form-group">
                        <label for="AcreAge">Acre Age:</label>
                        <input type="number" step="0.01" class="form-control" name="AcreAge" value="<?php echo $AcreAge; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Quantity">Quantity:</label>
                    <input type="number" step="0.01" class="form-control" name="Quantity" value="<?php echo $Quantity; ?>" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Update" name="update">
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php
    } else {
        header('Location: productionTableView.php');
    }
}
?>