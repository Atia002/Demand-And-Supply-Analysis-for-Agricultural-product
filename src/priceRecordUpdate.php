<?php
include "db.php";

// Check if the update button is pressed
if (isset($_POST['update'])) {

    // Get the form data
    $date = $_POST['Date'];
    $user_recordId = $_POST['user_Record_Id'];
    $priceValue = $_POST['Price_Value'];
    $priceType = $_POST['Price_Type'];
    $productID = $_POST['Product_Id'];

    // SQL query to update the price_record table
    $sqlup = "UPDATE `price_record` 
              SET `Date`='$date', `Price_Value`='$priceValue', `Price_Type`='$priceType', `Product_Id`='$productID' 
              WHERE `Record_Id`='$user_recordId'";

    // Execute the query
    $result = $conn->query($sqlup);

    // Check if the query was successful
    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo 'Record updated successfully.';
        echo '</div>';
        echo "<script>console.log('Record updated successfully.');</script>";
        header("refresh:2; url=./priceRecordTableView.php"); // Redirect after 2 seconds
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

// Check if 'Record_Id' is passed in the URL for updating a specific record
if (isset($_GET['recordId'])) {
    $recordId = $_GET['recordId'];

    // SQL query to fetch the record from the price_record table
    $sql = "SELECT * FROM `price_record` WHERE `Record_Id`='$recordId'";
    $result = $conn->query($sql);

    // If the record exists, populate the form with the existing data
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $date = $row['Date'];
            $priceValue = $row['Price_Value'];
            $priceType = $row['Price_Type'];
            $productID = $row['Product_Id'];
        }
?>

<!-- HTML form for updating the price record -->
<html>
<head>
    <title>Price Record Update Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-4">
        <h2>Update Price Record</h2>

        <form action="" method="post">
            <fieldset>
                <legend>Price Record Information:</legend>

                <!-- Hidden field to pass the Record_Id -->
                <input type="hidden" name="user_Record_Id" value="<?php echo $recordId; ?>">

                <div class="form-group">
                    <label for="Date">Date:</label>
                    <input type="date" class="form-control" name="Date" value="<?php echo $date; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Price_Value">Price Value:</label>
                    <input type="number" step="0.01" class="form-control" name="Price_Value" value="<?php echo $priceValue; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Price_Type">Price Type:</label>
                    <input type="text" class="form-control" name="Price_Type" value="<?php echo $priceType; ?>" required>
                </div>

                <div class="form-group">
                    <label for="Product_Id">Product ID:</label>
                    <input type="text" class="form-control" name="Product_Id" value="<?php echo $productID; ?>" required>
                </div>

                <input type="submit" class="btn btn-primary" value="Update" name="update">
            </fieldset>
        </form>
    </div>
</body>
</html>

<?php
    } else {
        header('Location: priceRecordTableView.php'); // Redirect if no record is found
    }
}
?>
