<?php
include "db.php";

$sql = "SELECT LicenseID , Name, address, RegDate, VendorType  
        FROM `vendor`";

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
                    <th>LicenseID</th>
                    <th>Name</th>
                    <th>address</th>
                    <th>RegDate</th>
                    <th> VendorType</th>
                   
                </tr>
            </thead>

            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                ?>
                        <tr>
                            <td><?php echo $row['LicenseID']; ?></td>
                            <td><?php echo $row['Name']; ?></td>
                            <td><?php echo $row['address']; ?></td>
                            <td><?php echo $row['RegDate']; ?></td>
                            <td><?php echo $row[' VendorType']; ?></td>
                            <td>
                                <a class="btn btn-info" href="vendorUpdate.php?id=<?php echo $row['VendorType']; ?>">Edit</a>&nbsp;
                                <a class="btn btn-danger" href="vendorDelete.php?id=<?php echo $row['VendorType']; ?>">Delete</a>
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
        <a style="color:black;" class="btn btn-warning" href="vendorAdd.php"><b>Register Vendor</b></a>
    </div>

</body>

</html>
