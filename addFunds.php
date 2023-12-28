<?php
session_start();
require 'connection.php';

if (isset($_SESSION['user_id']) && isset($_POST['amount'])) {
    $amount = $_POST['amount'];
    $id = $_SESSION['user_id'];
    $sql = "UPDATE `wallet` SET `amount`= amount + $amount WHERE `u_id` = $id";
    $result = mysqli_query($con, $sql);
    if ($result) {
        $sql = "SELECT * FROM `wallet` WHERE u_id = $id";
        $result = mysqli_query($con, $sql);
        $row = mysqli_fetch_assoc($result);
        http_response_code(200);
        echo  $row['amount'];
        exit();
    } else {
        http_response_code(500);
        exit();
    }
} else {
    exit();
}
