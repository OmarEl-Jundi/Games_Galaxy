<?php
require 'connection.php';
session_start();
if (isset($_SESSION['user_id']) && isset($_GET['userID']) && $_SESSION["user_role"] == 1) {
    $userID = $_GET['userID'];
    $query = "UPDATE `user` SET `banned` = '0' WHERE `user`.`id` = '$userID'";
    $result = mysqli_query($con, $query);
    if ($result) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    } else {
        echo "Error updating user status: " . mysqli_error($con);
    }
}
