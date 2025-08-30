<?php
include "db.php";


$sql = "SELECT storageID , ColdStorageCapacity , Address , productType , StockLevel  FROM storage";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Storage List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Storage List</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>storageID</th>
                    <th>ColdStorageCapacity</th>
                    <th>Address</th>
                    <th>productType</th>
                    <th>StockLevel</th>
                
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['storageID']; ?></td>
                            <td><?php echo $row['ColdStorageCapacity']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><?php echo $row['productType']; ?></td>
                            <td><?php echo $row['StockLevel']; ?></td>
                            <td>
                                <a class="btn btn-info" 
                                   href="storageUpdate.php?id=<?php echo $row['storageID']; ?>">Edit</a>
                                <a class="btn btn-danger" 
                                   href="storageDelete.php?id=<?php echo $row['storageID']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='6'>No storage records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a class="btn btn-warning" href="storageAdd.php"><b>Add Storage</b></a>
    </div>
</body>
</html>