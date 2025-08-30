<?php
include "db.php";

// ✅ Select actual columns from consumer table (no quotes around column names)
$sql = "SELECT ConsumerID, Name, Contact, Email, Region, Address, feedback 
        FROM consumer";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consumers</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" 
          href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h2>Consumer List</h2>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Consumer ID</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Region</th>
                    <th>Address</th>
                    <th>feedback</th>
                
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result && $result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['ConsumerID']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['Contact']; ?></td>
                            <td><?php echo $row['Email']; ?></td>
                            <td><?php echo $row['Region']; ?></td>
                            <td><?php echo $row['Address']; ?></td>
                            <td><?php echo $row['feedback']; ?></td>
                            <td>
                                <a class="btn btn-info" 
                                   href="consumerUpdate.php?id=<?php echo $row['ConsumerID']; ?>">Edit</a>
                                <a class="btn btn-danger" 
                                   href="consumerDelete.php?id=<?php echo $row['ConsumerID']; ?>">Delete</a>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>No consumers found</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>

        <a class="btn btn-warning" href="consumerAdd.php"><b>Add Consumer</b></a>
    </div>
</body>
</html>
