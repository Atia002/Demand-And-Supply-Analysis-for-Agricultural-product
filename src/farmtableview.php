<?php
include "db.php";

// Correct SQL query
$sql = "SELECT Farm_Id AS farmId, Address AS address, Farmer_Id AS farmerId FROM farm";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farm Records</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Farm Records</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Farm_Id</th>
                    <th>Address</th>
                    <th>Farmer_Id</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['farmId']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['farmerId']; ?></td>
                            <td>
                                <a class="btn btn-info" href="farmUpdate.php?id=<?php echo $row['farmId']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="farmDelete.php?id=<?php echo $row['farmId']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php   
                    }
                } else {
                    echo "<tr><td colspan='4'>No records found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a style="color:black;" class="btn btn-warning" href="farmAdd.php"><b>Add Farm</b></a>
    </div>
</body>
</html>
