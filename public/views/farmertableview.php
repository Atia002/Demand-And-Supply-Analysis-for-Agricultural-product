<?php
include "db.php";

$sql = "SELECT Faemer_ID AS farmerid, Name, Address, Contact, Year_of_experience AS yearOfExperience, Gender
        FROM farmer";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Farmer List</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Farmer List</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Faemer_ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>Year_of_experience</th>
                    <th>Gender</th>
            
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['farmerid']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Contact']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><?php echo $row['yearOfExperience']; ?></td>
                            <td><?php echo $row['Gender']; ?></td>
                            <td>
                                <a class="btn btn-info" 
                                   href="farmerUpdate.php?id=<?php echo $row['farmerid']; ?>">Edit</a>
                                <a class="btn btn-danger" 
                                   href="farmerDelete.php?id=<?php echo $row['farmerid']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='7'>No farmers found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a class="btn btn-warning" href="farmerAdd.php"><b>Add Farmer</b></a>
    </div>
</body>
</html>
