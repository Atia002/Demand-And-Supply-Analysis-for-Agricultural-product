<?php

include "db.php";

if (isset($_GET['farmerid'])) {

    $user_batchNo = $_GET['farmerid'];

    $sql = "DELETE FROM `consumer` WHERE `farmerid`='$user_Faemer_ID";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}