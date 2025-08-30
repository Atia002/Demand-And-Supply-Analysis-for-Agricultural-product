<?php
include "db.php";

$sql = "SELECT `Record_Id` AS recordId, `Date`, `Price_Type` AS priceType, `Product_Id` AS productId, `Price_Value` AS priceValue 
        FROM `price_record`";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>View Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Price Records</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Record_Id</th>
                    <th>Date</th>
                    <th>Price_Type</th>
                    <th>Product_Id</th>
                    <th>Price_Value</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['recordId']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['priceType']; ?></td>
                            <td><?php echo $row['productId']; ?></td>
                            <td><?php echo $row['priceValue']; ?></td>
                            <td>
                                <a class="btn btn-info" href="productionUpdate.php?id=<?php echo $row['recordId']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="ProductionDelete.php?id=<?php echo $row['recordId']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <a style="color:black;" class="btn btn-warning" href="productionAdd.php"><b>Add</b></a>
    </div>

</body>

</html>
