<?php
require 'connection.php';
if (isset($_SESSION['user_id']) && isset($_GET['userID']) && $_SESSION["user_role"] == 1) {
    $userID = $_GET['userID'];
    $query = "UPDATE `user` SET `banned` = '1' WHERE `user`.`id` = '$userID'";
    $result = mysqli_query($con, $query);
}
