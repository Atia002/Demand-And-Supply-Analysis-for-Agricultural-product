<?php

include "db.php";

if (isset($_GET['Name'])) {

    $user_name = $_GET['Name'];

    $sql = "DELETE FROM `product` WHERE `Name`='$user_name";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}