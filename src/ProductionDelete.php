<?php

include "db.php";

if (isset($_GET['Batch_No'])) {

    $user_batchNo = $_GET['Batch_No'];

    $sql = "DELETE FROM `production` WHERE `Batch No`='$user_batchNo";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}