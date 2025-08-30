<?php
include "db.php";

$sql = "SELECT `Product_ID` AS productId, `Name`, `Type`, `Variety`, `Sowing_Time` AS sowingTime, 
        `Transplanting`, `Harvest_Time` AS harvestTime, `Per_Acre_Seed` AS perAcreSeed, `Farm_Id` AS farmId 
        FROM `product`";

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
        <h2>Products</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Product_ID</th>
                    <th>Name</th>
                    <th>Type</th>
                    <th>Variety</th>
                    <th>Sowing_Time</th>
                    <th>Transplanting</th>
                    <th>Harvest_Time</th>
                    <th>Per_Acre_Seed</th>
                    <th>Farm_Id</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['productId']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Type']; ?></td>
                            <td><?php echo $row['Variety']; ?></td>
                            <td><?php echo $row['sowingTime']; ?></td>
                            <td><?php echo $row['Transplanting']; ?></td>
                            <td><?php echo $row['harvestTime']; ?></td>
                            <td><?php echo $row['perAcreSeed']; ?></td>
                            <td><?php echo $row['farmId']; ?></td>

                            <td>
                                <a class="btn btn-info" href="productionUpdate.php?id=<?php echo $row['productId']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="ProductionDelete.php?id=<?php echo $row['productId']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='10'>No records found.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
        <a style="color:black;" class="btn btn-warning" href="productionAdd.php"><b>Add</b></a>
    </div>

</body>
</html>
