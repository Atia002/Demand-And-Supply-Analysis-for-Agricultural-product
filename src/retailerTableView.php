<?php
include "db.php";

$sql = "SELECT 'Store Type' AS StoreType  FROM `retailer`";

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
                    <th>Store Type</th>
                    
                   
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['StoreType']; ?></td>
                                                       
                            <td>
                                <a class="btn btn-info" href="retailerUpdate.php?id=<?php echo $row['Store Type']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="retailerDelete.php?id=<?php echo $row['Store Type']; ?>">Delete</a>
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
        <a style="color:black;" class="btn btn-warning" href="retailerAdd.php"><b>Add Retailer</b></a>
    </div>

</body>

</html>

   
