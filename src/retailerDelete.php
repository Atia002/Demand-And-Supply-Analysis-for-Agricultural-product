<?php

include "db.php";

if (isset($_GET['Store Type'])) {

    $user_storeType = $_GET['Store Type'];

    $sql = "DELETE FROM `retailer` WHERE `Store Type`='$user_storeType'";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}