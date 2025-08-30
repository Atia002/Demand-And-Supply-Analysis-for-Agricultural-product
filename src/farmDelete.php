<?php
include "db.php";

if (isset($_GET['id'])) {
    $farmId = $_GET['id'];

    // SQL delete query
    $sqldel = "DELETE FROM `farm` WHERE `Farm_Id`='$farmId'";

    if ($conn->query($sqldel) === TRUE) {
        echo '<div class="alert alert-success" role="alert">';
        echo "Farm record deleted successfully.";
        echo '</div>';
        // Redirect back to farmTableView
        header("refresh:2; url=./farmTableView.php");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    // If no id found in URL
    header("Location: farmTableView.php");
}

$conn->close();
?>
