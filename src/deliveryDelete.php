<?php
include "db.php";

if (isset($_GET['id'])) {

    $deliveryId = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM `delivery` WHERE `DeliveryID`='$deliveryId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">Delivery record deleted successfully!</div>';
        // Redirect back to delivery view page
        header("refresh:2; url=./deliveryView.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} else {
    // If no id is passed, redirect back
    header("Location: deliveryView.php");
}

$conn->close();
?>
