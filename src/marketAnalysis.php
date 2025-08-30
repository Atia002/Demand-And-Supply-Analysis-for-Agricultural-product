<?php
include "db.php";


$priceSql = "SELECT Date, Product_Id, Price_Value, Price_Type FROM price_record ORDER BY Date DESC";
$priceResult = $conn->query($priceSql);
 

$wholesalerSql = "SELECT license_id, name, address, reg_date, min_order_quantity FROM wholesaler";
$wholesalerResult = $conn->query($wholesalerSql);

$retailerSql = "SELECT license_id, name, address, store_type FROM retailer";
$retailerResult = $conn->query($retailerSql);

$consumerSql = "SELECT consumer_id, name, region, contact, email FROM consumer";
$consumerResult = $conn->query($consumerSql);

?>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Product</th>
            <th>Price</th>
            <th>Type</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $priceResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['Date']; ?></td>
                <td><?php echo $row['Product_Id']; ?></td>
                <td><?php echo $row['Price_Value']; ?></td>
                <td><?php echo $row['Price_Type']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Wholesalers Table -->
<h3>Wholesalers</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>License ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Min Order Quantity</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $wholesalerResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['license_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['min_order_quantity']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Retailers Table -->
<h3>Retailers</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>License ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Store Type</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $retailerResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['license_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['address']; ?></td>
                <td><?php echo $row['store_type']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<!-- Consumers Table -->
<h3>Consumers</h3>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Region</th>
            <th>Contact</th>
            <th>Email</th>
        </tr>
    </thead>
    <tbody>
        <?php while($row = $consumerResult->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['consumer_id']; ?></td>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['region']; ?></td>
                <td><?php echo $row['contact']; ?></td>
                <td><?php echo $row['email']; ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
$conn->close();
?>


