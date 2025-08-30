<?php

include "db.php";

if (isset($_GET['Price_Value'])) {

    $user_priceValue = $_GET['Price_Value'];

    $sql = "DELETE FROM `price_record` WHERE `Price_Value`='user_priceValue'";
    $result = $conn->query($sql);

    if ($result == TRUE) {

        echo '<div class="alert alert-success" role="alert">Record successfully deleted!</div>';
        header("refresh:2; url=./productionTableView.php");
    } else {

        echo "Error:" . $sql . "<br>" . $conn->error;
    }
}