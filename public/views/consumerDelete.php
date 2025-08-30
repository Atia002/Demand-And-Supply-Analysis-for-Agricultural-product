<?php

include "db.php";

if (isset($_GET['ConsumerID'])) {

    $user_batchNo = $_GET['ConsumerID'];

    $sql = "DELETE FROM `consumer` WHERE `ConsumerID`='$user_ConsumerID";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}