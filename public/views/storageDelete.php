<?php

include "db.php";

if (isset($_GET['storageID'])) {

    $user_batchNo = $_GET['storageID'];

    $sql = "DELETE FROM `storage` WHERE `storageID`='$user_storageID";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}