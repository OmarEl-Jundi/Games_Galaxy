<?php
session_start();
require 'connection.php';

if (isset($_POST['friendRequestID'])) {
    $friendID = $_POST['friendRequestID'];
    $userID = $_SESSION["user_id"];

    $sql = "DELETE FROM friend_request WHERE sender_id = '$friendID' AND receiver_id = '$userID'";
    $result = mysqli_query($con, $sql);

    $removeNotification = "DELETE FROM notifications WHERE u_id = '$userID' AND type = 'friend_request' AND related_id = '$friendID'";
    mysqli_query($con, $removeNotification);

    if ($result) {
        http_response_code(200);
    } else {
        http_response_code(400);
    }
} else {
    http_response_code(401);
}
