<?php
include "db.php";

if (isset($_POST['update'])) {

    // Get form data
    $name = $_POST['Name'];
    $user_productID = $_POST['user_Product_ID'];
    $type = $_POST['Type'];
    $variety = $_POST['Variety'];
    $sowingTime = $_POST['Sowing_Time'];
    $transplanting = $_POST['Transplanting'];
    $harvestTime = $_POST['Harvest_Time'];
    $perAcreSeed = $_POST['Per_Acre_Seed'];
    $farm_Id = $_POST['Farm_Id'];

    // Update query for the product table
    $sqlup = "UPDATE `product` 
              SET `Name`='$name', `Type`='$type', `Variety`='$variety', `Sowing_Time`='$sowingTime', 
                  `Transplanting`='$transplanting', `Harvest_Time`='$harvestTime', 
                  `Per_Acre_Seed`='$perAcreSeed', `Farm_Id`='$farm_Id' 
              WHERE `Product_ID`='$user_productID'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Record updated successfully.');</script>";
        header("refresh:2; url=./productTableView.php"); // Redirect after 2 seconds
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['productID'])) {
    $productID = $_GET['productID'];

    // Fetch existing data for the given product
    $sql = "SELECT * FROM `product` WHERE `Product_ID`='$productID'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $name = $row['Name'];
            $type = $row['Type'];
            $variety = $row['Variety'];
            $sowingTime = $row['Sowing_Time'];
            $transplanting = $row['Transplanting'];
            $harvestTime = $row['Harvest_Time'];
            $perAcreSeed = $row['Per_Acre_Seed'];
            $farm_Id = $row['Farm_Id'];
        }
?>

<html>
<head>
    <title>Product Update Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Update Product Record</h2>

        <form action="" method="post">
            <fieldset>
                <legend>Product Information:</legend>

                <!-- Hidden Field for Product ID -->
                <input type="hidden" name="user_Product_ID" value="<?php echo $productID; ?>">

                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="Name" value="<?php echo $name; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Type">Type:</label>
                    <input type="text" class="form-control" name="Type" value="<?php echo $type; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Variety">Variety:</label>
                    <input type="text" class="form-control" name="Variety" value="<?php echo $variety; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Sowing_Time">Sowing Time:</label>
                    <input type="text" class="form-control" name="Sowing_Time" value="<?php echo $sowingTime; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Transplanting">Transplanting:</label>
                    <input type="text" class="form-control" name="Transplanting" value="<?php echo $transplanting; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Harvest_Time">Harvest Time:</label>
                    <input type="text" class="form-control" name="Harvest_Time" value="<?php echo $harvestTime; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Per_Acre_Seed">Per Acre Seed:</label>
                    <input type="number" class="form-control" name="Per_Acre_Seed" value="<?php echo $perAcreSeed; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Farm_Id">Farm ID:</label>
                    <input type="text" class="form-control" name="Farm_Id" value="<?php echo $farm_Id; ?>" required>
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