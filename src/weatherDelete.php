<?php
include "db.php";

if (isset($_GET['id'])) {

    $consumerId = $_GET['id'];

    // Delete query
    $sql = "DELETE FROM `consumer` WHERE `ConsumerID`='$consumerId'";
    $result = $conn->query($sql);

    if ($result === TRUE) {
        echo '<div class="alert alert-success" role="alert">Consumer record deleted successfully!</div>';
        // Redirect back to consumer table view
        header("refresh:2; url=./consumerTableView.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    // If no id is passed, redirect back
    header("Location: consumerTableView.php");
}

$conn->close();
?>
