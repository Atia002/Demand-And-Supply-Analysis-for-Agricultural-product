<?php
include "db.php";

// Correct SQL query
$sql = "SELECT DeliveryID, Date, TransportMode, Status, Type FROM delivery";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Delivery Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Delivery Records</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>DeliveryID</th>
                    <th>Date</th>
                    <th>Transport Mode</th>
                    <th>Status</th>
                    <th>Type</th>
                
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['DeliveryID']; ?></td>
                            <td><?php echo $row['Date']; ?></td>
                            <td><?php echo $row['TransportMode']; ?></td>
                            <td><?php echo $row['Status']; ?></td>
                            <td><?php echo $row['Type']; ?></td>
                            <td>
                                <a class="btn btn-info" href="deliveryUpdate.php?id=<?php echo $row['DeliveryID']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="deliveryDelete.php?id=<?php echo $row['DeliveryID']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php   
                    }
                } else {
                    echo "<tr><td colspan='6'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a style="color:black;" class="btn btn-warning" href="deliveryAdd.php"><b>Create Delivery</b></a>
    </div>
</body>
</html>
