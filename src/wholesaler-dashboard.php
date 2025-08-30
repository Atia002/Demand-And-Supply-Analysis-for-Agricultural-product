<?php
require_once 'db.php';
session_start();

// Ensure the user is logged in and is a wholesaler
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'Wholesaler') {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];
$userName = $_SESSION['user_name'];

// Fetch wholesaler information
$stmt = $conn->prepare("SELECT * FROM vendor v 
                       JOIN wholesaler w ON v.license_id = w.license_id 
                       WHERE v.license_id = ?");
$stmt->bind_param("s", $userId);
$stmt->execute();
$wholesalerInfo = $stmt->get_result()->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wholesaler Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>
    
    <main class="container mt-4">
        <h1>Welcome, <?php echo htmlspecialchars($wholesalerInfo['name']); ?></h1>
        
        <!-- Display Wholesaler Information -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Wholesaler Information</h2>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>License ID:</strong> <?php echo htmlspecialchars($wholesalerInfo['license_id']); ?></p>
                        <p><strong>Name:</strong> <?php echo htmlspecialchars($wholesalerInfo['name']); ?></p>
                        <p><strong>Address:</strong> <?php echo htmlspecialchars($wholesalerInfo['address']); ?></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Registration Date:</strong> <?php echo htmlspecialchars($wholesalerInfo['reg_date']); ?></p>
                        <p><strong>Min Order Quantity:</strong> <?php echo htmlspecialchars($wholesalerInfo['min_order_quantity']); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Vendor Information -->
        <section class="card mb-4">
            <div class="card-header">
                <h2>Vendor Information</h2>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>LicenseID</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>RegDate</th>
                            <th>VendorType</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT LicenseID, Name, address, RegDate, VendorType FROM `vendor`";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                        ?>
                            <tr>
                                <td><?php echo $row['LicenseID']; ?></td>
                                <td><?php echo $row['Name']; ?></td>
                                <td><?php echo $row['address']; ?></td>
                                <td><?php echo $row['RegDate']; ?></td>
                                <td><?php echo $row['VendorType']; ?></td>
                                <td>
                                    <a class="btn btn-info" href="vendorUpdate.php?id=<?php echo $row['LicenseID']; ?>">Edit</a>&nbsp;
                                    <a class="btn btn-danger" href="vendorDelete.php?id=<?php echo $row['LicenseID']; ?>">Delete</a>
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
                <a class="btn btn-warning" href="vendorAdd.php"><b>Add Wholsaler</b></a>
            </div>
        </section>
    </main>

    <?php include 'includes/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>



<?php
include "db.php";

if (isset($_POST['submit'])) {

    $licenseId = $_POST['LicenseId'];
    $name = $_POST['Name'];
    $address = $_POST['address'];
    $regDate = $_POST['RegDate'];
    $vendorType = $_POST['VendorType'];

    // Insert into vendor table
    $sql = "INSERT INTO `vendor` (`LicenseId`, `Name`, `address`, `RegDate`, `VendorType`) 
            VALUES ('$licenseId', '$name', '$address', '$regDate', '$vendorType')";

    $result = $conn->query($sql);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">New vendor record created successfully!</div>';
        header("refresh:2; url=wholesalerDashboard.php"); // Redirect after 2 seconds
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vendor Entry Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-4">
        <h2>Vendor Entry Form</h2>

        <form action="" method="POST">
            <fieldset>
                <legend>Vendor Information:</legend>

                <div class="form-group">
                    <label for="LicenseId">License ID:</label>
                    <input type="text" class="form-control" name="LicenseId" id="LicenseId" required>
                </div>

                <div class="form-group">
                    <label for="Name">Name:</label>
                    <input type="text" class="form-control" name="Name" id="Name" required>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" name="address" id="address" required>
                </div>

                <div class="form-group">
                    <label for="RegDate">Registration Date:</label>
                    <input type="date" class="form-control" name="RegDate" id="RegDate" required>
                </div>

                <div class="form-group">
                    <label for="VendorType">Vendor Type:</label>
                    <input type="text" class="form-control" name="VendorType" id="VendorType" required>
                </div>

                <input type="submit" name="submit" value="Submit" class="btn btn-primary">
            </fieldset>
        </form>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>



<?php
include "db.php";

if (isset($_POST['update'])) {

    $licenseId = $_POST['LicenseId'];
    $name = $_POST['Name'];
    $address = $_POST['Address'];
    $regDate = $_POST['RegDate'];
    $vendorType = $_POST['VendorType'];

    // SQL query to update the vendor table
    $sqlup = "UPDATE `vendor` 
              SET `Name`='$name', `Address`='$address', `RegDate`='$regDate', `VendorType`='$vendorType' 
              WHERE `LicenseId`='$licenseId'";

    $result = $conn->query($sqlup);

    if ($result == TRUE) {
        echo '<div class="alert alert-success" role="alert">Record updated successfully!</div>';
        header("refresh:2; url=wholesalerDashboard.php");
    } else {
        echo "Error: " . $sqlup . "<br>" . $conn->error;
    }
}

if (isset($_GET['LicenseId'])) 
    $licenseId = $_GET['LicenseId'];

    // Fetch vendor info for update
    $sql = "SELECT * FROM `vendor` WHERE `LicenseId`='$licenseId
}'";
    $result = $conn->query($sql);                                                                                                               