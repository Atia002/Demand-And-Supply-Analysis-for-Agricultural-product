<?php
include "db.php";


$sql = "SELECT 'Batch_No' as batchNo , Year, Season, AcerAge, Quantity  FROM Production";

$result = $conn->query($sql);

?>

<!DOCTYPE html>

<html>
/
<head>

    <title>View Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">

</head>

<body>

    <div class="container">

        <h2>Users</h2>

        <table class="table">

            <thead>

                <tr>
                    <th>Batch_No</th>

                    <th>Year</th>

                    <th>Season</th>

                    <th>AcerAge</th>

                    <th>Quantity</th>

                    
                </tr>

            </thead>

            <tbody>

                <?php

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>

                        <tr>

                            <td><?php echo $row['Batch_No']; ?></td>

                            <td><?php echo $row['Year']; ?></td>

                            <td><?php echo $row['Season']; ?></td>

                            <td><?php echo $row['AcerAge']; ?></td>

                            <td><?php echo $row['Quantity']; ?></td>

                            
                            <td>
                                <a class="btn btn-info" href="productionUpdate.php?id=<?php echo $row['Batch_No']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="ProductionDelete.php?id=<?php echo $row['Batch_No']; ?>">Delete</a>
                            </td>

                        </tr>

                <?php   }
                }
                $conn->close();
                ?>

            </tbody>

        </table>
        <a style="color:black;" class="btn btn-warning" href="productionAdd.php"><b>Add </b></a>
    </div>

</body>

</html>