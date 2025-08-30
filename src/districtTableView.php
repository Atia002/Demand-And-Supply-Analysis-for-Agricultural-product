<?php

include "./db.php";

$sql = "SELECT DistrictID, Name, Division FROM District";

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

        <h2>Users</h2>

        <table class="table">

            <thead>

                <tr>
                    <th>DistrictID</th>

                    <th>Name</th>

                    <th>Division</th>

                    
                </tr>

            </thead>

            <tbody>

                <?php

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>

                        <tr>

                            <td><?php echo $row['DistrictID']; ?></td>

                            <td><?php echo $row['Name']; ?></td>

                            <td><?php echo $row['Division']; ?></td>

                            

                            <td>
                                <a class="btn btn-info" href="update.php?id=<?php echo $row['ID']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="delete.php?id=<?php echo $row['ID']; ?>">Delete</a>
                            </td>

                        </tr>

                <?php   }
                }
                $conn->close();
                ?>

            </tbody>

        </table>
        <a style="color:black;" class="btn btn-warning" href="form.php"><b>Add Farmer</b></a>
    </div>

</body>

</html>