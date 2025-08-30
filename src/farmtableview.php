<?php
include "db.php";


$sql = "SELECT 'Farm_Id' AS farmId ,'Address'  AS address , 'Farmer_Id' AS farmerId , FROM 'farm'";

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
                    <th>Farm_Id</th>

                    <th>Address</th>
                    <th>Farmer_Id</th>

                    

                    
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
                                <a class="btn btn-info" href="productionUpdate.php?id=<?php echo $row['Batch No']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="ProductionDelete.php?id=<?php echo $row['Batch No']; ?>">Delete</a>
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